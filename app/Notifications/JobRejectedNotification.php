<?php

namespace App\Notifications;

use App\Models\JobPost;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class JobRejectedNotification extends Notification implements ShouldQueue
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
        return (new MailMessage)
            ->subject('Job Rejected - ' . $this->jobPost->title)
            ->line('Unfortunately, your job posting has been rejected.')
            ->line('Job Title: ' . $this->jobPost->title)
            ->line('Please review the job details and contact support if you have any questions.')
            ->action('View Job', route('employer.jobs.show', $this->jobPost->id))
            ->line('Thank you for using our application!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'job_rejected',
            'message' => 'Your job posting "' . $this->jobPost->title . '" has been rejected. Please review and contact support if needed.',
            'job_post_id' => $this->jobPost->id,
            'job_title' => $this->jobPost->title,
            'route_url' => route('employer.jobs.show', $this->jobPost->id),
        ];
    }
}

