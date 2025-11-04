@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 text-center">
        <h5 class="text-gray-600 dark:text-gray-300">Total Users</h5>
        <h2 class="text-indigo-600 dark:text-indigo-400 text-3xl font-semibold mt-2">{{ $userCount }}</h2>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 text-center">
        <h5 class="text-gray-600 dark:text-gray-300">Total Jobs</h5>
        <h2 class="text-green-600 dark:text-green-400 text-3xl font-semibold mt-2">{{ $jobCount }}</h2>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 text-center">
        <h5 class="text-gray-600 dark:text-gray-300">Pending Approvals</h5>
        <h2 class="text-yellow-500 text-3xl font-semibold mt-2">12</h2>
    </div>
</div>
@endsection
