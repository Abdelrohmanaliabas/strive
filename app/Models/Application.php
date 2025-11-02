<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;
    protected $fillable = ['candidate_id', 'job_post_id', 'resume', 'name', 'email', 'phone', 'status'];

    public function candidate()
    {
        return $this->belongsTo(User::class, 'candidate_id');
    }
    public function jobPost()
    {
        return $this->belongsTo(JobPost::class);
    }
}
