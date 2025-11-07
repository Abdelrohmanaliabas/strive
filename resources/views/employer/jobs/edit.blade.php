<x-employer-layout>
    <div class="space-y-10 px-6 py-10 lg:px-12">
        <header class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.35em] text-cyan-300/80">Refresh the listing</p>
                <h1 class="mt-2 text-3xl font-bold text-white">Edit job posting</h1>
                <p class="mt-2 text-sm text-slate-400">
                    Keep details precise so candidates stay aligned with the role expectations.
                </p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a
                    href="{{ route('employer.jobs.show', $job) }}"
                    class="inline-flex items-center gap-2 rounded-full border border-white/10 px-5 py-2.5 text-sm font-semibold text-slate-200 transition hover:-translate-y-0.5 hover:border-emerald-400/40 hover:text-emerald-200"
                >
                    <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7Z" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    Preview
                </a>
                <a
                    href="{{ route('employer.jobs.index') }}"
                    class="inline-flex items-center gap-2 rounded-full border border-white/10 px-5 py-2.5 text-sm font-semibold text-slate-200 transition hover:-translate-y-0.5 hover:border-cyan-400/40 hover:text-cyan-200"
                >
                    Back to list
                </a>
            </div>
        </header>

        <form
            action="{{ route('employer.jobs.update', $job) }}"
            method="POST"
            enctype="multipart/form-data"
            novalidate
            class="space-y-6 rounded-3xl border border-white/5 bg-white/5 p-6 shadow-2xl"
        >
            @csrf
            @method('PUT')

            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <label class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Title</label>
                    <input
                        type="text"
                        name="title"
                        value="{{ old('title', $job->title) }}"
                        required
                        class="mt-2 w-full rounded-2xl border border-white/10 bg-slate-950/40 px-4 py-2.5 text-sm text-white placeholder:text-slate-500 focus:border-cyan-400/50 focus:outline-none"
                    >
                    @error('title')
                        <p class="mt-2 text-xs text-rose-300">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Category</label>
                    <select
                        name="category_id"
                        required
                        class="mt-2 w-full rounded-2xl border border-white/10 bg-slate-950/40 px-4 py-2.5 text-sm text-white focus:border-cyan-400/50 focus:outline-none"
                    >
                        <option value="">Select category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id', $job->category_id) == $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-2 text-xs text-rose-300">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Location</label>
                    <input
                        type="text"
                        name="location"
                        value="{{ old('location', $job->location) }}"
                        class="mt-2 w-full rounded-2xl border border-white/10 bg-slate-950/40 px-4 py-2.5 text-sm text-white placeholder:text-slate-500 focus:border-cyan-400/50 focus:outline-none"
                    >
                    @error('location')
                        <p class="mt-2 text-xs text-rose-300">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Salary range</label>
                    <input
                        type="text"
                        name="salary_range"
                        value="{{ old('salary_range', $job->salary_range) }}"
                        class="mt-2 w-full rounded-2xl border border-white/10 bg-slate-950/40 px-4 py-2.5 text-sm text-white placeholder:text-slate-500 focus:border-cyan-400/50 focus:outline-none"
                    >
                    @error('salary_range')
                        <p class="mt-2 text-xs text-rose-300">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Work type</label>
                    <select
                        name="work_type"
                        required
                        class="mt-2 w-full rounded-2xl border border-white/10 bg-slate-950/40 px-4 py-2.5 text-sm text-white focus:border-emerald-400/50 focus:outline-none"
                    >
                        <option value="">Choose work style</option>
                        <option value="remote" @selected(old('work_type', $job->work_type) === 'remote')>Remote</option>
                        <option value="onsite" @selected(old('work_type', $job->work_type) === 'onsite')>On-site</option>
                        <option value="hybrid" @selected(old('work_type', $job->work_type) === 'hybrid')>Hybrid</option>
                    </select>
                    @error('work_type')
                        <p class="mt-2 text-xs text-rose-300">{{ $message }}</p>
                    @enderror
                </div>
                <div>
    <label class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Application deadline</label>
    <input
        type="date"
        name="application_deadline"
        value="{{ old('application_deadline', $job->application_deadline ? \Illuminate\Support\Carbon::parse($job->application_deadline)->format('Y-m-d') : '') }}"
        min="{{ now()->format('Y-m-d') }}"
        class="mt-2 w-full rounded-2xl border border-white/10 bg-slate-950/40 px-4 py-2.5 text-sm text-white focus:border-cyan-400/50 focus:outline-none"
    >
    @error('application_deadline')
        <p class="mt-2 text-xs text-rose-300">{{ $message }}</p>
    @enderror
