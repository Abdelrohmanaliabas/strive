<?php

namespace App\Notifications;

use App\Models\JobPost;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class JobPublishedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public JobPost $jobPost
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $employerName = $this->jobPost->relationLoaded('employer') && $this->jobPost->employer
            ? $this->jobPost->employer->name
            : 'Company';

        return (new MailMessage)
            ->subject('New Job Opportunity - ' . $this->jobPost->title)
            ->line('A new job opportunity has been published!')
            ->line('Job Title: ' . $this->jobPost->title)
            ->line('Company: ' . $employerName)
            ->line('Location: ' . ($this->jobPost->location ?? 'N/A'))
            ->line('Work Type: ' . ucfirst($this->jobPost->work_type ?? 'N/A'))
            ->action('View Job', route('jobs.show', $this->jobPost->id))
            ->line('Don\'t miss out on this opportunity!')
            ->line('Thank you for using our application!');
    }

    public function toArray(object $notifiable): array
    {
        $employerName = $this->jobPost->relationLoaded('employer') && $this->jobPost->employer
            ? $this->jobPost->employer->name
            : 'Company';

        return [
            'type' => 'job_published',
            'message' => 'A new job "' . $this->jobPost->title . '" has been published by ' . $employerName . '.',
            'job_post_id' => $this->jobPost->id,
            'job_title' => $this->jobPost->title,
            'employer_name' => $employerName,
            'location' => $this->jobPost->location ?? 'N/A',
        ];
    }
}

