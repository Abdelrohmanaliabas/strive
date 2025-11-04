<<<<<<< HEAD
<x-employer-layout>

</x-employer-layout>
=======
@extends('layouts.employer')

@section('title', 'Edit Job')

@section('content')
<h3>Edit Job</h3>
<form action="{{ route('employer.jobs.update', $job) }}" method="POST">
    @csrf
    @method('PUT')

    {{-- Title --}}
    <div class="mb-3">
        <label class="form-label">Title</label>
        <input type="text" name="title" value="{{ old('title', $job->title) }}" class="form-control" >
        @error('title')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    {{-- Category --}}
    <div class="mb-3">
        <label class="form-label">Category</label>
        <select name="category_id" class="form-select" >
            <option value="">-- Select --</option>
            @foreach($categories as $c)
            <option value="{{ $c->id }}" {{ (old('category_id', $job->category_id) == $c->id) ? 'selected' : '' }}>
                {{ $c->name }}
            </option>
            @endforeach
        </select>
        @error('category_id')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    {{-- Location --}}
    <div class="mb-3">
        <label class="form-label">Location</label>
        <input type="text" name="location" value="{{ old('location', $job->location) }}" class="form-control">
        @error('location')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    {{-- Salary Range --}}
    <div class="mb-3">
        <label class="form-label">Salary Range</label>
        <input type="text" name="salary_range" value="{{ old('salary_range', $job->salary_range) }}" class="form-control">
        @error('salary_range')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    {{-- Work Type --}}
    <div class="mb-3">
        <label class="form-label">Work Type</label>
        <select name="work_type" class="form-select" >
            <option value="">-- Select --</option>
            <option value="remote" {{ old('work_type', $job->work_type)=='remote' ? 'selected' : '' }}>Remote</option>
            <option value="onsite" {{ old('work_type', $job->work_type)=='onsite' ? 'selected' : '' }}>Onsite</option>
            <option value="hybrid" {{ old('work_type', $job->work_type)=='hybrid' ? 'selected' : '' }}>Hybrid</option>
        </select>
        @error('work_type')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    {{-- Application Deadline --}}
    <div class="mb-3">
        <label class="form-label">Application Deadline</label>
        <input type="date" name="application_deadline" value="{{ old('application_deadline', $job->application_deadline) }}" class="form-control">
        @error('application_deadline')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    {{-- Responsibilities --}}
    <div class="mb-3">
        <label class="form-label">Responsibilities</label>
        <textarea name="responsibilities" class="form-control" rows="4" >{{ old('responsibilities', $job->responsibilities) }}</textarea>
        @error('responsibilities')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    {{-- Skills --}}
    <div class="mb-3">
        <label class="form-label">Skills</label>
        <textarea name="skills" class="form-control" rows="3" >{{ old('skills', $job->skills) }}</textarea>
        @error('skills')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    {{-- Requirements --}}
    <div class="mb-3">
        <label class="form-label">Requirements</label>
        <textarea name="requirements" class="form-control" rows="4" >{{ old('requirements', $job->requirements) }}</textarea>
        @error('requirements')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    {{-- Description --}}
    <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control" rows="6">{{ old('description', $job->description) }}</textarea>
        @error('description')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    {{-- Technologies --}}
    <div class="mb-3">
        <label class="form-label">Technologies (comma separated)</label>
        <input type="text" name="technologies" value="{{ old('technologies', $job->technologies) }}" class="form-control">
        @error('technologies')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    {{-- Benefits --}}
    <div class="mb-3">
        <label class="form-label">Benefits</label>
        <textarea name="benefits" class="form-control" rows="3">{{ old('benefits', $job->benefits) }}</textarea>
        @error('benefits')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    {{-- Logo --}}
    <div class="mb-3">
        <label class="form-label">Logo URL (optional)</label>
        <input type="text" name="logo" value="{{ old('logo', $job->logo) }}" class="form-control">
        @error('logo')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <button class="btn btn-primary">Save Changes</button>
</form>
@endsection
>>>>>>> 01e5ed9145f3111e10dd795d26c4f86a6e3e4a85
