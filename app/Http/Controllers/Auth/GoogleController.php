<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
class GoogleController extends Controller
{
  public function redirectToGoogle()
  {
    return Socialite::driver("google")->redirect();
  }
  public function handleGoogleCallback()
  {
    try {
      $googleUser = Socialite::driver("google")->user();
      $existingUser = User::where("email", $googleUser->getEmail())->first();

      if ($existingUser) {
        Auth::login($existingUser, true);
        if ($existingUser->password_setup) {
          return redirect()->intended("/home");
        } else {
          return redirect()->route("password");
        }
      } else {
        $newUser = User::create([
          "name" => $googleUser->getName(),
          "email" => $googleUser->getEmail(),
          "google_id" => $googleUser->getId(),
          "avatar" => $googleUser->getAvatar(),
          "password_setup" => false,
        ]);
        Auth::login($newUser, true);
        return redirect()->route("password");
      }
    } catch (\Exception $e) {
      return redirect()
        ->route("login")
        ->with("error", "Something went wrong, please try again.");
    }
  }
}
