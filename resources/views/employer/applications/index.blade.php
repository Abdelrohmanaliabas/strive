<x-employer-layout>
    <div class="space-y-10 px-6 py-10 lg:px-12">
        <header class="flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.35em] text-emerald-300/80">Strive pipeline</p>
                <h1 class="mt-2 text-3xl font-bold text-white">Applications</h1>
                <p class="mt-2 text-sm text-slate-400">
                    Track candidates, follow up instantly, and keep every decision transparent.
                </p>
            </div>
            <a
                href="{{ route('employer.jobs.index') }}"
                class="inline-flex items-center gap-2 rounded-full border border-white/10 px-5 py-2.5 text-sm font-semibold text-slate-200 transition hover:-translate-y-0.5 hover:border-cyan-400/40 hover:text-cyan-200"
            >
                Back to jobs
            </a>
        </header>

        <section class="overflow-hidden rounded-3xl border border-white/5 bg-white/5 shadow-2xl">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-white/10 text-sm text-slate-200">
                    <thead>
                        <tr class="bg-white/5 text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">
                            <th class="px-6 py-4 text-left">Candidate</th>
                            <th class="px-6 py-4 text-left">Role</th>
                            <th class="px-6 py-4 text-left">Status</th>
                            <th class="px-6 py-4 text-left">Applied</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse ($applications as $application)
                            @php
                                $statusKey = strtolower($application->status ?? 'pending');
                                $statusPalette = match ($statusKey) {
                                    'accepted' => ['dot' => 'bg-emerald-400', 'classes' => 'border-emerald-400/40 bg-emerald-400/10 text-emerald-200', 'label' => 'Accepted'],
                                    'rejected' => ['dot' => 'bg-rose-400', 'classes' => 'border-rose-400/40 bg-rose-400/10 text-rose-200', 'label' => 'Rejected'],
                                    default => ['dot' => 'bg-amber-300', 'classes' => 'border-white/10 bg-white/5 text-amber-200', 'label' => 'Pending'],
                                };
                            @endphp
                            <tr class="transition hover:bg-white/5">
                                <td class="px-6 py-4 align-top">
                                    <p class="font-semibold text-white">
                                        {{ $application->name ?? optional($application->candidate)->name ?? 'New applicant' }}
                                    </p>
                                    <p class="text-xs text-slate-400">
                                        {{ $application->email ?? optional($application->candidate)->email ?? '—' }}
                                    </p>
                                </td>
                                <td class="px-6 py-4 align-top text-slate-300">
                                    {{ optional($application->jobPost)->title ?? 'Role archived' }}
                                </td>
                                <td class="px-6 py-4 align-top">
                                    <span class="inline-flex items-center gap-2 rounded-full border px-3 py-1 text-xs font-semibold {{ $statusPalette['classes'] }}">
                                        <span class="h-1.5 w-1.5 rounded-full {{ $statusPalette['dot'] }}"></span>
                                        {{ $statusPalette['label'] }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 align-top text-xs text-slate-400">
                                    {{ optional($application->created_at)?->diffForHumans() ?? 'just now' }}
                                </td>
                                <td class="px-6 py-4 align-top">
                                    <div class="flex flex-wrap justify-end gap-2">
                                        <a
                                            href="{{ route('employer.applications.show', $application) }}"
                                            class="inline-flex items-center gap-2 rounded-full border border-white/10 px-4 py-2 text-xs font-semibold text-slate-200 transition hover:-translate-y-0.5 hover:border-emerald-400/40 hover:text-emerald-200"
                                        >
                                            View
                                        </a>
                                        @if ($statusKey === 'pending')
                                            <form
                                                action="{{ route('employer.applications.update-status', $application) }}"
                                                method="POST"
                                                class="inline-flex"
                                            >
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="accepted">
                                                <button
                                                    type="submit"
                                                    class="inline-flex items-center gap-2 rounded-full border border-emerald-400/40 bg-emerald-400/10 px-4 py-2 text-xs font-semibold text-emerald-200 transition hover:-translate-y-0.5 hover:bg-emerald-400/20"
                                                >
                                                    Accept
                                                </button>
                                            </form>
                                            <form
                                                action="{{ route('employer.applications.update-status', $application) }}"
                                                method="POST"
                                                class="inline-flex"
                                            >
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="rejected">
                                                <button
                                                    type="submit"
                                                    class="inline-flex items-center gap-2 rounded-full border border-rose-400/40 bg-rose-400/10 px-4 py-2 text-xs font-semibold text-rose-200 transition hover:-translate-y-0.5 hover:bg-rose-400/20"
                                                >
                                                    Reject
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-sm text-slate-400">
                                    No applications yet. Once candidates apply, they will appear here.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($applications instanceof \Illuminate\Contracts\Pagination\Paginator)
                <div class="border-t border-white/10 bg-white/5 px-6 py-4">
                    <div class="flex justify-center">
                        {{ $applications->links() }}
                    </div>
                </div>
            @endif
        </section>
    </div>
</x-employer-layout>
