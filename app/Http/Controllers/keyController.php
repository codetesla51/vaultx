<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Key;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class KeyController extends Controller
{
  public function decryptForm($id)
  {
    $key = Key::find($id);
    return view("decrypt-key", compact("key"));
  }

  public function uploadKey(Request $req)
  {
    $req->validate([
      "key" => "required|string|min:8|max:255",
    ]);

    $userId = Auth::id();

    $keyCount = Key::where("user_id", $userId)->count();

    if ($keyCount >= 2) {
      return response()->json([
        "success" => false,
        "message" => "You have reached the maximum limit of 2 keys.",
      ]);
    }

    $encryptedKey = Crypt::encrypt($req->key);

    $create_key = Key::create([
      "key" => $encryptedKey,
      "user_id" => $userId,
    ]);

    if ($create_key) {
      return response()->json([
        "success" => true,
        "message" => "Key added successfully",
      ]);
    } else {
      return response()->json([
        "success" => false,
        "message" => "Key not added successfully",
      ]);
    }
  }

  public function decryptKey(Request $req)
  {
    $req->validate([
      "password" => "required|string",
    ]);

    if (!Hash::check($req->password, Auth::user()->password)) {
      return response()->json(
        [
          "status" => "error",
          "message" => "Invalid password. Please try again.",
        ],
        401
      );
    }
    $key = Key::find($req->keyId);

    if (!$key) {
      return response()->json(
        [
          "status" => "error",
          "message" => "Key not found.",
        ],
        404
      );
    }

    try {
      $decryptedKey = Crypt::decrypt($key->key);

      return response()->json([
        "status" => "success",
        "decryptedKey" => $decryptedKey,
      ]);
    } catch (\Exception $e) {
      return response()->json(
        [
          "status" => "error",
          "message" => "Decryption failed.",
        ],
        500
      );
    }
  }
  public function destroy($id)
  {
    $key = Key::find($id);

    if ($key) {
      $key->delete();
      return response()->json([
        "success" => true,
        "message" => "Key deleted successfully.",
      ]);
    }

    return response()->json(
      ["success" => false, "message" => "Key not found."],
      404
    );
  }
}