</div>

            </div>

            <div class="grid gap-6 lg:grid-cols-2">
                <div class="space-y-2">
                    <label class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Responsibilities</label>
                    <textarea
                        name="responsibilities"
                        rows="6"
                        required
                        class="w-full rounded-2xl border border-white/10 bg-slate-950/40 px-4 py-3 text-sm text-white placeholder:text-slate-500 focus:border-cyan-400/50 focus:outline-none"
                    >{{ old('responsibilities', $job->responsibilities) }}</textarea>
                    @error('responsibilities')
                        <p class="text-xs text-rose-300">{{ $message }}</p>
                    @enderror
                </div>
                <div class="space-y-2">
                    <label class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Requirements</label>
                    <textarea
                        name="requirements"
                        rows="6"
                        required
                        class="w-full rounded-2xl border border-white/10 bg-slate-950/40 px-4 py-3 text-sm text-white placeholder:text-slate-500 focus:border-cyan-400/50 focus:outline-none"
                    >{{ old('requirements', $job->requirements) }}</textarea>
                    @error('requirements')
                        <p class="text-xs text-rose-300">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Description</label>
                <textarea
                    name="description"
                    rows="6"
                    class="w-full rounded-2xl border border-white/10 bg-slate-950/40 px-4 py-3 text-sm text-white placeholder:text-slate-500 focus:border-cyan-400/50 focus:outline-none"
                    placeholder="Bring the role to life with mission, team context, and success outcomes."
                >{{ old('description', $job->description) }}</textarea>
                @error('description')
                    <p class="text-xs text-rose-300">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <label class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Skills</label>
                    <textarea
                        name="skills"
                        rows="4"
                        required
                        class="mt-2 w-full rounded-2xl border border-white/10 bg-slate-950/40 px-4 py-3 text-sm text-white placeholder:text-slate-500 focus:border-cyan-400/50 focus:outline-none"
                    >{{ old('skills', $job->skills) }}</textarea>
                    @error('skills')
                        <p class="mt-2 text-xs text-rose-300">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Technologies</label>
                    <input
                        type="text"
                        name="technologies"
                        value="{{ old('technologies', $job->technologies) }}"
                        class="mt-2 w-full rounded-2xl border border-white/10 bg-slate-950/40 px-4 py-2.5 text-sm text-white placeholder:text-slate-500 focus:border-cyan-400/50 focus:outline-none"
                        placeholder="e.g., PHP, Laravel, MySQL"
                    >
                    @error('technologies')
                        <p class="mt-2 text-xs text-rose-300">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <label class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Benefits</label>
                    <textarea
                        name="benefits"
                        rows="4"
                        class="mt-2 w-full rounded-2xl border border-white/10 bg-slate-950/40 px-4 py-3 text-sm text-white placeholder:text-slate-500 focus:border-cyan-400/50 focus:outline-none"
                    >{{ old('benefits', $job->benefits) }}</textarea>
                    @error('benefits')
                        <p class="mt-2 text-xs text-rose-300">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Company Logo</label>
                    
                    <!-- File input -->
                    <input
                        type="file"
                        name="logo"
                        accept="image/*"
                        class="mt-2 block w-full rounded-2xl border border-white/10 bg-slate-950/40 px-4 py-2.5 text-sm text-slate-200 file:mr-4 file:rounded-full file:border-0 file:bg-cyan-400/20 file:px-4 file:py-1.5 file:text-cyan-200 file:transition hover:file:bg-cyan-400/30 focus:border-cyan-400/50 focus:outline-none"
                    >
                    @error('logo')
                        <p class="mt-2 text-xs text-rose-300">{{ $message }}</p>
                    @enderror

                    <!-- Show current logo if available -->
                    @if ($job->logo)
                        <div class="mt-4">
                            <p class="text-xs text-slate-400 mb-2">Current Logo:</p>
                            <img
                                src="{{ asset('storage/' . $job->logo) }}"
                                alt="Company Logo"
                                class="h-20 w-20 rounded-xl object-cover border border-white/10"
                            >
                        </div>
                    @endif
            </div>

            <div class="flex flex-col gap-3 border-t border-white/10 pt-6 sm:flex-row sm:items-center sm:justify-between">
                <p class="text-xs text-slate-500">
                    Last updated {{ optional($job->updated_at)?->diffForHumans() ?? '—' }} • Keep your job post fresh for candidates.
                </p>
                <button
                    type="submit"
                    class="inline-flex items-center gap-2 rounded-full border border-cyan-400/40 bg-cyan-400/10 px-6 py-2.5 text-sm font-semibold text-cyan-200 transition hover:-translate-y-0.5 hover:bg-cyan-400/20"
                >
                    <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M17 17 7 7m0 0v8m0-8h8" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    Save changes
                </button>
            </div>
        </form>
    </div>
</x-employer-layout>
