<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use App\Models\User;
use App\Models\Project;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ProjectTask extends Notification implements ShouldBroadcast
{
    use Queueable;

    protected $project;
    protected $user;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($project,$user)
    {
      $this->project=$project;
      $this->user=$user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
      return ['database','broadcast'];
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
          'message'=>'Added a new task to the project '. $this->project->name,
          'notifier' =>$this->user,
          'link'=>$this->project->path()
        ];
    }

    public function toBroadcast($notifiable)
    {
    return new BroadcastMessage([
      'message'=>'Added a new task to the project '. $this->project->name,
      'notifier' =>$this->user,
      'link'=>$this->project->path()
    ]);
  }
}
