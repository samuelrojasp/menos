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
            'telephone' => ['required', 'phone:AUTO'],
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
            'telephone' => $data['telephone'],
            'password' => Hash::make($data['password']),
        ]);

        return redirect()->route('verify')->with([
            'telephone' => $data['telephone'],
            'password' => $data['password']
        ]);
    }

    public function register(Request $request)
    {
        $data = $request;
        $telephone = '+'.$request->phonecode.$request->telephone;
        $password = rand(100000, 999999);

        $request->merge([
            'telephone' => $telephone,
            'password' => $password
        ]);

        $this->validator($request->all())->validate();

        //event(new Registered($user = $this->create($request->all())));

        return redirect()->route('verify')->with([
            'telephone' => $data['telephone'],
            'password' => $data['password']
        ]);
    }

    protected function verify(Request $request)
    {
        $inputs = $request;

        $data = $request->validate([
            'verification_code' => ['required', 'numeric']
        ]);

        $user = User::where('telephone', $inputs['telephone'])->first();

        /* Get credentials from .env */
        $token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_sid = getenv("TWILIO_SID");
        $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");
        $twilio = new Client($twilio_sid, $token);
        $verification = $twilio->verify->v2->services($twilio_verify_sid)
            ->verificationChecks
            ->create($data['verification_code'], array('to' => $user->telephone));

        if ($verification->valid) {
            
            $user->update(['is_verified' => true]);
            /* Authenticate user */
            Auth::login($user);

            $cuenta = new Cuenta;

            $cuenta->nombre = "Cuenta Primaria";
            $cuenta->user_id = $user->id;
            $cuenta->tipo_cuenta_id = 1;
            $cuenta->saldo = 0;
            $cuenta->save();

            return redirect('/mi_cuenta/resumen')->with(['message' => 'Teléfono Verificado']);
        }
        return back()->with(['telephone' => $data['telephone'], 'error' => '¡Código de verificación erróneo!']);
    }
}
