<?php

namespace App\Channels;

use Illuminate\Notifications\Channels\DatabaseChannel as Channel;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\DB;

class DatabaseChannel extends Channel
{
    public function send($notifiable, Notification $notification)
    {
        $data = json_encode($this->getData($notifiable, $notification));

        DB::table('notifications')->insertOrIgnore([
            'id' => $notification->id,
            'type' => get_class($notification),
            'notifiable_type' => get_class($notifiable),
            'notifiable_id' => $notifiable->id,
            'data' => $data,
            'signature' => hash('sha256', $data),
            'read_at' => null,
            'created_at' => now()->toDateTimeString(),
            'updated_at' => now()->toDateTimeString(),
        ]);
    }
}
