<x-employer-layout>
    @php
        $statusKey = strtolower($application->status ?? 'pending');
        $statusPalette = match ($statusKey) {
            'accepted' => ['dot' => 'bg-emerald-400', 'classes' => 'border-emerald-400/40 bg-emerald-400/10 text-emerald-200', 'label' => 'Accepted'],
            'rejected' => ['dot' => 'bg-rose-400', 'classes' => 'border-rose-400/40 bg-rose-400/10 text-rose-200', 'label' => 'Rejected'],
            default => ['dot' => 'bg-amber-300', 'classes' => 'border-white/10 bg-white/5 text-amber-200', 'label' => 'Pending'],
        };
    @endphp

    <div class="space-y-10 px-6 py-10 lg:px-12">
        <header class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.35em] text-cyan-200/80">Application dossier</p>
                <h1 class="mt-2 text-3xl font-bold text-white">
                    {{ $application->name ?? optional($application->candidate)->name ?? 'Candidate' }}
                </h1>
                <p class="mt-2 text-sm text-slate-400">
                    Applied for {{ optional($application->jobPost)->title ?? 'archived role' }}
                </p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a
                    href="{{ route('employer.applications.index') }}"
                    class="inline-flex items-center gap-2 rounded-full border border-white/10 px-5 py-2.5 text-sm font-semibold text-slate-200 transition hover:-translate-y-0.5 hover:border-emerald-400/40 hover:text-emerald-200"
                >
                    Back to applications
                </a>
                @if ($statusKey === 'pending')
                    <form action="{{ route('employer.applications.update-status', $application) }}" method="POST" class="inline-flex">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="accepted">
                        <button
                            type="submit"
                            class="inline-flex items-center gap-2 rounded-full border border-emerald-400/40 bg-emerald-400/10 px-5 py-2.5 text-sm font-semibold text-emerald-200 transition hover:-translate-y-0.5 hover:bg-emerald-400/20"
                        >
                            Accept
                        </button>
                    </form>
                    <form action="{{ route('employer.applications.update-status', $application) }}" method="POST" class="inline-flex">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="rejected">
                        <button
                            type="submit"
                            class="inline-flex items-center gap-2 rounded-full border border-rose-400/40 bg-rose-400/10 px-5 py-2.5 text-sm font-semibold text-rose-200 transition hover:-translate-y-0.5 hover:bg-rose-400/20"
                        >
                            Reject
                        </button>
                    </form>
                @endif
            </div>
        </header>

        <section class="grid gap-6 lg:grid-cols-12">
            <article class="space-y-6 rounded-3xl border border-white/5 bg-white/5 p-6 shadow-2xl lg:col-span-8">
                <div class="space-y-3">
                    <h2 class="text-lg font-semibold text-white">Candidate overview</h2>
                    <dl class="grid gap-4 text-sm text-slate-200 sm:grid-cols-2">
                        <div class="rounded-2xl border border-white/10 bg-slate-950/60 p-4">
                            <dt class="text-xs uppercase tracking-[0.25em] text-slate-500">Email</dt>
                            <dd class="mt-2 text-white">{{ $application->email ?? optional($application->candidate)->email ?? '—' }}</dd>
                        </div>
                        <div class="rounded-2xl border border-white/10 bg-slate-950/60 p-4">
                            <dt class="text-xs uppercase tracking-[0.25em] text-slate-500">Phone</dt>
                            <dd class="mt-2 text-white">{{ $application->phone ?? '—' }}</dd>
                        </div>
                    </dl>
                </div>

                <div class="space-y-3">
                    <h2 class="text-lg font-semibold text-white">Status &amp; timing</h2>
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div class="space-y-3 rounded-2xl border border-white/10 bg-slate-950/60 p-4">
                            <p class="text-xs uppercase tracking-[0.25em] text-slate-500">Stage</p>
                            <span class="inline-flex items-center gap-2 rounded-full border px-3 py-1 text-xs font-semibold {{ $statusPalette['classes'] }}">
                                <span class="h-1.5 w-1.5 rounded-full {{ $statusPalette['dot'] }}"></span>
                                {{ $statusPalette['label'] }}
                            </span>
                        </div>
                        <div class="rounded-2xl border border-white/10 bg-slate-950/60 p-4">
                            <p class="text-xs uppercase tracking-[0.25em] text-slate-500">Applied</p>
                            <p class="mt-2 text-lg font-semibold text-white">
                                {{ optional($application->created_at)?->toDayDateTimeString() ?? 'just now' }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="space-y-3">
            <h2 class="text-lg font-semibold text-white">Resume</h2>

            <div class="rounded-2xl border border-white/10 bg-slate-950/60 p-6 text-sm text-slate-200">
                @if ($application->resume)
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <i class="bi bi-file-earmark-pdf text-red-500 text-xl"></i>
                        <span class="text-slate-300">Candidate Resume</span>

                        <div class="flex items-center gap-2">
                            <!-- Preview Button -->
                            <button
                                id="previewResumeBtn"
                                data-url="{{ route('employer.applications.preview', $application->id) }}"
                                class="inline-flex items-center gap-2 rounded-full border border-emerald-400/40 bg-emerald-400/10 px-4 py-2 text-sm font-semibold text-emerald-200 transition hover:-translate-y-0.5 hover:bg-emerald-400/20"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 10l4.553 2.276a1 1 0 010 1.448L15 16m-6 0l-4.553-2.276a1 1 0 010-1.448L9 10m3 0v6" />
                                </svg>
                                Preview
                            </button>

                        <!-- Download Button -->
                        <button
                            id="downloadResumeBtn"
                            data-url="{{ route('employer.applications.download', $application->id) }}"
                            class="inline-flex items-center gap-2 rounded-full border border-cyan-400/40 bg-cyan-400/10 px-4 py-2 text-sm font-semibold text-cyan-200 transition hover:-translate-y-0.5 hover:bg-cyan-400/20"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            Download
                        </button>
                    </div>

                @else
                    <p class="text-slate-400">The candidate has not attached a resume yet.</p>
                @endif
            </div>
        </div>

        <!-- Resume Preview Modal -->
        <div id="resumeModal" class="fixed inset-0 z-50 hidden bg-black/60 backdrop-blur-sm flex items-center justify-center p-4">
            <div class="bg-slate-900 rounded-2xl shadow-2xl w-full max-w-4xl h-[80vh] flex flex-col overflow-hidden">
                <!-- Modal Header -->
                <div class="flex justify-between items-center border-b border-white/10 px-4 py-3">
                    <h3 class="text-white font-semibold text-lg">Resume Preview</h3>
                    <button id="closeModalBtn" class="text-slate-400 hover:text-white transition">
                        ✕
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="flex-1 bg-black">
                    <iframe id="resumeFrame" src="" class="w-full h-full" frameborder="0"></iframe>
                </div>
            </div>
        </div>
        </article>
            <aside class="space-y-6 lg:col-span-4">
                <div class="rounded-3xl border border-white/5 bg-gradient-to-br from-emerald-500/15 via-cyan-500/10 to-transparent p-6 shadow-2xl">
                    <h2 class="text-base font-semibold text-white">Role details</h2>
                    <dl class="mt-4 space-y-3 text-sm text-slate-200">
                        <div class="flex items-center justify-between rounded-2xl border border-white/10 bg-slate-950/60 px-4 py-3">
                            <dt class="text-xs uppercase tracking-[0.25em] text-slate-500">Title</dt>
                            <dd class="font-semibold text-white">{{ optional($application->jobPost)->title ?? '—' }}</dd>
                        </div>
                        <div class="flex items-center justify-between rounded-2xl border border-white/10 bg-slate-950/60 px-4 py-3">
                            <dt class="text-xs uppercase tracking-[0.25em] text-slate-500">Category</dt>
                            <dd class="font-semibold text-white">
                                {{ optional(optional($application->jobPost)->category)->name ?? 'Uncategorized' }}
                            </dd>
                        </div>
                        <div class="flex items-center justify-between rounded-2xl border border-white/10 bg-slate-950/60 px-4 py-3">
                            <dt class="text-xs uppercase tracking-[0.25em] text-slate-500">Work type</dt>
                            <dd class="font-semibold text-white">
                                {{ ucfirst(optional($application->jobPost)->work_type ?? 'hybrid') }}
                            </dd>
                        </div>
                    </dl>
                </div>

            </aside>
        </section>
    </div>  
</x-employer-layout>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const previewBtn = document.querySelector("#previewResumeBtn");
    const downloadBtn = document.querySelector("#downloadResumeBtn");
    const modal = document.querySelector("#resumeModal");
    const iframe = document.querySelector("#resumeFrame");
    const closeBtn = document.querySelector("#closeModalBtn");

    if (!previewBtn || !downloadBtn || !modal || !iframe) return;

    // Preview button: open modal 
    previewBtn.addEventListener("click", (e) => {
        e.preventDefault();
        e.stopPropagation(); // stop event bubbling to parent
        const fileUrl = previewBtn.dataset.url;
        iframe.src = fileUrl;
        modal.classList.remove("hidden");
        document.body.classList.add("overflow-hidden");
    });

    // Download button: trigger real file download
    downloadBtn.addEventListener("click", (e) => {
        e.preventDefault();
        e.stopPropagation(); // prevent double triggers
        const fileUrl = downloadBtn.dataset.url;
        window.open(fileUrl, "_blank"); 
    });

    // Close modal button
    closeBtn.addEventListener("click", () => {
        iframe.src = "";
        modal.classList.add("hidden");
        document.body.classList.remove("overflow-hidden");
    });

    // Close modal when clicking outside iframe
    modal.addEventListener("click", (e) => {
        if (e.target === modal) {
            iframe.src = "";
            modal.classList.add("hidden");
            document.body.classList.remove("overflow-hidden");
        }
    });
});
</script>

