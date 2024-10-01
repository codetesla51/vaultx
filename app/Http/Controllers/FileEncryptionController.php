<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\EncryptedFile;
use App\Models\Key;

class FileEncryptionController extends Controller
{
  public function index()
  {
    $files = EncryptedFile::where("user_id", Auth::id())->get();
    $keys = Key::where("user_id", Auth::id())->get();
    return view("home", compact("files", "keys"));
  }

  public function encryptFile(Request $request)
  {
    $validated = $request->validate([
      "file" => "required|file",
      "key" => "required|string|min:8",
    ]);

    $file = $request->file("file");
    $key = $validated["key"];

    $filePath = $file->getRealPath();
    $originalName = $file->getClientOriginalName();
    $encryptedName = $originalName . ".enc";
    $encryptedFilePath = storage_path("app/encrypted/" . $encryptedName);
    $inputFile = fopen($filePath, "rb");
    $outputFile = fopen($encryptedFilePath, "wb");
    $iv = random_bytes(openssl_cipher_iv_length("aes-256-cbc"));
    fwrite($outputFile, $iv);

    while (!feof($inputFile)) {
      $chunk = fread($inputFile, 8192);
      $encryptedChunk = openssl_encrypt(
        $chunk,
        "aes-256-cbc",
        $key,
        OPENSSL_RAW_DATA,
        $iv
      );
      fwrite($outputFile, $encryptedChunk);
    }

    fclose($inputFile);
    fclose($outputFile);

    EncryptedFile::create([
      "user_id" => Auth::id(),
      "original_name" => $originalName,
      "encrypted_name" => $encryptedName,
      "key_hash" => hash("sha256", $key),
    ]);

    return response()->json(
      ["message" => "File encrypted and saved successfully."],
      200
    );
  }

  public function decryptFile(Request $request)
  {
    $request->validate([
      "file" => "required|string",
      "key" => "required|string|min:8",
    ]);

    $encryptedFileName = $request->input("file");
    $key = $request->input("key");
    $filePath = storage_path("app/encrypted/" . $encryptedFileName);
    $outputPath = storage_path(
      "app/decrypted/" . pathinfo($encryptedFileName, PATHINFO_FILENAME)
    );

    if (!file_exists($filePath)) {
      return response()->json(
        ["error" => "The selected file does not exist."],
        404
      );
    }

    $inputFile = fopen($filePath, "rb");
    $outputFile = fopen($outputPath, "wb");

    $ivLength = openssl_cipher_iv_length("aes-256-cbc");
    $iv = fread($inputFile, $ivLength);

    $decryptionSuccessful = true;

    while (!feof($inputFile)) {
      $chunk = fread($inputFile, 8192);

      if ($chunk === false) {
        fclose($inputFile);
        fclose($outputFile);
        return response()->json(
          ["error" => "Failed to read the input file."],
          500
        );
      }

      $decryptedChunk = openssl_decrypt(
        $chunk,
        "aes-256-cbc",
        $key,
        OPENSSL_RAW_DATA,
        $iv
      );

      if ($decryptedChunk === false) {
        $decryptionSuccessful = false;
        break;
      }

      fwrite($outputFile, $decryptedChunk);
    }

    fclose($inputFile);
    fclose($outputFile);

    if (!$decryptionSuccessful) {
      unlink($outputPath);

      return response()->json(
        [
          "error" => "Decryption failed. The key may be incorrect.",
        ],
        422
      );
    }

    return response()->json([
      "success" => "File decrypted successfully.",
      "download_url" => route("file.download", [
        "file" => basename($outputPath),
      ]),
    ]);
  }

  public function downloadFile($file)
  {
    $outputPath = storage_path("app/decrypted/" . $file);

    if (file_exists($outputPath)) {
      return response()
        ->download($outputPath)
        ->deleteFileAfterSend();
    }

    return redirect()
      ->back()
      ->withErrors(["error" => "File not found."]);
  }

  public function downloadEnc($file)
  {
    $encryptedFileDir = storage_path("app/encrypted/" . $file);

    if (file_exists($encryptedFileDir)) {
      return response()->download($encryptedFileDir);
    }

    return redirect()
      ->back()
      ->withErrors(["error" => "File not found."]);
  }
  public function deleteFile($file)
  {
    $encryptedFile = EncryptedFile::where("encrypted_name", $file)
      ->where("user_id", Auth::id())
      ->first();

    if (!$encryptedFile) {
      return response()->json(
        ["error" => "File not found in the database."],
        404
      );
    }
    $encryptedFilePath = storage_path("app/encrypted/" . $file);
    $decryptedFilePath = storage_path(
      "app/decrypted/" . pathinfo($file, PATHINFO_FILENAME)
    );

    if (file_exists($encryptedFilePath)) {
      unlink($encryptedFilePath);
    }

    if (file_exists($decryptedFilePath)) {
      unlink($decryptedFilePath);
    }

    $encryptedFile->delete();

    return response()->json(
      ["message" => "File and database record deleted successfully."],
      200
    );
  }
  public function showDecryptPage($file)
  {
    $encryptedFile = EncryptedFile::where("encrypted_name", $file)->first();

    if (!$encryptedFile) {
      return abort(404, "File not found.");
    }

    return view("decrypt", ["file" => $encryptedFile]);
  }
}
