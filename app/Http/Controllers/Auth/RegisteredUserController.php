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
        // Validate
        $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'email'         => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'phone'         => ['nullable', 'string', 'max:30'],
            'linkedin_url'  => ['nullable', 'url', 'max:255'],
            'role'          => ['required', 'string', 'in:candidate,employer'],
            'password'      => ['required', 'confirmed', Rules\Password::defaults()],
            'avatar_path'   => ['nullable', 'image', 'max:2048'], // هنا فقط
        ]);

        // Handle image upload
        $avatarPath = null;

        if ($request->hasFile('avatar_path')) {
            $avatarPath = $request->file('avatar_path')->store('avatars', 'public');
        }

        // Create user
        $user = User::create([
            'name'          => $request->name,
            'email'         => $request->email,
            'password'      => Hash::make($request->password),
            'phone'         => $request->phone,
            'linkedin_url'  => $request->linkedin_url,
            'role'          => $request->role,
            'avatar_path'   => $avatarPath, // ← هنا بيتخزن المسار
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('jobs.index');
    }
}