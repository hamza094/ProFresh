<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ProjectUpdated extends Notification implements ShouldQueue,ShouldBroadcast
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
     * @param mixed $notifiable
     * @return array<string> The channels through which the notification is delivered.
     */
    public function via($notifiable): array
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
        'message'=>'Updated project '. $this->projectName,
        'notifier' =>$this->notifierData,
        'link'=>$this->projectPath,
      ];
    }


    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array<string, mixed> The notification data.
     */
    public function toArray($notifiable): array
    {
      return $this->notificationData();
    }

    
    /**
     * Get the broadcast representation of the notification.
     *
     * @param mixed $notifiable
     * @return BroadcastMessage The broadcast notification data.
     */
    public function toBroadcast($notifiable): BroadcastMessage 
    {
      return new BroadcastMessage(
        $this->notificationData()
      );
    }
}
