<?php

namespace App\Notifications;

use App\Channels\Messages\WhatsAppMessage;
use App\Channels\WhatsAppChannel;
use App\Models\License;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderValidated extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $license;
    public $order;

    public function __construct(License $license, Order $order)
    {
        $this->license = $license;
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [WhatsAppChannel::class];
    }

    public function toWhatsApp($notifiable)
    {
        // $orderUrl = url("/orders/{$this->order->id}");

        logger('Sending WhatsApp message...');
        $orderUrl = "http://10.220.103.115/storage/solicitantes/{$this->license->user_id}/licencias/{$this->license->id}/OC-{$this->license->folio}.pdf";
        // $orderUrl = url("/storage/solicitantes/{$this->license->user_id}/licencias/{$this->license->id}/OC-{$this->license->folio}.pdf");
        $total = number_format($this->order->total,2);
        $expirationDate = date('Y-m-d', strtotime($this->order->fecha_actualizacion. ' + 7 days'));
        return (new WhatsAppMessage)
            ->content("Permisos Capital De Zacatecas.
            Tu ordern de Pago con folio {$this->order->folio_api} por un monto total de {$total}, correspondiente al trámite con no de folio {$this->license->folio} ha sido generada; considera pagarla antes del día {$expirationDate};
            Por su atención, gracias.");
        // Detalles: {$orderUrl}
    }
}
