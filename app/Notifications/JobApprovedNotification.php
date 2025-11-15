<?php

namespace App\Notifications;

use App\Models\JobPost;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class JobApprovedNotification extends Notification implements ShouldQueue
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
            ->subject('Job Approved - ' . $this->jobPost->title)
            ->line('Great news! Your job posting has been approved.')
            ->line('Job Title: ' . $this->jobPost->title)
            ->line('Your job is now live and visible to candidates.')
            ->action('View Job', route('employer.jobs.show', $this->jobPost->id))
            ->line('Thank you for using our application!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'job_approved',
            'message' => 'Your job posting "' . $this->jobPost->title . '" has been approved and is now live.',
            'job_post_id' => $this->jobPost->id,
            'job_title' => $this->jobPost->title,
            'route_url' => route('employer.jobs.show', $this->jobPost->id),
        ];
    }
}

