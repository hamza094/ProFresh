<?php

namespace App\Notifications;

use App\Models\Project;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UserMentioned extends Notification implements ShouldBroadcast,ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct( 
      protected string $projectName,
      protected string $projectPath,
      protected array $notifierData
     )
    {}

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via(mixed $notifiable): array
    {
        return ['database','broadcast'];
    }

    /**
     * Prepare the notification data.
     *
     * @return array<string, mixed> The notification data.
     */
    private function notificationData(): array
    {
        return [
          'message'=>'mentioned you in '. $this->projectName.' '.'group chat',
          'notifier' =>$this->notifierData,
          'link'=>$this->projectPath
        ];
    }

     /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array<string, mixed> The notification data.
     */
    public function toArray(mixed $notifiable): array
    {
        return $this->notificationData();
    }

    /**
     * Get the broadcast representation of the notification.
     *
     * @param mixed $notifiable
     * @return BroadcastMessage The broadcast notification data.
     */
    public function toBroadcast(mixed $notifiable): BroadcastMessage 
    {
      return new BroadcastMessage($this->notificationData());
  }
}
