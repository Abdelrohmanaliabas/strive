<x-employer-layout>
    <div class="space-y-10 px-6 py-10 lg:px-12">
        <header class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.35em] text-emerald-300/80">Launch a role</p>
                <h1 class="mt-2 text-3xl font-bold text-white">Post a new job</h1>
                <p class="mt-2 text-sm text-slate-400">
                    Share the opportunity, highlight impact, and welcome candidates into your pipeline.
                </p>
            </div>
            <a
                href="{{ route('employer.jobs.index') }}"
                class="inline-flex items-center gap-2 rounded-full border border-white/10 px-5 py-2.5 text-sm font-semibold text-slate-200 transition hover:-translate-y-0.5 hover:border-cyan-400/40 hover:text-cyan-200"
            >
                <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M15 19 8 12l7-7" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                Back to listings
            </a>
        </header>

        <form
            action="{{ route('employer.jobs.store') }}"
            method="POST"
            enctype="multipart/form-data"
            novalidate
            class="space-y-6 rounded-3xl border border-white/5 bg-white/5 p-6 shadow-2xl"
        >
            @csrf

            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <label class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Title</label>
                    <input
                        type="text"
                        name="title"
                        value="{{ old('title') }}"
                        required
                        placeholder="e.g., Senior Laravel Engineer"
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
                            <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
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
                        value="{{ old('location') }}"
                        placeholder="e.g., Remote • Cairo, Egypt"
                        class="mt-2 w-full rounded-2xl border border-white/10 bg-slate-950/40 px-4 py-2.5 text-sm text-white placeholder:text-slate-500 focus:border-cyan-400/50 focus:outline-none"
                    >
                    @error('location')
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
                        <option value="remote" @selected(old('work_type') == 'remote')>Remote</option>
                        <option value="onsite" @selected(old('work_type') == 'onsite')>On-site</option>
                        <option value="hybrid" @selected(old('work_type') == 'hybrid')>Hybrid</option>
                    </select>
                    @error('work_type')
                        <p class="mt-2 text-xs text-rose-300">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Salary range</label>
                    <input
                        type="text"
                        name="salary_range"
                        value="{{ old('salary_range') }}"
                        placeholder="e.g., 80,000 – 110,000 EGP"
                        class="mt-2 w-full rounded-2xl border border-white/10 bg-slate-950/40 px-4 py-2.5 text-sm text-white placeholder:text-slate-500 focus:border-cyan-400/50 focus:outline-none"
                    >
                    @error('salary_range')
                        <p class="mt-2 text-xs text-rose-300">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Deadline</label>
                    <input
                        type="date"
                        name="application_deadline"
                        value="{{ old('application_deadline') }}"
                        min="{{ now()->format('Y-m-d') }}"
                        class="mt-2 w-full rounded-2xl border border-white/10 bg-slate-950/40 px-4 py-3 text-sm text-white placeholder:text-slate-500 focus:border-cyan-400/50 focus:outline-none"
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
                        placeholder="Outline the impact, responsibilities, and first 90 days."
                        class="w-full rounded-2xl border border-white/10 bg-slate-950/40 px-4 py-3 text-sm text-white placeholder:text-slate-500 focus:border-cyan-400/50 focus:outline-none"
                    >{{ old('responsibilities') }}</textarea>
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
                        placeholder="List the must-haves and nice-to-haves."
                        class="w-full rounded-2xl border border-white/10 bg-slate-950/40 px-4 py-3 text-sm text-white placeholder:text-slate-500 focus:border-cyan-400/50 focus:outline-none"
                    >{{ old('requirements') }}</textarea>
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
                    placeholder="Bring the role to life with mission, team context, and success outcomes."
                    class="w-full rounded-2xl border border-white/10 bg-slate-950/40 px-4 py-3 text-sm text-white placeholder:text-slate-500 focus:border-cyan-400/50 focus:outline-none"
                >{{ old('description') }}</textarea>
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
                        placeholder="List core skills, tools, or languages (comma separated)."
                        class="mt-2 w-full rounded-2xl border border-white/10 bg-slate-950/40 px-4 py-3 text-sm text-white placeholder:text-slate-500 focus:border-cyan-400/50 focus:outline-none"
                    >{{ old('skills') }}</textarea>
                    @error('skills')
                        <p class="mt-2 text-xs text-rose-300">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Technologies</label>
                    <input
                        type="text"
                        name="technologies"
                        value="{{ old('technologies') }}"
                        placeholder="e.g., PHP, Laravel, MySQL"
                        class="mt-2 w-full rounded-2xl border border-white/10 bg-slate-950/40 px-4 py-2.5 text-sm text-white placeholder:text-slate-500 focus:border-cyan-400/50 focus:outline-none"
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
                        placeholder="Share perks, allowances, wellness support, or growth programs."
                        class="mt-2 w-full rounded-2xl border border-white/10 bg-slate-950/40 px-4 py-3 text-sm text-white placeholder:text-slate-500 focus:border-cyan-400/50 focus:outline-none"
                    >{{ old('benefits') }}</textarea>
                    @error('benefits')
                        <p class="mt-2 text-xs text-rose-300">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Company Logo</label>
                    <input
                        type="file"
                        name="logo"
                        accept="image/*"
                        class="mt-2 w-full cursor-pointer rounded-2xl border border-white/10 bg-slate-950/40 px-4 py-2.5 text-sm text-white file:mr-4 file:rounded-full file:border-0 file:bg-cyan-400/20 file:px-4 file:py-2 file:text-cyan-200 hover:file:bg-cyan-400/30 focus:border-cyan-400/50 focus:outline-none"
                    >
                    @error('logo')
                        <p class="mt-2 text-xs text-rose-300">{{ $message }}</p>
                    @enderror

                    @if (old('logo'))
                        <p class="mt-2 text-xs text-slate-400">Previously uploaded: {{ old('logo') }}</p>
                    @endif
                </div>
            </div>

            <div class="flex flex-col gap-3 border-t border-white/10 pt-6 sm:flex-row sm:items-center sm:justify-between">
                <p class="text-xs text-slate-500">
                    Double-check the role essentials before publishing. You can always refine later.
                </p>
                <button
                    type="submit"
                    class="inline-flex items-center gap-2 rounded-full border border-cyan-400/40 bg-cyan-400/10 px-6 py-2.5 text-sm font-semibold text-cyan-200 transition hover:-translate-y-0.5 hover:bg-cyan-400/20"
                >
                    <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M12 5v14m7-7H5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    Publish job
                </button>
            </div>
        </form>
    </div>
</x-employer-layout>
