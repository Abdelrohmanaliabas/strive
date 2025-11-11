@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('page_title', 'Admin Dashboard')
@section('body_class', 'admin-theme')

@section('content')
<div class="space-y-6 dashboard-shell">
    {{-- Header --}}
    <header class="header-panel flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-bold gradient-text" data-eyebrow="Control center">Admin Dashboard</h1>
            <p class="text-sm text-slate-300/90 mt-1 max-w-2xl">Overview of platform metrics and activity</p>
        </div>

    </header>

    {{-- KPI-Cards Row --}}
    <section class="KPI-Cards relative z-10 flex flex-col sm:flex-row sm:space-x-4 space-y-4 sm:space-y-0">
        {{-- Total Users --}}
        <div class="card metric-card p-5 rounded-3xl border border-slate-700/50 shadow-inner hover:scale-105 hover:shadow-2xl hover:shadow-blue-700/20 transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase text-slate-400 chip-label">Total Users</p>
                    <div class="text-2xl font-bold mt-2 metric-value">{{ $userCount ?? 0 }}</div>
                    <p class="text-xs mt-1 trend-indicator positive">12% from last month</p>
                </div>
                <div class="p-3 rounded-lg bg-gradient-to-br from-blue-500/20 to-blue-600/10 icon-ring">
                    <svg class="w-6 h-6 text-blue-400" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12a3 3 0 100-6 3 3 0 000 6z"/>
                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 6.638 3 12 3s10.268 2.943 11.542 7c-1.274 4.057-6.18 7-11.542 7S1.732 14.057.458 10zM14 12a2 2 0 11-4 0 2 2 0 014 0z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Total Jobs --}}
        <div class="card metric-card p-5 rounded-3xl border border-slate-700/50 shadow-inner hover:scale-105 hover:shadow-2xl hover:shadow-blue-700/20 transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase text-slate-400">Total Job Posts</p>
                    <div class="text-2xl font-bold mt-2 metric-value">{{ $jobCount ?? 0 }}</div>
                    <p class="text-xs mt-1 trend-indicator positive">8% from last month</p>
                </div>
                <div class="p-3 rounded-lg bg-gradient-to-br from-purple-500/20 to-purple-600/10 icon-ring">
                    <svg class="w-6 h-6 text-purple-400" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M20 6h-2.15l-.5-1A2 2 0 0015.75 4h-7.5a2 2 0 00-1.75 1l-.5 1H4a2 2 0 00-2 2v11a2 2 0 002 2h16a2 2 0 002-2V8a2 2 0 00-2-2zm-10 15a4 4 0 110-8 4 4 0 010 8z"/>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Active Applications --}}
        <div class="card metric-card p-5 rounded-3xl border border-slate-700/50 shadow-inner hover:scale-105  hover:shadow-2xl hover:shadow-blue-700/20 transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase text-slate-400">Active Applications</p>
                    <div class="text-2xl font-bold mt-2 metric-value">{{ $pendingApprovals ?? 0 }}</div>
                    <p class="text-xs mt-1 trend-indicator caution">Awaiting review</p>
                </div>
                <div class="p-3 rounded-lg bg-gradient-to-br from-orange-500/20 to-orange-600/10 icon-ring">
                    <svg class="w-6 h-6 text-orange-400" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>


    </section>

    {{-- Charts Row --}}
    <section class="grid grid-cols-1 lg:grid-cols-2 gap-6 z-10">
        {{-- Users Growth Chart --}}
        <div class="card chart-card p-6 rounded-lg border border-slate-700/50 hover:shadow-2xl hover:shadow-blue-700/20 transition">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="font-semibold text-white">User Growth</h3>
                    <p class="text-xs text-slate-300/80 mt-1">Last 6 months</p>
                </div>
                <span class="px-3 py-1 rounded-full text-xs font-medium stat-chip">Trending</span>
            </div>
            <div class="h-64">
                <canvas id="usersChart"></canvas>
            </div>
        </div>

        {{-- Jobs Growth Chart --}}
        <div class="card chart-card p-6 rounded-lg border border-slate-700/50 hover:shadow-2xl hover:shadow-blue-700/20 transition">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="font-semibold text-white">Job Posts Growth</h3>
                    <p class="text-xs text-slate-300/80 mt-1">Last 6 months</p>
                </div>
                <span class="px-3 py-1 rounded-full text-xs font-medium stat-chip purple">Monthly</span>
            </div>
            <div class="h-64">
                <canvas id="jobsChart"></canvas>
            </div>
        </div>
    </section>

    {{-- Recent Activity --}}
    <section class="card p-6 rounded-lg border border-slate-700/50 activity-card">
        <div class="flex items-center justify-between mb-5">
            <div>
                <h3 class="font-semibold ">Recent Activity</h3>
                <p class="text-xs text-slate-400 mt-1">Latest platform events</p>
            </div>
            <a href="#" class="text-xs font-medium subtle-link transition">View all activity</a>
        </div>

        <div class="space-y-3">
            @if(isset($recentActivities) && $recentActivities->count() > 0)
                @foreach ($recentActivities as $activity)
                    <div class="flex items-start gap-4 p-3 rounded-lg border border-slate-200/30 hover:bg-slate-500/10 transition activity-item">
                        <div class="p-2 rounded-full bg-gradient-to-br from-cyan-500/20 to-blue-500/10">
                            <svg class="w-4 h-4 text-cyan-400" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-slate-200">{{ $activity->description ?? 'Activity' }}</p>
                            <p class="text-xs text-slate-400/80 mt-1 tracking-wide">{{ $activity->created_at?->diffForHumans() ?? 'Recently' }}</p>
                        </div>
                        <span class="text-xs font-semibold pulse-dot">Live</span>
                    </div>
                @endforeach
            @else
                <div class="p-8 text-center rounded-2xl border border-dashed border-slate-700/60 bg-slate-900/30">
                    <p class="text-slate-300/90 text-sm tracking-wide">No recent activity yet.</p>
                </div>
            @endif
        </div>
    </section>


