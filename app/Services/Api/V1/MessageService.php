<?php

declare(strict_types=1);

namespace App\Services\Api\V1;

use App\Models\Message;
use App\Models\Project;
use F9Web\ApiResponseHelpers;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Bus;
use Illuminate\Validation\ValidationException;
use Safe\DateTimeImmutable;
use Timezone;

class MessageService
{
    use ApiResponseHelpers;

    public function checkOptionSelect($request): void
    {
        if (! $request->mail && ! $request->sms) {
            throw ValidationException::withMessages([
                'option' => 'Please choose any options.',
            ]);
        }
    }

    public function send(Project $project, Collection $users)
    {
        $response = '';

        $types = ['mail', 'sms'];

        $send_or_schedule = request()->filled('date') ? 'Scheduled' : 'Sent';

        foreach ($types as $type) {
            if (request()->boolean($type)) {
                $message = $this->messageCreate($project, $type, $users);
                $this->sendOrScheduledMessage($project, $message);
            }
        }

        $response = "Messages {$send_or_schedule} Successfully";

        return response()->json(['message' => $response], 200);
    }

    public function messageCreate(Project $project, string $type, Collection $users): Message
    {
        $message = Message::create([
            'project_id' => $project->id,
            'type' => $type,
            'message' => request()->message,
        ]);

        if ($message->type === 'mail') {
            $message->subject = request()->get('subject');
            $message->save();
        }

        $message->users()->attach($users);

        return $message;
    }

    public function sendOrScheduledMessage($project, $message): void
    {
        request()->date ?
        $this->scheduledMessage($message) :
        $this->sendNow($project, $message);
    }

    public function sendNow(Project $project, Message $message): void
    {
        $message->type === 'mail' ? $job = \App\Jobs\MailMessage::class :
        $job = \App\Jobs\SmsMessage::class;

        $jobs = $message->users
            ->map(fn ($user): \App\Jobs\MailMessage|\App\Jobs\SmsMessage => new $job($project, $message, $user));

        $batch = Bus::batch($jobs)
            ->allowFailures()
            ->then(function () use ($message): void {
                $message->delivered = true;
                $message->save();
                // notify user on batch success
            })->catch(function (Batch $batch, Throwable $e): void {
                // notify on job failure
            })->dispatch();

        $message->update([
            'batch_id' => $batch->id,
        ]);
    }

    public function scheduledMessage(Message $message): void
    {
        $this->saveMessageDateAndTime($message);
    }

    private function saveMessageDateAndTime(Message $message): void
    {
        $datetime = new DateTimeImmutable(request()->date.' '.request()->time);

        $formattedTime = $datetime->format('Y-m-d H:i:s');

        $message->delivered_at = Timezone::convertFromLocal($formattedTime);

        $message->save();
    }
}
