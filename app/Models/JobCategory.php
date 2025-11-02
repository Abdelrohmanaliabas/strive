<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobCategory extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description'];
    public function jobPosts()
    {
        return $this->hasMany(JobPost::class, 'category_id');
    }
}
