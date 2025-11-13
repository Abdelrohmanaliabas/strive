<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate image first
        if ($request->hasFile('avatar_path')) {
            $request->validate([
                'avatar_path' => ['image', 'max:2048'],
            ]);

            // upload image
            $avatarPath = $request->file('avatar_path')->store('avatars', 'public');
            $request->merge(['avatar_path' => $avatarPath]);
        }

        // Validate all fields
        $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'email'         => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'phone'         => ['nullable', 'string', 'max:30'],
            'linkedin_url'  => ['nullable', 'url', 'max:255'],
            'role'          => ['required', 'string', 'in:candidate,employer'],
            'password'      => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // dd($request->all());
        // store in DB
        $user = User::create([
            'name'          => $request->name,
            'email'         => $request->email,
            'password'      => Hash::make($request->password),
            'phone'         => $request->phone,
            'linkedin_url'  => $request->linkedin_url,
            'avatar_path'   => $request->avatar_path,
            'role'          => $request->role,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('jobs.index');
    }
}