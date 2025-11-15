<?php

namespace App\Notifications;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class JobAppliedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Application $application
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $jobTitle = $this->application->relationLoaded('jobPost') && $this->application->jobPost
            ? $this->application->jobPost->title
            : 'Job Posting';

        return (new MailMessage)
            ->subject('New Application Received - ' . $jobTitle)
            ->line('You have received a new application for your job posting.')
            ->line('Job Title: ' . $jobTitle)
            ->line('Candidate: ' . $this->application->name)
            ->line('Email: ' . $this->application->email)
            ->action('View Application', route('employer.applications.show', $this->application->id))
            ->line('Thank you for using our application!');
    }

    public function toArray(object $notifiable): array
    {
        $jobTitle = $this->application->relationLoaded('jobPost') && $this->application->jobPost
            ? $this->application->jobPost->title
            : 'Job Posting';

        return [
            'type' => 'job_applied',
            'message' => 'A new application has been received for "' . $jobTitle . '" from ' . $this->application->name . '.',
            'application_id' => $this->application->id,
            'job_post_id' => $this->application->job_post_id,
            'job_title' => $jobTitle,
            'candidate_name' => $this->application->name,
            'route_url' => route('employer.applications.show', $this->application->id),
        ];
    }
}

