<x-employer-layout>
    <div class="relative min-h-full px-4 py-8 text-white sm:px-8">
        <div class="mx-auto max-w-5xl space-y-8">
            @if (session('status') === 'profile-updated')
                <div class="rounded-2xl border border-white/10 bg-slate-950/80 px-4 py-3 text-sm text-cyan-300 shadow-lg shadow-black/40">
                    Profile updated successfully.
                </div>
            @elseif (session('status') === 'account-deleted')
                <div class="rounded-2xl border border-red-500/40 bg-red-500/10 px-4 py-3 text-sm text-red-200 shadow-lg shadow-black/40">
                    Account deleted.
                </div>
            @endif

            <div class="grid gap-6 lg:grid-cols-3 ">
                <aside class="rounded-3xl border text-center h-full  border-white/10 bg-slate-950/80 p-6 shadow-[0_30px_60px_rgba(0,0,0,0.6)] space-y-10">
                    <div class="flex items-center gap-4">
                        <img
                            src="{{ $user->avatar_url }}"
                            alt="{{ $user->name }}"
                            class="h-full w-full rounded-2xl border border-white/10 object-cover shadow-lg shadow-black/40"
                        >
                    </div>
                    <div>
                        <p class="text-xs uppercase tracking-[0.4em] text-cyan-300">Employer</p>
                        <h1 class="text-xl font-semibold text-white">{{ $user->name }}</h1>
                        <p class="text-sm text-slate-300">{{ $user->email }}</p>
                    </div>


                </aside>

                <section class="rounded-3xl border border-white/10 bg-slate-950/80 p-6 shadow-[0_30px_60px_rgba(0,0,0,0.6)] lg:col-span-2">
                    <form method="POST" action="{{ route('employer.profile.update') }}" enctype="multipart/form-data" class="space-y-5">
                        @csrf
                        @method('PUT')

                        <div class="grid gap-4 sm:grid-cols-2">
                            <div>
                                <label class="text-xs uppercase tracking-[0.3em] text-cyan-300">Name</label>
                                <input
                                    type="text"
                                    name="name"
                                    value="{{ old('name', $user->name) }}"
                                    class="mt-2 w-full rounded-xl border border-white/10 bg-slate-950 px-4 py-2 text-sm text-white focus:border-cyan-300 focus:ring-0"
                                    required
                                >
                                @error('name')
                                    <p class="mt-1 text-xs text-red-300">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="text-xs uppercase tracking-[0.3em] text-cyan-300">Email</label>
                                <input
                                    type="email"
                                    name="email"
                                    value="{{ old('email', $user->email) }}"
                                    class="mt-2 w-full rounded-xl border border-white/10 bg-slate-950 px-4 py-2 text-sm text-white focus:border-cyan-300 focus:ring-0"
                                    required
                                >
                                @error('email')
                                    <p class="mt-1 text-xs text-red-300">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="text-xs uppercase tracking-[0.3em] text-cyan-300">Phone</label>
                                <input
                                    type="text"
                                    name="phone"
                                    value="{{ old('phone', $user->phone) }}"
                                    class="mt-2 w-full rounded-xl border border-white/10 bg-slate-950 px-4 py-2 text-sm text-white focus:border-cyan-300 focus:ring-0"
                                >
                                @error('phone')
                                    <p class="mt-1 text-xs text-red-300">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="text-xs uppercase tracking-[0.3em] text-cyan-300">LinkedIn URL</label>
                                <input
                                    type="url"
                                    name="linkedin_url"
                                    value="{{ old('linkedin_url', $user->linkedin_url) }}"
                                    class="mt-2 w-full rounded-xl border border-white/10 bg-slate-950 px-4 py-2 text-sm text-white focus:border-cyan-300 focus:ring-0"
                                >
                                @error('linkedin_url')
                                    <p class="mt-1 text-xs text-red-300">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid gap-4 sm:grid-cols-2">
                            <div>
                                <label class="text-xs uppercase tracking-[0.3em] text-cyan-300">New password</label>
                                <input
                                    type="password"
                                    name="password"
                                    class="mt-2 w-full rounded-xl border border-white/10 bg-slate-950 px-4 py-2 text-sm text-white focus:border-cyan-300 focus:ring-0"
                                    placeholder="Leave blank to keep current"
                                >
                                @error('password')
                                    <p class="mt-1 text-xs text-red-300">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="text-xs uppercase tracking-[0.3em] text-cyan-300">Confirm password</label>
                                <input
                                    type="password"
                                    name="password_confirmation"
                                    class="mt-2 w-full rounded-xl border border-white/10 bg-slate-950 px-4 py-2 text-sm text-white focus:border-cyan-300 focus:ring-0"
                                >
                            </div>
                        </div>

                        <div>
                            <label class="text-xs uppercase tracking-[0.3em] text-cyan-300">Profile image</label>
                            <input
                                type="file"
                                name="avatar"
                                accept="image/*"
                                class="mt-2 w-full text-sm text-slate-200"
                            >
                            <p class="mt-1 text-xs text-slate-400">PNG or JPG up to 2MB.</p>
                            @error('avatar')
                                <p class="mt-1 text-xs text-red-300">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end">
                            <button
                                type="submit"
                                class="rounded-full bg-gradient-to-r from-cyan-400 to-emerald-300 px-6 py-2 text-sm font-semibold text-white shadow-lg shadow-cyan-500/30 transition hover:-translate-y-0.5"
                            >
                                Save changes
                            </button>
                        </div>
                    </form>
                </section>
            </div>

            <section class="rounded-3xl border border-red-500/40 bg-gradient-to-r from-red-950/80 to-slate-950 p-6 shadow-[0_30px_70px_rgba(0,0,0,0.65)]">
                <header>
                    <h2 class="text-xl font-semibold text-white">Delete account</h2>
                    <p class="mt-1 text-sm text-red-200">
                        Permanently remove your account and employer data. This cannot be undone.
                    </p>
                </header>
                <form method="POST" action="{{ route('employer.profile.destroy') }}" class="mt-4 space-y-3">
                    @csrf
                    @method('DELETE')
                    <label class="text-xs uppercase tracking-[0.3em] text-red-200">Confirm password</label>
                    <input
                        type="password"
                        name="password"
                        class="w-full rounded-xl border border-red-500/30 bg-slate-950 px-4 py-2 text-sm text-white focus:border-red-300 focus:ring-0"
                        required
                    >
                    @error('password')
                        <p class="text-xs text-red-300">{{ $message }}</p>
                    @enderror
                    <button
                        type="submit"
                        class="w-full rounded-full border border-red-400 bg-red-500/20 px-4 py-2 text-sm font-semibold text-red-100 transition hover:bg-red-500/30"
                    >
                        Delete this account
                    </button>
                </form>
            </section>
        </div>
    </div>
</x-employer-layout>


