<?php

namespace App\Http\Controllers\Auth;

use Socialite;
use App\User;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    /**
     * Redirect the user to GitHub.
     */
    public function redirectToProvider()
    {
        return Socialite::driver('github')->redirect();
    }

    /**
     * Handle GitHub's callback.
     */
    public function handleProviderCallback()
    {
        $user = $this->findOrCreateGitHubUser(
            Socialite::driver('github')->user()
        );

        auth()->login($user);

        return redirect('/');
    }

    /**
     * Fetch the GitHub user.
     *
     * @param  object $githubUser
     * @return \App\User
     */
    protected function findOrCreateGitHubUser($githubUser)
    {
        $user = User::firstOrNew(['github_id' => $githubUser->id]);

        if ($user->exists) return $user;

        $user->fill([
            'username'  => $githubUser->nickname,
            'email'     => $githubUser->email,
            'avatar'    => $githubUser->avatar
        ])->save();

        return $user;
    }
}
