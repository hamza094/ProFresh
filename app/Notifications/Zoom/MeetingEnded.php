<?php

namespace App\Notifications\Zoom;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MeetingEnded extends Notification implements ShouldBroadcast
{
    use Queueable;

    protected array $data;

    /**
     * Create a new notification instance.
     *
     * @param array $data
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
     * @return array
     */
    public function via($notifiable): array
    {
        return ['mail','database','broadcast'];
    }

    private function formattedStartTime(): string
    {
        return $this->data['start_time'] ? Carbon::parse($this->data['start_time'])->format('d F \\a\\t H:i:s') : '';
    }

    private function formattedEndTime(): string
    {
        return $this->data['end_time'] ? Carbon::parse($this->data['end_time'])->format('d F \\a\\t H:i:s') : '';
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
            ->subject('Meeting Ended: ' . $this->data['meeting_topic'])
            ->markdown('mail.meeting.ended', [
                'projectName' => $this->data['project_name'],
                'projectLink' => $this->data['project_slug'],
                'meetingTopic' => $this->data['meeting_topic'],
                'userName'=> $this->data['notifier']['name'],
                'startTime' => $this->formattedStartTime(),
                'endTime' => $this->formattedEndTime(),
                'timezone' => $this->data['meeting_timezone'],
            ]);
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'message' => 'Project ' . $this->data['project_name'] . ' Meeting ' . $this->data['meeting_topic'] . ' ended at ' . $this->formattedEndTime() . ' ' . $this->data['meeting_timezone'],
            'notifier' => $this->data['notifier'],
            'link' => $this->data['project_path'],
        ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable): array
    {
        return [
            'message' => 'Project ' . $this->data['project_name'] . ' Meeting ' . $this->data['meeting_topic'] . ' ended at ' . $this->formattedEndTime() . ' ' . $this->data['meeting_timezone'],
            'notifier' => $this->data['notifier'],
            'link' => $this->data['project_path'],
        ];
    }
}
