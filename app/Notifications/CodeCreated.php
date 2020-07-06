<?php

namespace App\Notifications;

use App\Channels\Messages\WhatsAppMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Channels\WhatsAppChannel;
use App\CodigoVerificacion;


class CodeCreated extends Notification
{
  use Queueable;

  public $codigo_verificacion;
  
  public function __construct(CodigoVerificacion $codigo_verificacion)
  {
    $this->codigo_verificacion = $codigo_verificacion;
  }
  
  public function via($notifiable)
  {
    return [WhatsAppChannel::class];
  }
  
  public function toWhatsApp($notifiable)
  {


    return (new WhatsAppMessage)
        ->content("Su código de verificación en MENOS es {$this->codigo_verificacion->password}");
  }
}
