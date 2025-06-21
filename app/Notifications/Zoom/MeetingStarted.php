<?php

namespace App\Notifications\Zoom;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MeetingStarted extends Notification implements ShouldBroadcast
{
    use Queueable;

    /**
     * @var array<string, mixed>
     */
    protected array $data;

    /**
     * Create a new notification instance.
     *
     * @param array<string, mixed> $data
     * @return void
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array<int, string>
     */
    public function via($notifiable): array
    {
        return ['mail','database','broadcast'];
    }

    /**
     * Get the formatted start time for the meeting.
     *
     * @return string
     */
    private function formattedStartTime(): string
    {
        return Carbon::parse($this->data['start_time'])->format('d F \\a\\t H:i:s');
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable): MailMessage
    {
        $formattedStartTime = $this->formattedStartTime();
        return (new MailMessage)
            ->subject('Meeting Started: ' . $this->data['meeting_topic'])
            ->markdown('mail.meeting.started', [
                'projectName' => $this->data['project_name'],
                'projectLink' => $this->data['project_slug'],
                'meetingTopic' => $this->data['meeting_topic'],
                'userName'=> $this->data['notifier']['name'],
                'joinUrl'=> $this->data['meeting_join_url'],
                'startTime' => $formattedStartTime,
                'timezone' => $this->data['meeting_timezone']
            ]);
    }

    /**
     * @param mixed $notifiable
     */
    public function toBroadcast($notifiable): BroadcastMessage
    {
        $formattedStartTime = $this->formattedStartTime();
        return new BroadcastMessage([
            'message' => 'Project ' . $this->data['project_name'] . ' Meeting ' . $this->data['meeting_topic'] . ' started at ' . $formattedStartTime . ' ' . $this->data['meeting_timezone'],
            'notifier' => $this->data['notifier'],
            'link' => $this->data['project_path'],
        ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array<string, mixed>
     */
    public function toDatabase($notifiable): array
    {
        $formattedStartTime = $this->formattedStartTime();
        return [
            'message' => 'Project ' . $this->data['project_name'] . ' Meeting ' . $this->data['meeting_topic'] . ' started at ' . $formattedStartTime . ' ' . $this->data['meeting_timezone'],
            'notifier' => $this->data['notifier'],
            'link' => $this->data['project_path'],
        ];
    }
}
