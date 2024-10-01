<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SignupController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\GitHubController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\FileEncryptionController;
use App\Http\Controllers\keyController;

// Signup routes
Route::get("/signup", [SignupController::class, "showSignup"])->name(
  "showSignup"
);
Route::post("/signup", [SignupController::class, "signup"])->name("signup");

// Email verification notice page (for unverified users)
// Route::get("auth/github", [GitHubController::class, "redirectToGitHub"]);
// Route::get("auth/github/callback", [
//   GitHubController::class,
//   "handleGitHubCallback",
// ]);

Route::get("/login", [SignupController::class, "showLogin"])->name("login");
Route::get("/password", [SignupController::class, "showPassword"])->name(
  "password"
);
Route::post("/login", [SignupController::class, "storeLogin"])->name("login");
Route::post("/logout", [SignupController::class, "logout"])->name("logout");
// Google OAuth routes
Route::get("auth/google", [GoogleController::class, "redirectToGoogle"])->name(
  "google.login"
);
Route::get("auth/google/callback", [
  GoogleController::class,
  "handleGoogleCallback",
]);

Route::middleware(["auth"])->group(function () {
  Route::get("/", [FileEncryptionController::class, "index"])->name("home");
  Route::post("/encrypt", [
    FileEncryptionController::class,
    "encryptFile",
  ])->name("encrypt");
  Route::post("/decrypt", [
    FileEncryptionController::class,
    "decryptFile",
  ])->name("file.decrypt");

  Route::get("/download/{file}", [
    FileEncryptionController::class,
    "downloadFile",
  ])->name("file.download");
  Route::get("/download/encrypted/{file}", [
    FileEncryptionController::class,
    "downloadEnc",
  ])->name("enc.download");
  Route::delete("/delete/{file}", [
    FileEncryptionController::class,
    "deleteFile",
  ])->name("enc.delete");
  Route::post("/keys/upload", [KeyController::class, "uploadKey"])->name(
    "keys.upload"
  );
  Route::post("/keys/decrypt", [KeyController::class, "decryptKey"])->name(
    "keys.decrypt"
  );
  Route::get("/decrypt-key/{id}", [KeyController::class, "decryptForm"])->name(
    "decrypt.key"
  );
  Route::post("decryptKey", [KeyController::class, "decryptKey"])->name(
    "decrypt-key"
  );
  Route::post("/update-password", [SignupController::class, "updatePassword"]);
  Route::delete('/keys/{id}', [KeyController::class, 'destroy'])->name('keys.destroy');

});
Route::get("/decrypt/{file}", [
    FileEncryptionController::class,
    "showDecryptPage",
  ])->name("file.decrypt");