<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Transaccion;

class TransferenciaRealizada extends Mailable
{
    use Queueable, SerializesModels;

    public $transaccion;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Transaccion $transaccion)
    {
        $this->transaccion = $transaccion;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('transferencia@menos.cl')
                    ->view('menos.email.transferencia');
    }
}
