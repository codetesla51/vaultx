<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEncryptedFilesTable extends Migration
{
  public function up()
  {
    Schema::create("encrypted_files", function (Blueprint $table) {
      $table->id();
      $table
        ->foreignId("user_id")
        ->constrained()
        ->onDelete("cascade"); 
      $table->string("original_name");
      $table->string("encrypted_name"); 
      $table->string("key_hash");
      $table->string("algorithm")->default("aes-256-cbc");
      $table->timestamps();
    });
  }

  public function down()
  {
    Schema::dropIfExists("encrypted_files");
  }
}
