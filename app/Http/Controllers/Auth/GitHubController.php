<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;

class GitHubController extends Controller
{
    // Redirect to GitHub for authentication
    public function redirectToGitHub()
    {
        return Socialite::driver('github')->redirect();
    }

    // Handle GitHub callback and dump user data
    public function handleGitHubCallback()
    {
        // Retrieve user information from GitHub
        $githubUser = Socialite::driver('github')->user();

        // Use dd() to dump the GitHub user details for testing
        dd($githubUser);
    }
}