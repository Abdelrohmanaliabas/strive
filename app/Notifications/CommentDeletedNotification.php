<?php

namespace App\Notifications;

use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CommentDeletedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Comment $comment
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $commentableType = class_basename($this->comment->commentable_type);
        $commentableTitle = 'Item #' . $this->comment->commentable_id;
        
        if ($commentableType === 'JobPost' && $this->comment->relationLoaded('commentable') && $this->comment->commentable) {
            $commentableTitle = $this->comment->commentable->title;
        }

        return (new MailMessage)
            ->subject('Comment Deleted')
            ->line('Your comment has been deleted by an administrator.')
            ->line('Comment was on: ' . $commentableTitle)
            ->line('If you believe this was done in error, please contact support.')
            ->line('Thank you for using our application!');
    }

    public function toArray(object $notifiable): array
    {
        $commentableType = class_basename($this->comment->commentable_type);
        $commentableTitle = 'Item #' . $this->comment->commentable_id;
        
        if ($commentableType === 'JobPost' && $this->comment->relationLoaded('commentable') && $this->comment->commentable) {
            $commentableTitle = $this->comment->commentable->title;
        }

        return [
            'type' => 'comment_deleted',
            'message' => 'Your comment on "' . $commentableTitle . '" has been deleted by an administrator.',
            'comment_id' => $this->comment->id,
            'commentable_type' => $commentableType,
            'commentable_id' => $this->comment->commentable_id,
        ];
    }
}

