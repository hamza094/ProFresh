<?php

namespace App\Notifications;

use App\Models\Project;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class AcceptInvitation extends Notification implements ShouldQueue,ShouldBroadcast
{
    use Queueable;

    protected Project $project;
    protected $user;

    /**
     * Create a new notification instance.
     *
     */
    public function __construct(Project $project,$user)
    {
        $this->project=$project;
        $this->user=$user;
    }

     /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array<string> The channels through which the notification is delivered.
     */
    public function via(mixed $notifiable) :array
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
            'message' => 'accepted the invitation of your project ' . $this->project->name,
            'notifier' => $this->user,
            'link' => $this->project->path()
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
