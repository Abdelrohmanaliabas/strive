<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\JobPost;

class AdminController extends Controller
{
    public function index()
    {
        $userCount = User::count();
        $jobCount = JobPost::count();

        return view('admin.dashboard', compact('userCount', 'jobCount'));
    }
}
