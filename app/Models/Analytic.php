<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Analytic extends Model
{
    use HasFactory;
    protected $fillable = ['job_post_id', 'views_count', 'applications_count', 'last_viewed_at'];
    public function jobPost()
    {
        return $this->belongsTo(JobPost::class);
    }
}
