<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cuenta;
use \Freshwork\ChileanBundle\Rut;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Country;
use App\UserAddress;
use App\CodigoVerificacion;
use App\Notifications\CodeCreated;
use App\User;
use App\Notificacion;
use App\Identificacion;

class DatosUsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        $cuentas = Cuenta::where('user_id', $user->id)->get();

        $user->rut = Rut::parse($user->rut)->format();

        $verificacion = $user->identificacion->last();

        return view('menos.cuenta.resumen', [
            'user' => $user,
            'cuentas' => $cuentas,
            'verificacion' => $verificacion,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $user = auth()->user();

        $user->rut = Rut::parse($user->rut)->format(Rut::FORMAT_WITH_DASH);

        $countries = Country::all();

        return view('menos.cuenta.cambiar_datos', [
            'user' => $user,
            'countries' => $countries,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        $validation = $request->validate([
            'name' => 'required',
            'rut' => 'required|unique:users,rut,'.$user->id.'|cl_rut',
            'birthday' => 'required|date',
        ]);
        
        $data = $request->all();

        $data["rut"] = Rut::parse($data["rut"])->normalize();

        $user->fill($data);
        $user->address1 = $data['autocomplete'];
        $user->address2 = $data['route']." ".$data['street_number'];
        $user->city = $data['locality'];
        $user->state = $data['administrative_area_level_1'];
        $user->countryid = $data['country'];
        $user->save();

        Notificacion::create([
            'text' => 'Has modificado tus datos de registro',
            'leido' => 0,
            'user_id' => $user->id
        ]);

        return redirect('/mi_cuenta/resumen')->with('success', '¡Datos actualizados exitosamente!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function seguridad()
    {
        return view('menos.cuenta.seguridad');
    }

    public function updateTelephone(Request $request)
    {
        $data = $request;

        session(['telephone' => $data->telephone]);
        
        $password = rand(100000, 999999);

        $request->merge([
            'password' => $password
        ]);

        $validatedData = $request->validate([
            'telephone' => ['required', 'phone:AUTO'],          
        ]);


        $limpiar = CodigoVerificacion::where('telephone', $data['telephone'])
                                        ->update(['status' => '0']);

        $verificacion = new CodigoVerificacion();

        $verificacion->telephone = $data['telephone'];
        $verificacion->password = $data['password'];

        $verificacion->save();

        $user = new User();
        $user->telephone = $request['telephone'];

        $user->notify(new CodeCreated($verificacion));

        return view('menos.cuenta.seguridad_phone_verify');
    }

    protected function verifyPhone(Request $request)
    {
        $inputs = $request;

        $data = $request->validate([
            'verification_code' => ['required', 'numeric']
        ]);

        $codigo_verificacion = CodigoVerificacion::where('telephone', $inputs['telephone'])
                                                ->where('status', 1)
                                                ->orderBy('created_at', 'desc')
                                                ->first();
        $user = auth()->user();

        if($inputs['verification_code'] == $codigo_verificacion->password){
            $user->telephone = $inputs['telephone'];
            $user->save();

            Notificacion::create([
                'text' => 'Has modificado tu numero de teléfono al '.$user->telephone,
                'leido' => 0,
                'user_id' => $user->id
            ]);

            return redirect('/mi_cuenta/resumen')->with(['success' => 'Teléfono Verificado']);
        }else{
            return redirect('/mi_cuenta/seguridad')->with(['telephone' => $inputs['telephone'], 'error' => '¡Código de verificación erróneo!']);
        }
    }

    public function updateEmail(Request $request)
    {
        $user = auth()->user();
        $inputs = $request->all();

        $data = $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id, 'confirmed'],
        ]);

        $user->email = $inputs['email'];
        $user->email_verified_at = null;
        $user->save();

        Notificacion::create([
            'text' => 'Has modificado tu email a '.$user->email,
            'leido' => 0,
            'user_id' => $user->id
        ]);

        $user->sendEmailVerificationNotification();
        return redirect('/mi_cuenta/resumen')->with('success', 'Email actualizado. Te enviamos un correo electrónico para verificarlo.');
    }

    public function verificacionEmail()
    {
        $user = auth()->user();

        $user->sendEmailVerificationNotification();
        return redirect('/mi_cuenta/resumen')->with('success', 'Te enviamos un correo electrónico para verificar tu email.');
    }

    public function updatePassword(Request $request)
    {
        $inputs = $request->all();

        $user = auth()->user();

        $data = $request->validate([
                'new_password' => ['required', 'string', 'size:4', 'confirmed', 'different:old_password'],
        ]);

        if(Hash::check($inputs['old_password'], $user->password))
        {
            $user->password = Hash::make($inputs['new_password']);

            $user->save();

            Notificacion::create([
                'text' => 'Has cambiado tu PIN de 4 dígitos',
                'leido' => 0,
                'user_id' => $user->id
            ]);
            
        }else{
            return back()->with(['error' => 'Contraseña anterior incorrecta']);
        }

        Auth::logout();

        return redirect('/login');
    }

    public function addressIndex()
    {
        $user = auth()->user();

        $addresses = UserAddress::where('parentid', $user->id)->get();

        return view('menos.cuenta.direcciones', [
            'user' => $user,
            'addresses' => $addresses,
        ]);
    }

    public function addressCreate()
    {
        $countries = Country::all();

        return view('menos.cuenta.direcciones_nueva', [
            'countries' => $countries
        ]);
    }

    public function addressStore(Request $request)
    {
        $user = auth()->user();

        $data = $request->all();

        $address = new UserAddress();

        $address->parentid = $user->id;
        $address->fill($data);
        $address->address1 = $data['autocomplete'];
        $address->address2 = $data['route']." ".$data['street_number'];
        $address->city = $data['locality'];
        $address->state = $data['administrative_area_level_1'];
        $address->countryid = $data['country'];

        $address->save();

        return redirect('/mi_cuenta/direcciones')->with(['success' => 'Se agregó una nueva dirección']);
    }

    public function addressDelete($id)
    {
        UserAddress::destroy($id);

        return redirect('mi_cuenta/direcciones')->with(['success' => 'Dirección eliminada']);
    }
}
