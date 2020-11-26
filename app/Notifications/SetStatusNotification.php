<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SetStatusNotification extends Notification
{
    use Queueable;

    private $type;
    private $seedling;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($type,$seedling)
    {
        $this->type = $type;
        $this->seedling = $seedling;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $message = "";
        if ($this->type == 1) {
            $message = "aprobada, ya haces parte del semillero";
        }else{
            $message = "rechazada, puede volver a enviar su solicitud";
        }
        return (new MailMessage)
                    ->greeting('Hola!')
                    ->subject('Solicitud de participación a semillero de investigación')
                    ->line('Tú solicitud de participación al semillero de investigación ' . $this->seedling . ' ha obtenido una respuesta')
                    ->line('Su solicitud fue ' .$message)
                    ->line('Gracias por usar nuestra aplicación!')
                    ->salutation('Saludos!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
