<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class TaskDue extends Notification implements ShouldBroadcast
{
    protected $task;
    protected $user;
    protected $project;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($task,$user,$project)
    {
        $this->task=$task;
        $this->user=$user;
        $this->project=$project;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
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
                ->line("Your task '{$this->task->title}' due '{$this->task->due_at}' is approaching. You are getting this mail because you selected to be notified '{$this->task->notified}'. Keep an eye on your task.")
                ->action('Notification Action', url(env('APP_URL') . "/projects/" . $this->project->path()))
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
          'message'=>"Your task '{$this->task->title}' due '{$this->task->due_at}' is approaching. You are getting this mail because you selected to be notified '{$this->task->notified}'. Keep an eye on your task.",
          'notifier' =>$this->user,
          'link'=>$this->project->path()
        ];
    }

    public function toBroadcast($notifiable)
    {
      return new BroadcastMessage([
         'message'=>"Your task '{$this->task->title}' due '{$this->task->due_at}' is approaching. You are getting this mail because you selected to be notified '{$this->task->notified}'. Keep an eye on your task.",
          'notifier' =>$this->user->name,
          'link'=>$this->project->path()
    ]);
  }
}
