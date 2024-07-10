<?php

namespace App\Notifications\Zoom;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MeetingStarted extends Notification implements ShouldBroadcast
{
    use Queueable;

    protected $project;
    public $meeting;
    protected $start_time;
    protected $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($project, $meeting, $start_time, $user)
    {
        $this->project = $project;
        $this->meeting = $meeting;
        $this->user = $user;
        $this->start_time = Carbon::parse($start_time)->format('d F \a\t H:i:s');
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
            ->subject('Meeting Started: ' . $this->meeting->topic)
            ->markdown('mail.meeting.started', [
                'projectName' => $this->project->name,
                'projectLink' => $this->project->slug,
                'meetingTopic' => $this->meeting->topic,
                'userName'=> $this->user->name,
                'joinUrl'=> $this->meeting->join_url,
                'startTime' => $this->start_time,
                'timezone' => $this->meeting->timezone
            ]);
    }

    public function toBroadcast($notifiable) :BroadcastMessage
    {
      return new BroadcastMessage([
        'message' => 'Project ' . $this->project->name . ' Meeting ' . $this->meeting->topic . ' started at ' . $this->start_time . ' ' . $this->meeting->timezone,
       'notifier' =>$this->user,
       'link'=>$this->project->path()
        ]);
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
         'message' => 'Project ' . $this->project->name . ' Meeting ' . $this->meeting->topic . ' started at ' . $this->start_time . ' ' . $this->meeting->timezone,
       'notifier' =>$this->user,
       'link'=>$this->project->path()
        ];
    }
}
