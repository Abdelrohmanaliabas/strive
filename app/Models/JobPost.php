<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobPost extends Model
{
    use HasFactory;
    protected $fillable = [
        'employer_id',
        'category_id',
        'title',
        'description',
        'responsibilities',
        'skills',
        'requirements',
        'salary_range',
        'benefits',
        'location',
        'work_type',
        'technologies',
        'application_deadline',
        'logo',
        'status'
    ];

    public function employer()
    {
        return $this->belongsTo(User::class, 'employer_id');
    }
    public function category()
    {
        return $this->belongsTo(JobCategory::class, 'category_id');
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable', 'commentable_type', 'commentable_id');
    }
    public function analytic()
    {
        return $this->hasOne(Analytic::class);
    }

    public function getTechnologiesArrayAttribute()
    {
        if (! $this->technologies) return [];
        // Trim and split by comma, strip whitespace
        return array_filter(array_map('trim', explode(',', $this->technologies)));
    }
}