</div>

{{-- Chart.js Library --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
(function(){
    const chartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: true,
                labels: { color: '#cbd5e1', font: { size: 12 } }
            }
        },
        scales: {
            x: {
                ticks: { color: '#94a3b8' },
                grid: { color: 'rgba(148, 163, 184, 0.1)' }
            },
            y: {
                ticks: { color: '#94a3b8' },
                grid: { color: 'rgba(148, 163, 184, 0.1)' }
            }
        }
    };

    // Users Chart
    const usersEl = document.getElementById('usersChart')?.getContext('2d');
    const usersLabels = @json($userGrowthLabels ?? []);
    const usersData = @json($userGrowthData ?? []);

    if(usersEl && usersLabels.length){
        new Chart(usersEl, {
            type: 'line',
            data: {
                labels: usersLabels,
                datasets: [{
                    label: 'Total Users',
                    data: usersData,
                    borderColor: '#0ea5e9',
                    backgroundColor: 'rgba(6, 182, 212, 0.1)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true,
                    pointRadius: 4,
                    pointBackgroundColor: '#0ea5e9'
                }]
            },
            options: chartOptions
        });
    }

    // Jobs Chart
    const jobsEl = document.getElementById('jobsChart')?.getContext('2d');
    const jobsLabels = @json($jobGrowthLabels ?? []);
    const jobsData = @json($jobGrowthData ?? []);

    if(jobsEl && jobsLabels.length){
        new Chart(jobsEl, {
            type: 'bar',
            data: {
                labels: jobsLabels,
                datasets: [{
                    label: 'Job Posts',
                    data: jobsData,
                    backgroundColor: 'rgba(168, 85, 247, 0.6)',
                    borderColor: '#a855f7',
                    borderWidth: 1,
                    borderRadius: 6
                }]
            },
            options: chartOptions
        });
    }
})();
</script>
@endsection
