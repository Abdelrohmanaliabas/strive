<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\JobPost;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'userCount' => User::count(),
            'jobCount' => JobPost::count(),
            'pendingApprovals' => JobPost::where('status', 'pending')->count(),
            'recentActivities' => JobPost::latest()->take(10)->get(),
            'userGrowthLabels' => ['May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
            'userGrowthData' => [120, 180, 240, 300, 400, 480],
            'jobGrowthLabels' => ['May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
            'jobGrowthData' => [40, 60, 80, 100, 130, 150],
        ]);
    }
}
