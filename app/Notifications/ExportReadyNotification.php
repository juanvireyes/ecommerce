<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Log;

class ExportReadyNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $fileName = 'products - ' . now()->format('d-m-Y') . '.xlsx';
        $filePath = Storage::path('exports/' . $fileName);
        
        return (new MailMessage)
            ->subject('Archivo listo para descargar')
            ->line('Tu archivo esta listo para ser descargado.')
            ->attach($filePath, [
                'as' => $fileName,
                'mime' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
            ])
            ->action('Descargar archivo', url(route('products.download')))
            ->line('Cualquier duda o comentario, ¡contactanos!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
