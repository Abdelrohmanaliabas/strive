<x-employer-layout>
    <div class="relative min-h-full bg-[#050715] px-4 py-8 text-[#dbe1ff] sm:px-8">
        <div class="mx-auto max-w-5xl space-y-8">
            @if (session('status') === 'profile-updated')
                <div class="rounded-2xl border border-[#2f386d] bg-[#111630] px-4 py-3 text-sm text-[#7ee3ff] shadow-lg shadow-black/40">
                    Profile updated successfully.
                </div>
            @elseif (session('status') === 'account-deleted')
                <div class="rounded-2xl border border-red-500/40 bg-red-500/10 px-4 py-3 text-sm text-red-200 shadow-lg shadow-black/40">
                    Account deleted.
                </div>
            @endif

            <div class="grid gap-6 lg:grid-cols-3">
                <aside class="rounded-3xl border border-[#262c52] bg-[#0b0f25]/90 p-6 shadow-[0_30px_60px_rgba(0,0,0,0.6)] space-y-4">
                    <div class="flex items-center gap-4">
                        <img
                            src="{{ $user->avatar_url }}"
                            alt="{{ $user->name }}"
                            class="h-20 w-20 rounded-2xl border border-[#262c52] object-cover shadow-lg shadow-black/40"
                        >
                        <div>
                            <p class="text-xs uppercase tracking-[0.4em] text-[#8ea1ff]">Employer</p>
                            <h1 class="text-xl font-semibold text-white">{{ $user->name }}</h1>
                            <p class="text-sm text-[#9ea7df]">{{ $user->email }}</p>
                        </div>
                    </div>
                    <p class="text-xs text-[#9ea7df]">
                        Keep your employer profile up to date so candidates know who they are working with.
                    </p>
                </aside>

                <section class="rounded-3xl border border-[#262c52] bg-[#0b0f25]/90 p-6 shadow-[0_30px_60px_rgba(0,0,0,0.6)] lg:col-span-2">
                    <form method="POST" action="{{ route('employer.profile.update') }}" enctype="multipart/form-data" class="space-y-5">
                        @csrf
                        @method('PUT')

                        <div class="grid gap-4 sm:grid-cols-2">
                            <div>
                                <label class="text-xs uppercase tracking-[0.3em] text-[#8ea1ff]">Name</label>
                                <input
                                    type="text"
                                    name="name"
                                    value="{{ old('name', $user->name) }}"
                                    class="mt-2 w-full rounded-xl border border-[#252a4d] bg-[#0b0f25] px-4 py-2 text-sm text-white focus:border-[#7ee3ff] focus:ring-0"
                                    required
                                >
                                @error('name')
                                    <p class="mt-1 text-xs text-red-300">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="text-xs uppercase tracking-[0.3em] text-[#8ea1ff]">Email</label>
                                <input
                                    type="email"
                                    name="email"
                                    value="{{ old('email', $user->email) }}"
                                    class="mt-2 w-full rounded-xl border border-[#252a4d] bg-[#0b0f25] px-4 py-2 text-sm text-white focus:border-[#7ee3ff] focus:ring-0"
                                    required
                                >
                                @error('email')
                                    <p class="mt-1 text-xs text-red-300">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="text-xs uppercase tracking-[0.3em] text-[#8ea1ff]">Phone</label>
                                <input
                                    type="text"
                                    name="phone"
                                    value="{{ old('phone', $user->phone) }}"
                                    class="mt-2 w-full rounded-xl border border-[#252a4d] bg-[#0b0f25] px-4 py-2 text-sm text-white focus:border-[#7ee3ff] focus:ring-0"
                                >
                                @error('phone')
                                    <p class="mt-1 text-xs text-red-300">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="text-xs uppercase tracking-[0.3em] text-[#8ea1ff]">LinkedIn URL</label>
                                <input
                                    type="url"
                                    name="linkedin_url"
                                    value="{{ old('linkedin_url', $user->linkedin_url) }}"
                                    class="mt-2 w-full rounded-xl border border-[#252a4d] bg-[#0b0f25] px-4 py-2 text-sm text-white focus:border-[#7ee3ff] focus:ring-0"
                                >
                                @error('linkedin_url')
                                    <p class="mt-1 text-xs text-red-300">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid gap-4 sm:grid-cols-2">
                            <div>
                                <label class="text-xs uppercase tracking-[0.3em] text-[#8ea1ff]">New password</label>
                                <input
                                    type="password"
                                    name="password"
                                    class="mt-2 w-full rounded-xl border border-[#252a4d] bg-[#0b0f25] px-4 py-2 text-sm text-white focus:border-[#7ee3ff] focus:ring-0"
                                    placeholder="Leave blank to keep current"
                                >
                                @error('password')
                                    <p class="mt-1 text-xs text-red-300">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="text-xs uppercase tracking-[0.3em] text-[#8ea1ff]">Confirm password</label>
                                <input
                                    type="password"
                                    name="password_confirmation"
                                    class="mt-2 w-full rounded-xl border border-[#252a4d] bg-[#0b0f25] px-4 py-2 text-sm text-white focus:border-[#7ee3ff] focus:ring-0"
                                >
                            </div>
                        </div>

                        <div>
                            <label class="text-xs uppercase tracking-[0.3em] text-[#8ea1ff]">Profile image</label>
                            <input
                                type="file"
                                name="avatar"
                                accept="image/*"
                                class="mt-2 w-full text-sm text-[#cfd4ff]"
                            >
                            <p class="mt-1 text-xs text-[#7b82b7]">PNG or JPG up to 2MB.</p>
                            @error('avatar')
                                <p class="mt-1 text-xs text-red-300">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end">
                            <button
                                type="submit"
                                class="rounded-full bg-gradient-to-r from-[#675bff] to-[#ff71c5] px-6 py-2 text-sm font-semibold text-white shadow-lg shadow-[#675bff]/40 transition hover:-translate-y-0.5"
                            >
                                Save changes
                            </button>
                        </div>
                    </form>
                </section>
            </div>

            <section class="rounded-3xl border border-red-500/40 bg-gradient-to-r from-[#1a0b12] to-[#130914] p-6 shadow-[0_30px_70px_rgba(0,0,0,0.65)]">
                <header>
                    <h2 class="text-xl font-semibold text-white">Delete account</h2>
                    <p class="mt-1 text-sm text-[#f4b4c4]">
                        Permanently remove your account and employer data. This cannot be undone.
                    </p>
                </header>
                <form method="POST" action="{{ route('employer.profile.destroy') }}" class="mt-4 space-y-3">
                    @csrf
                    @method('DELETE')
                    <label class="text-xs uppercase tracking-[0.3em] text-[#ff9dbd]">Confirm password</label>
                    <input
                        type="password"
                        name="password"
                        class="w-full rounded-xl border border-red-500/30 bg-[#1f0f18] px-4 py-2 text-sm text-white focus:border-red-300 focus:ring-0"
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
