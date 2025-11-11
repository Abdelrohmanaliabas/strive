@extends('layouts.admin')

@section('title', 'Edit ' . $user->name)

@section('content')
<x-admin.module-frame
    title="Edit {{ $user->name }}"
    eyebrow="Users"
    description="Update account metadata, contact information, and access levels.">
    <div class="max-w-6xl mx-auto">
        <div class="rounded-2xl shadow-lg overflow-hidden transition-all grid grid-cols-1 md:grid-cols-3 bg-white dark:bg-gray-800">
            {{-- Left: Profile Info --}}
            <div class="bg-indigo-600 dark:bg-indigo-700 text-white flex flex-col items-center justify-center p-8">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=4f46e5&color=fff&size=150"
                     alt="{{ $user->name }}"
                     class="rounded-full border-4 border-white shadow-lg mb-4 size-32 object-cover">

                <h2 class="text-2xl font-semibold">{{ $user->name }}</h2>
                <p class="text-indigo-200">{{ $user->email }}</p>
                <span class="mt-3 px-4 py-1 text-sm bg-white/20 rounded-full capitalize">
                    {{ $user->role ?? 'User' }}
                </span>
            </div>

            {{-- Middle & Right: Form --}}
            <div class="col-span-2 p-8 bg-white dark:bg-gray-900/40">
                <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-6 border-b pb-2">
                    Edit Profile
                </h3>

                <form method="POST" action="{{ route('admin.users.update', $user->id) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        {{-- Name --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Full Name</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500 p-2.5" />
                        </div>

                        {{-- Phone --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Phone</label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                                class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500 p-2.5" />
                        </div>

                        {{-- Email --}}
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500 p-2.5" />
                        </div>

                        {{-- LinkedIn --}}
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">LinkedIn URL</label>
                            <input type="url" name="linkedin_url" value="{{ old('linkedin_url', $user->linkedin_url) }}"
                                placeholder="https://linkedin.com/in/username"
                                class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500 p-2.5" />
                        </div>

                        {{-- Role --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Role</label>
                            <select name="role"
                                class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500 p-2.5">
                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="employer" {{ $user->role == 'employer' ? 'selected' : '' }}>Employer</option>
                                <option value="candidate" {{ $user->role == 'candidate' ? 'selected' : '' }}>Candidate</option>
                            </select>
                        </div>
                    </div>

                    {{-- Submit --}}
                    <div class="flex justify-end pt-4 border-t dark:border-gray-700">
                        <button type="submit"
                            class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white font-semibold rounded-lg shadow-md transition">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin.module-frame>
@endsection
