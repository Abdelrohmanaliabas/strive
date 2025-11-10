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
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>

@endsection