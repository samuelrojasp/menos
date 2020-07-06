<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use Konekt\Address\Models\CountryProxy;
use Vanilo\Cart\Contracts\CartManager;
use Vanilo\Checkout\Contracts\Checkout;
use Vanilo\Order\Contracts\OrderFactory;
use Illuminate\Support\Facades\Hash;
use App\Transaccion;
use App\Movimiento;
use App\Mail\TransferenciaRealizada;
use Illuminate\Support\Facades\Mail;
use App\Cuenta;
use App\Notificacion;
use App\User;

class CheckoutController extends Controller
{
    /** @var Checkout */
    private $checkout;

    /** @var Cart */
    private $cart;

    public function __construct(Checkout $checkout, CartManager $cart)
    {
        $this->checkout = $checkout;
        $this->cart     = $cart;
    }

    public function show()
    {
        $checkout = false;

        if ($this->cart->isNotEmpty()) {
            $checkout = $this->checkout;
            if ($old = old()) {
                $checkout->update($old);
            }

            $checkout->setCart($this->cart);
        }

        return view('checkout.show', [
            'checkout'  => $checkout,
            'countries' => CountryProxy::all(),
            'user' => auth()->user()
        ]);
    }

    public function submit(CheckoutRequest $request, OrderFactory $orderFactory)
    {
        $user = auth()->user();

        $total = $this->cart->total();

        if(!Hash::check($request->password, $user->password)){
            return redirect()->back()->with(['error' => '¡PIN incorrecto!']);
        }

        $cuenta_usuario_autenticado = Cuenta::where('user_id', $user->id)->first();

        $this->checkout->update($request->all());
        $this->checkout->setCustomAttribute('notes', $request->get('notes'));
        $this->checkout->setCart($this->cart);

        $order = $orderFactory->createFromCheckout($this->checkout);

        $transaccion = new Transaccion();

        $transaccion->tipo_transaccion_id = 4;
        $transaccion->glosa = "Compra  Orden Nº ".$order->number;
        $transaccion->save();

        $movimiento = new Movimiento();

        $movimiento->transaccion_id = $transaccion->id;
        $movimiento->glosa = $transaccion->glosa;
        $movimiento->cuenta_id = $cuenta_usuario_autenticado->id;
        $movimiento->importe = $total * -1;
        $movimiento->saldo_cuenta = $cuenta_usuario_autenticado->saldo - $total;
        $cuenta_usuario_autenticado->saldo = $cuenta_usuario_autenticado->saldo - $total;
        $movimiento->cargo_abono = 'cargo';

        $movimiento->save();
        $cuenta_usuario_autenticado->save();

        $email_recipients = array($user->email);

        if($request->otro_mail != null)
        {
            array_push($email_recipients, $request->otro_mail);
        }

        Notificacion::create([
            'text' => 'Compraste en la tienda',
            'leido' => 0,
            'user_id' => $user->id
        ]);

        Mail::to($email_recipients)->send(new TransferenciaRealizada($transaccion));

        $this->cart->destroy();

        return view('checkout.thankyou', ['order' => $order]);
    }

    public function apiGetByPhone($phone)
    {
        $user = User::where('telephone', $phone)
                    ->firstOrFail();

        return $user;
    }

}
