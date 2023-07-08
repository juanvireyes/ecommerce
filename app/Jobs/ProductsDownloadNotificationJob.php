<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\ExportReadyNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProductsDownloadNotificationJob implements ShouldQueue
{
    use Queueable, SerializesModels; 

    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function handle()
    {
        $this->user->notify(new ExportReadyNotification());
    }
}
