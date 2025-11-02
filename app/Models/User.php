<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role', 'phone', 'linkedin_url'];
    protected $hidden = ['password', 'remember_token'];

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
}
