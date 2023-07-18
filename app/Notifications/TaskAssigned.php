<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class TaskAssigned extends Notification implements ShouldBroadcast
{
    use Queueable;

    protected $task;
    protected $project;
    protected $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($task,$project,$user){
        $this->task=$task;
        $this->project=$project;
        $this->user=$user;

    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable,)
    {
        return ['mail','database','broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line($this->user->name.' has assigned you a task: "'.$this->task->title. '" This is regarding the project '. $this->project->name)
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
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
          'message'=>'has assigned you a task: "'.$this->task->title. '" This is regarding the project '. $this->project->name,
          'notifier' =>$this->user,
          'link'=>$this->project->path()
        ];
    }

    public function toBroadcast($notifiable)
    {
      return new BroadcastMessage([
         'message'=>'has assigned you a task: "'.$this->task->title. '" This is regarding the project '. $this->project->name,
          'notifier' =>$this->user->name,
          'link'=>$this->project->path()
    ]);
  }
}
