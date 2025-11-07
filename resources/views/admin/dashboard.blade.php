@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <!-- Total Users -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 text-center">
        <h5 class="text-gray-600 dark:text-gray-300">Total Users</h5>
        <h2 class="text-indigo-600 dark:text-indigo-400 text-3xl font-semibold mt-2">{{ $userCount }}</h2>
    </div>

    <!-- Total Jobs -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 text-center">
        <h5 class="text-gray-600 dark:text-gray-300">Total Jobs</h5>
        <h2 class="text-green-600 dark:text-green-400 text-3xl font-semibold mt-2">{{ $jobCount }}</h2>
    </div>

    <!-- Pending Approvals -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 text-center">
        <h5 class="text-gray-600 dark:text-gray-300">Pending Approvals</h5>
        <h2 class="text-yellow-500 text-3xl font-semibold mt-2">{{ $pendingApprovals }}</h2>
    </div>
</div>

<!-- Charts Section -->
<div class="mt-10 grid grid-cols-1 md:grid-cols-2 gap-8">
    <!-- Users Growth Chart -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
        <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-4">User Growth (Last 6 Months)</h3>
        <canvas id="usersChart"></canvas>
    </div>

    <!-- Jobs Growth Chart -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
        <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-4">Jobs Growth (Last 6 Months)</h3>
        <canvas id="jobsChart"></canvas>
    </div>
</div>

<!-- Recent Activity -->
<div class="mt-10 bg-white dark:bg-gray-800 rounded-xl shadow p-6">
    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-4">Recent Activities</h3>
    <ul class="divide-y divide-gray-200 dark:divide-gray-700">
        @foreach($recentActivities as $activity)
            <li class="py-3 flex items-center justify-between">
                <span class="text-gray-600 dark:text-gray-300">{{ $activity->description }}</span>
                <span class="text-sm text-gray-400">{{ $activity->created_at->diffForHumans() }}</span>
            </li>
        @endforeach
    </ul>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const usersCtx = document.getElementById('usersChart').getContext('2d');
    const jobsCtx = document.getElementById('jobsChart').getContext('2d');

    new Chart(usersCtx, {
        type: 'line',
        data: {
            labels: @json($userGrowthLabels),
            datasets: [{
                label: 'Users',
                data: @json($userGrowthData),
                borderColor: '#6366f1',
                backgroundColor: 'rgba(99,102,241,0.15)',
                tension: 0.4,
                fill: true
            }]
        },
        options: { plugins: { legend: { display: false } } }
    });

    new Chart(jobsCtx, {
        type: 'bar',
        data: {
            labels: @json($jobGrowthLabels),
            datasets: [{
                label: 'Jobs',
                data: @json($jobGrowthData),
                backgroundColor: 'rgba(34,197,94,0.6)',
                borderRadius: 8
            }]
        },
        options: { plugins: { legend: { display: false } } }
    });
</script>
@endsection
