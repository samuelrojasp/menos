<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cuenta;
use \Freshwork\ChileanBundle\Rut;

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

        return view('menos.cuenta.cambiar_datos', [
            'user' => $user,
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

        return redirect('/mi_cuenta/resumen');
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

    public function updateTelephone(Request $request)
    {
        $data = $request->all();

        $token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_sid = getenv("TWILIO_SID");
        $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");
        $twilio = new Client($twilio_sid, $token);
        $twilio->verify->v2->services($twilio_verify_sid)
            ->verifications
            ->create($data['telephone'], "sms");
        
        return view('menos.cuenta.verificar_telefono', [
            'telephone' => $data['telephone']
        ]);
    }

    public function updateEmail(Request $request)
    {
        return true;
    }

    public function updatePassword(Request $request)
    {

    }
}
