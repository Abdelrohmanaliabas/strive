<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialLiteController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('linkedin-openid')->redirect();
    }

    public function callback()
    {
        $linkedinUser = Socialite::driver('linkedin-openid')->stateless()->user();

        $user = User::firstOrCreate(
            ['email' => $linkedinUser->getEmail()],
            [
                'name' => $linkedinUser->getName(),
                'password' => bcrypt(str()->random(16)),
            ]
        );

        Auth::login($user);
        return redirect()->intended(route('jobs.index', absolute: false));
    }
}
