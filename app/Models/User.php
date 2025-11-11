<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role', 'phone', 'linkedin_url', 'avatar_path'];
    protected $hidden = ['password', 'remember_token'];
    protected $appends = ['avatar_url'];

    // Helpers
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
    public function isEmployer(): bool
    {
        return $this->role === 'employer';
    }
    public function isCandidate(): bool
    {
        return $this->role === 'candidate';
    }

    // Relations
    public function jobPosts()
    {
        return $this->hasMany(JobPost::class, 'employer_id');
    }
    public function applications()
    {
        return $this->hasMany(Application::class, 'candidate_id');
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar_path && Storage::disk('public')->exists($this->avatar_path)) {
            return asset('storage/' . $this->avatar_path);
        }
    
        return asset('images/avatar.jpg');
    }
    
}
