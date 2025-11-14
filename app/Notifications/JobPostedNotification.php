<?php

namespace App\Notifications;

use App\Models\JobPost;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class JobPostedNotification extends Notification implements ShouldQueue
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
            : 'Unknown Employer';

        return (new MailMessage)
            ->subject('New Job Posted - ' . $this->jobPost->title)
            ->line('A new job has been posted and requires your approval.')
            ->line('Job Title: ' . $this->jobPost->title)
            ->line('Employer: ' . $employerName)
            ->line('Location: ' . ($this->jobPost->location ?? 'N/A'))
            ->action('Review Job', route('admin.jobpost.show', $this->jobPost->id))
            ->line('Thank you for using our application!');
    }

    public function toArray(object $notifiable): array
    {
        $employerName = $this->jobPost->relationLoaded('employer') && $this->jobPost->employer
            ? $this->jobPost->employer->name
            : 'Unknown Employer';

        return [
            'type' => 'job_posted',
            'message' => 'A new job "' . $this->jobPost->title . '" has been posted by ' . $employerName . ' and requires approval.',
            'job_post_id' => $this->jobPost->id,
            'job_title' => $this->jobPost->title,
            'employer_name' => $employerName,
            'route_url' => route('admin.jobpost.show', $this->jobPost->id),
        ];
    }
}

