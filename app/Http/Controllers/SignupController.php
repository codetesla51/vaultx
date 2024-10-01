<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Import the User model
use Illuminate\Support\Facades\Hash; // For hashing passwords

class SignupController extends Controller
{
  public function showSignup()
  {
    return view("signup");
  }

  public function showLogin()
  {
    return view("login");
  }
  public function showPassword()
  {
    return view("password");
  }

  // Handle signup logic
  public function signup(Request $req)
  {
    // Validate request data
    $req->validate([
      "name" => "max:255|required|min:4",
      "email" => "email|required|unique:users|max:255",
      "password" => "min:8|required",
    ]);

    // Create the user and hash the password
    $create_user = User::create([
      "name" => $req->name,
      "email" => $req->email,
      "password" => Hash::make($req->password), // Hash the password
    ]);

    // Check if the user was created
    if ($create_user) {
      Auth::login($create_user, true);
      $req->session()->regenerate();
      $user->password_setup = true;
      return response()->json(
        ["message" => "User registered successfully"],
        200
      );
    } else {
      return response()->json(["errors" => "User creation failed."], 422);
    }
  }

  public function storeLogin(Request $request)
  {
    $request->validate([
      "email" => "required|email",
      "password" => "required",
    ]);

    $login_credentials = $request->only("email", "password");

    if (Auth::attempt($login_credentials, true)) {
      $request->session()->regenerate();

      // Return a success response or redirect
      return response()->json(
        [
          "message" => "Login successful.",
        ],
        200
      );
    } else {
      return response()->json(
        [
          "errors" => ["Invalid credentials."],
        ],
        422
      );
    }
  }
  public function updatePassword(Request $req)
  {
    $req->validate([
      "password" => "required|min:8|confirmed", // Confirmed means we expect a password_confirmation field in the request
    ]);

    $user = Auth::user();

    if ($user) {
      $user->password = Hash::make($req->password);
      $user->save();
      $user->password_setup = true;

      return response()->json(
        ["message" => "Password updated successfully"],
        200
      );
    } else {
      return response()->json(
        ["error" => "User not found or not authenticated"],
        422
      );
    }
  }

  public function logout()
  {
    Auth::logout();
    return redirect("/login")->with("message", "You have been logged out.");
  }
}
