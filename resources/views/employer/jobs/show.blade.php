{{-- <<<<<<< HEAD
<x-employer-layout>

</x-employer-layout>
======= --}}
@extends('layouts.employer')

@section('title', $job->title)

@section('content')
<div class="container-fluid px-4 py-3">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">{{ $job->title }}</h2>
            <p class="text-muted mb-0">
                <i class="bi bi-geo-alt"></i> {{ $job->location ?? 'Not specified' }}
                • <span class="badge bg-secondary text-capitalize">{{ $job->work_type }}</span>
                • <span class="badge {{ $job->status == 'approved' ? 'bg-success' : ($job->status == 'pending' ? 'bg-warning text-dark' : 'bg-danger') }}">
                    {{ ucfirst($job->status) }}
                </span>
            </p>
        </div>

        <div>
            <a href="{{ route('employer.jobs.edit', $job) }}" class="btn btn-outline-primary btn-sm me-2">
                <i class="bi bi-pencil"></i> Edit
            </a>
            <form action="{{ route('employer.jobs.destroy', $job) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button class="btn btn-outline-danger btn-sm" onclick="return confirm('Are you sure you want to delete this job?')">
                    <i class="bi bi-trash"></i> Delete
                </button>
            </form>
        </div>
    </div>

    <!-- Job Overview Card -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                @if($job->logo)
                    <div class="col-md-3 text-center">
                        <img src="{{ asset('storage/' . $job->logo) }}" alt="Company Logo" class="img-fluid rounded" style="max-height: 120px;">
                    </div>
                @endif

                <div class="col-md-9">
                    <p class="mb-2"><strong>Category:</strong> {{ $job->category->name ?? '—' }}</p>
                    <p class="mb-2"><strong>Salary Range:</strong> {{ $job->salary_range ?? 'Not specified' }}</p>
                    <p class="mb-0"><strong>Application Deadline:</strong>
                        {{ $job->application_deadline ? \Carbon\Carbon::parse($job->application_deadline)->format('F j, Y') : '—' }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Description -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-light fw-semibold">Job Description</div>
        <div class="card-body">
            {!! nl2br(e($job->description)) !!}
        </div>
    </div>

    <!-- Responsibilities -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-light fw-semibold">Responsibilities</div>
        <div class="card-body">
            {!! nl2br(e($job->responsibilities)) !!}
        </div>
    </div>

    <!-- Requirements -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-light fw-semibold">Requirements</div>
        <div class="card-body">
            {!! nl2br(e($job->requirements)) !!}
        </div>
    </div>

    <!-- Skills -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-light fw-semibold">Skills</div>
        <div class="card-body">
            {!! nl2br(e($job->skills)) !!}
        </div>
    </div>

    <!-- Technologies -->
    @if($job->technologies)
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-light fw-semibold">Technologies</div>
        <div class="card-body">
            @foreach(explode(',', $job->technologies) as $tech)
                <span class="badge bg-primary me-1">{{ trim($tech) }}</span>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Benefits -->
    @if($job->benefits)
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-light fw-semibold">Benefits</div>
        <div class="card-body">
            {!! nl2br(e($job->benefits)) !!}
        </div>
    </div>
    @endif

    <!-- Footer -->
    <div class="text-center text-muted small mt-4">
        <p>Posted on {{ $job->created_at->format('F j, Y') }}</p>
    </div>
</div>
@endsection
{{-- >>>>>>> 01e5ed9145f3111e10dd795d26c4f86a6e3e4a85 --}}
