@extends('layouts.employer')

@section('title', 'Manage Jobs')

@section('content')
<div class="container-fluid px-4 py-3">

    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Your Job Posts</h2>
            <p class="text-muted mb-0">Manage and track all your published job listings.</p>
        </div>
        <a href="{{ route('employer.jobs.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-circle me-1"></i> Post New Job
        </a>
    </div>

    <!-- Search & Filter Card -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('employer.jobs.index') }}">
                <div class="row g-3 align-items-end">
                    <!-- Search -->
                    <div class="col-md-4">
                        <label for="search" class="form-label fw-semibold">Search</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                            <input type="text" name="search" id="search"
                                   class="form-control border-start-0"
                                   placeholder="Search by title or location..."
                                   value="{{ request('search') }}">
                        </div>
                    </div>

                    <!-- Category -->
                    <div class="col-md-3">
                        <label for="category" class="form-label fw-semibold">Category</label>
                        <select name="category" id="category" class="form-select">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Status -->
                    <div class="col-md-3">
                        <label for="status" class="form-label fw-semibold">Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value="">All Statuses</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </div>

                    <!-- Search Button -->
                    <div class="col-md-2 text-end">
                        <button type="submit" class="btn btn-outline-primary w-100">
                            <i class="bi bi-funnel me-1"></i> Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Jobs Table -->
    @if($jobs->count())
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr class="text-uppercase small text-muted">
                        <th>Title</th>
                        <th>Category</th>
                        <th>Location</th>
                        <th>Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jobs as $job)
                    <tr>
                        <td>
                            <div class="fw-semibold">
                                <a href="{{ route('employer.jobs.show', $job) }}" class="text-decoration-none text-dark">
                                    {{ $job->title }}
                                </a>
                            </div>
                            <div class="text-muted small">
                                Posted {{ $job->created_at->diffForHumans() }}
                            </div>
                        </td>
                        <td>{{ $job->category->name ?? '-' }}</td>
                        <td><i class="bi bi-geo-alt me-1 text-secondary"></i>{{ $job->location ?? '-' }}</td>
                        <td>
                            <span class="badge rounded-pill px-3 py-2 text-capitalize 
                                @if($job->status == 'approved') bg-success-subtle text-success border border-success-subtle
                                @elseif($job->status == 'pending') bg-warning-subtle text-warning border border-warning-subtle
                                @else bg-danger-subtle text-danger border border-danger-subtle @endif">
                                {{ $job->status }}
                            </span>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('employer.jobs.edit', $job) }}" 
                               class="btn btn-sm btn-outline-secondary me-1">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('employer.jobs.destroy', $job) }}" 
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('Delete this job post?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="card-footer bg-white border-0">
            <div class="d-flex justify-content-center">
                {{ $jobs->links() }}
            </div>
        </div>
    </div>
    @else
    <div class="alert alert-info text-center py-4">
        <i class="bi bi-briefcase fs-4 mb-2 d-block"></i>
        <p class="mb-0">No job posts found. <a href="{{ route('employer.jobs.create') }}">Create one now</a>.</p>
    </div>
    @endif
</div>
@endsection
