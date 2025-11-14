<?php

namespace App\Notifications;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ApplicationStatusNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Application $application,
        public string $status
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $statusMessage = $this->status === 'accepted' 
            ? 'Congratulations! Your application has been accepted.'
            : 'Unfortunately, your application has been rejected.';

        $jobTitle = $this->application->relationLoaded('jobPost') && $this->application->jobPost
            ? $this->application->jobPost->title
            : 'Job Application';

        return (new MailMessage)
            ->subject('Application ' . ucfirst($this->status) . ' - ' . $jobTitle)
            ->line($statusMessage)
            ->line('Job Title: ' . $jobTitle)
            ->line('Status: ' . ucfirst($this->status))
            ->action('View Job', route('jobs.show', $this->application->job_post_id))
            ->line('Thank you for using our application!');
    }

    public function toArray(object $notifiable): array
    {
        $jobTitle = $this->application->relationLoaded('jobPost') && $this->application->jobPost
            ? $this->application->jobPost->title
            : 'Job Application';

        $statusMessage = $this->status === 'accepted'
            ? 'Your application for "' . $jobTitle . '" has been accepted!'
            : 'Your application for "' . $jobTitle . '" has been rejected.';

        return [
            'type' => 'application_status',
            'message' => $statusMessage,
            'application_id' => $this->application->id,
            'job_post_id' => $this->application->job_post_id,
            'job_title' => $jobTitle,
            'status' => $this->status,
            'route_url' => route('jobs.show', $this->application->job_post_id),
        ];
    }
}

