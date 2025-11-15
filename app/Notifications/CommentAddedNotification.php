<?php

namespace App\Notifications;

use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CommentAddedNotification extends Notification implements ShouldQueue
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

        $route = $commentableType === 'JobPost' 
            ? route('jobs.show', $this->comment->commentable_id)
            : '#';

        $commenterName = $this->comment->relationLoaded('user') && $this->comment->user 
            ? $this->comment->user->name 
            : 'Unknown User';

        return (new MailMessage)
            ->subject('New Comment Added - ' . $commentableTitle)
            ->line('A new comment has been added.')
            ->line('Comment by: ' . $commenterName)
            ->line('On: ' . $commentableTitle)
            ->line('Comment: ' . substr($this->comment->content, 0, 100) . '...')
            ->action('View Comment', $route)
            ->line('Thank you for using our application!');
    }

    public function toArray(object $notifiable): array
    {
        $commentableType = class_basename($this->comment->commentable_type);
        $commentableTitle = 'Item #' . $this->comment->commentable_id;
        $routeUrl = '#';
        
        if ($commentableType === 'JobPost' && $this->comment->relationLoaded('commentable') && $this->comment->commentable) {
            $commentableTitle = $this->comment->commentable->title;
            $routeUrl = route('jobs.show', $this->comment->commentable_id);
        }

        $commenterName = $this->comment->relationLoaded('user') && $this->comment->user 
            ? $this->comment->user->name 
            : 'Unknown User';

        return [
            'type' => 'comment_added',
            'message' => $commenterName . ' added a comment on "' . $commentableTitle . '".',
            'comment_id' => $this->comment->id,
            'commentable_type' => $commentableType,
            'commentable_id' => $this->comment->commentable_id,
            'commenter_name' => $commenterName,
            'route_url' => $routeUrl,
        ];
    }
}

