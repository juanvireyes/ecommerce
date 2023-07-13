<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Storage;

class ReportReadyNotification extends Notification
{
    use Queueable;

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $fileName = 'Rotación Productos - ' . now()->format('d-m-Y') . '.xlsx';
        $filePath = Storage::path('exports/' . $fileName);

        return (new MailMessage)
                    ->subject('Reporte de productos listo para descargar')
                    ->line('El reporte de rotación de productos está listo para descargar')
                    ->attach($filePath, [
                        'as' => $fileName,
                        'mime' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                    ])
                    ->action('Descargar archivo', url(route('rep.products.download')))
                    ->line('Thank you for using our application!');
    }
}
