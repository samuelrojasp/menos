<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Twilio\Rest\Client;
use Illuminate\Http\Request;
use App\Cuenta;
use App\Country;
use App\CodigoVerificacion;
use Propaganistas\LaravelPhone\PhoneNumber;
use App\Notifications\CodeCreated;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/mi_cuenta/resumen';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        $countries = Country::all();

        return view('auth.register', [
            'countries' => $countries
        ]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'rut' => ['required', 'cl_rut', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'size:4', 'confirmed'],
            'username' => ['required', 'string', 'unique:users', 'max:255']
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        
        return User::create([
            'name' => $data['name'],
            'rut' => $data['rut'],
            'telephone' => $data['telephone'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'username' => $data['username']
        ]);
    }

    public function register(Request $request)
    {
        $data = $request;
        
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

        return redirect()->route('verify')->with([
            'telephone' => $data['telephone']
        ]);
    }

    public function verificationForm(Request $request)
    {
        $telephone = $request->session()->get('telephone');

        return view('auth.verify', [
            'telephone' => $telephone,
        ]);
    }

    protected function verify(Request $request)
    {
        $inputs = $request;

        $data = $request->validate([
            'verification_code' => ['required', 'numeric']
        ]);

        $codigo_verificacion = CodigoVerificacion::where('telephone', $inputs['telephone'])
                                                ->where('status', 1)
                                                ->orderBy('created_at', 'desc')
                                                ->first();

        if($inputs['verification_code'] != $codigo_verificacion->password){
            return back()->with(['telephone' => $inputs['telephone'], 'error' => '¡Código de verificación erróneo!']);
        }else{
            $user = User::where('telephone', $inputs['telephone'])->first();
            
            if($user === null){
                

                return redirect('/registrar_datos')->with(['telephone' => $inputs['telephone']]);
            }else{
                
                Auth::login($user);

                return redirect('/mi_cuenta/resumen')->with([
                    'success' => 'Bienvenido '.$user->name
                ]);
            }
        }
        
    }

    public function mostrarFormularioRegistro()
    {
        return view('auth.registrar');
    }

    public function registrar(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $cuenta = new Cuenta;
        $cuenta->nombre = "Cuenta Primaria";
        $cuenta->user_id = $user->id;
        $cuenta->tipo_cuenta_id = 1;
        $cuenta->saldo = 0;
        $cuenta->save();

        Auth::login($user);
        
        return redirect('/mi_cuenta/resumen')->with([
            'success' => 'Bienvenido '.$user->name
        ]);
    }
}
