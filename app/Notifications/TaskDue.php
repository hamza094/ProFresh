<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Carbon\Carbon;

class TaskDue extends Notification implements ShouldQueue,ShouldBroadcast
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(
       protected Carbon $dueDate,
       protected string $taskTitle,
       protected string $notifiedOption,
       protected array $notifierData,
       protected string $projectName,
       protected string $projectPath
    ){}
    
    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable): array
    {
        return ['mail','database','broadcast'];
    }

     private function notificationMessage(): string
    {
        return "Your task '{$this->taskTitle}' due '{$this->dueDate}' is approaching. You selected to be notified '{$this->notifiedType}'.";
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
                ->line($this->notificationMessage())
                ->action('View Task', url(env('APP_URL') . "/projects/" . $this->project->path()))
                ->line('Thank you for using our application!');
    }

    
    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array<string, mixed> The notification data.
     */
    public function toArray($notifiable): array
    {
        return [
          'message'=>$this->notificationMessage(),
          'notifier' =>$this->notifierData,
          'link'=>$this->projectPath()
        ];
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
            $this->toArray($notifiable)
        );
  }
}
