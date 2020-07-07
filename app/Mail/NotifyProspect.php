<?php

namespace App\Mail;

use App\Prospecto;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotifyProspect extends Mailable
{
    use Queueable, SerializesModels;


    public $prospecto;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Prospecto $prospecto)
    {
        $this->prospecto = $prospecto;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('noresponder@menos.cl')
                    ->view('menos.office.notify_prospect');
    }
}
