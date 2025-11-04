@extends('layouts.employer')

@section('title', 'Post a Job')

@section('content')
<div class="container">
    <h3 class="mb-4 fw-semibold">Post a New Job</h3>

    <form action="{{ route('employer.jobs.store') }}" method="POST" novalidate>
        @csrf

        {{-- Title --}}
        <div class="mb-3">
            <label class="form-label fw-medium">Title</label>
            <input type="text" name="title"
                   value="{{ old('title') }}"
                   class="form-control @error('title') is-invalid @enderror"
                   placeholder="e.g., Software Engineer" required>
            @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Category --}}
        <div class="mb-3">
            <label class="form-label fw-medium">Category</label>
            <select name="category_id"
                    class="form-select @error('category_id') is-invalid @enderror"
                    required>
                <option value="">-- Select Category --</option>
                @foreach($categories as $c)
                    <option value="{{ $c->id }}" {{ old('category_id') == $c->id ? 'selected' : '' }}>
                        {{ $c->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Location --}}
        <div class="mb-3">
            <label class="form-label fw-medium">Location</label>
            <input type="text" name="location"
                   value="{{ old('location') }}"
                   class="form-control @error('location') is-invalid @enderror"
                   placeholder="e.g., Mansoura, Egypt">
            @error('location')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Work Type --}}
        <div class="mb-3">
            <label class="form-label fw-medium">Work Type</label>
            <select name="work_type"
                    class="form-select @error('work_type') is-invalid @enderror"
                    required>
                <option value="">-- Select Work Type --</option>
                <option value="remote" {{ old('work_type') == 'remote' ? 'selected' : '' }}>Remote</option>
                <option value="onsite" {{ old('work_type') == 'onsite' ? 'selected' : '' }}>Onsite</option>
                <option value="hybrid" {{ old('work_type') == 'hybrid' ? 'selected' : '' }}>Hybrid</option>
            </select>
            @error('work_type')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Salary --}}
        <div class="mb-3">
            <label class="form-label fw-medium">Salary Range</label>
            <input type="text" name="salary_range"
                   value="{{ old('salary_range') }}"
                   class="form-control @error('salary_range') is-invalid @enderror"
                   placeholder="e.g., 10,000 - 15,000 EGP">
            @error('salary_range')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Deadline --}}
        <div class="mb-3">
            <label class="form-label fw-medium">Application Deadline</label>
            <input type="date" name="application_deadline"
                   value="{{ old('application_deadline') }}"
                   class="form-control @error('application_deadline') is-invalid @enderror">
            @error('application_deadline')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Responsibilities --}}
        <div class="mb-3">
            <label class="form-label fw-medium">Responsibilities</label>
            <textarea name="responsibilities"
                      class="form-control @error('responsibilities') is-invalid @enderror"
                      rows="4"
                      placeholder="Describe key responsibilities..." required>{{ old('responsibilities') }}</textarea>
            @error('responsibilities')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Skills --}}
        <div class="mb-3">
            <label class="form-label fw-medium">Skills</label>
            <textarea name="skills"
                      class="form-control @error('skills') is-invalid @enderror"
                      rows="3"
                      placeholder="List required skills (comma-separated)" required>{{ old('skills') }}</textarea>
            @error('skills')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Requirements --}}
        <div class="mb-3">
            <label class="form-label fw-medium">Requirements</label>
            <textarea name="requirements"
                      class="form-control @error('requirements') is-invalid @enderror"
                      rows="4"
                      placeholder="Specify requirements..." required>{{ old('requirements') }}</textarea>
            @error('requirements')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Description --}}
        <div class="mb-3">
            <label class="form-label fw-medium">Description</label>
            <textarea name="description"
                      class="form-control @error('description') is-invalid @enderror"
                      rows="5"
                      placeholder="Provide a detailed description of the job">{{ old('description') }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Technologies --}}
        <div class="mb-3">
            <label class="form-label fw-medium">Technologies (comma-separated)</label>
            <input type="text" name="technologies"
                   value="{{ old('technologies') }}"
                   class="form-control @error('technologies') is-invalid @enderror"
                   placeholder="e.g., PHP, Laravel, MySQL">
            @error('technologies')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Benefits --}}
        <div class="mb-3">
            <label class="form-label fw-medium">Benefits</label>
            <textarea name="benefits"
                      class="form-control @error('benefits') is-invalid @enderror"
                      rows="3"
                      placeholder="Perks, allowances, etc.">{{ old('benefits') }}</textarea>
            @error('benefits')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Logo URL --}}
        <div class="mb-4">
            <label class="form-label fw-medium">Logo URL (optional)</label>
            <input type="text" name="logo"
                   value="{{ old('logo') }}"
                   class="form-control @error('logo') is-invalid @enderror"
                   placeholder="Paste company logo URL">
            @error('logo')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Submit --}}
        <button type="submit" class="btn btn-primary px-4">
            <i class="bi bi-upload"></i> Publish Job
        </button>
    </form>
</div>
@endsection
