<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cuenta;
use \Freshwork\ChileanBundle\Rut;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Country;

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

        return view('menos.cuenta.resumen', [
            'user' => $user,
            'cuentas' => $cuentas
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
            'address1' => 'required',
            'city' => 'required',
            'state' => 'required',
            'countryid' => 'required',
            
        ]);
        
        $data = $request->all();

        $data["rut"] = Rut::parse($data["rut"])->normalize();

        $user->fill($data);
        $user->save();

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
        if($request->method() == 'POST'){
            $data = $request->all();

            $validation = $request->validate([
                'telephone' => 'required|phone:AUTO',            
            ]);

            $token = getenv("TWILIO_AUTH_TOKEN");
            $twilio_sid = getenv("TWILIO_SID");
            $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");
            $twilio = new Client($twilio_sid, $token);
            $twilio->verify->v2->services($twilio_verify_sid)
                ->verifications
                ->create($data['telephone'], "sms");
        }else{
            $data['telephone'] = session('telephone');
        }

        return view('menos.cuenta.verificar_telefono', [
            'telephone' => $data['telephone']
        ]);
    }

    protected function verifyPhone(Request $request)
    {
        $inputs = $request->all();

        $data = $request->validate([
            'verification_code' => ['required', 'numeric']
        ]);
        
        $user = auth()->user();

        /* Get credentials from .env */
        $token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_sid = getenv("TWILIO_SID");
        $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");
        $twilio = new Client($twilio_sid, $token);
        $verification = $twilio->verify->v2->services($twilio_verify_sid)
            ->verificationChecks
            ->create($data['verification_code'], array('to' => $inputs['telephone']));

        if ($verification->valid) {
            
            $user->update([
                'is_verified' => true,
                'telephone' => $inputs['telephone']
                ]);

            return redirect('/mi_cuenta/resumen')->with(['message' => 'Teléfono Verificado']);
        }else{
            return back()->with(['telephone' => $inputs['telephone'], 'error' => '¡Código de verificación erróneo!']);
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

        $user->sendEmailVerificationNotification();
        return redirect('/mi_cuenta/resumen');
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
            $user->password = Hash::make($inputs['new_password1']);

            $user->save();
        }else{
            return back()->with(['error' => 'Contraseña anterior incorrecta']);
        }

        Auth::logout();

        return redirect('/login');
    }
}
