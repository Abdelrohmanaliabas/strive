@extends('layouts.public')


@section('header')
<h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
    {{ __('Profile') }}
</h2>
@endsection


@section('content')



    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6  ">
            <div class="p-4 sm:p-8 rounded-2xl border border-white/10 shadow-lg bg-white/70 dark:bg-white/5 backdrop-blur-xl  sm:rounded-lg">
                <div class="max-w-xl ">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 rounded-2xl border border-white/10 shadow-lg bg-white/70 dark:bg-white/5 backdrop-blur-xl sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 rounded-2xl border border-white/10 shadow-lg bg-white/70 dark:bg-white/5 backdrop-blur-xl sm:rounded-lg">
                <div class="max-w-xl">
                    <h3 class="text-xl font-semibold mb-4 text-gray-800 dark:text-white">My Job Applications</h3>

                    @if(auth()->user()->applications()->count())
                        <ul class="space-y-4">
                            @foreach(auth()->user()->applications()->latest()->get() as $application)
                                <li class="p-4 border border-white/10 rounded-xl bg-white/50 dark:bg-white/5 flex justify-between items-center">
                                    <div>
                                        <p class="font-semibold text-gray-800 dark:text-white"><a href="{{ route('jobs.show', $application->jobPost->id) }}" class="hover:underline">{{ $application->jobPost->title ?? 'Deleted Job' }}</a></p>
                                        <p class="text-sm text-gray-800 dark:text-gray-300">Status: {{ ucfirst($application->status) }}</p>
                                    </div>

                                    @if($application->status !== 'cancelled')
                                    <form action="{{ route('applications.cancel', $application->id) }}" method="POST">
                                        @csrf
                                        <button class="px-3 py-1 text-sm text-red-500 hover:text-red-700 font-semibold rounded-lg border border-red-500 hover:bg-red-50 transition">
                                            Cancel
                                        </button>
                                    </form>
                                    @else
                                    <span class="px-3 py-1 text-sm text-gray-400">Cancelled</span>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-gray-500">You haven’t applied to any jobs yet.</p>
                    @endif
                </div>
            </div>


            <div class="p-4 sm:p-8 rounded-2xl border border-white/10 shadow-lg bg-white/70 dark:bg-white/5 backdrop-blur-xl sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>

@endsection
