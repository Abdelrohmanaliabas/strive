<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class EmployerProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin ,candidate,employer']);
    }

    public function show(User $employer)
    {

        // Get employer’s posted jobs
        $jobPosts = $employer->jobPosts()->latest()->get();

        return view('companies.show', compact('employer', 'jobPosts'));
    }
}
