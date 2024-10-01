<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Key extends Model
{
  use HasFactory;
  protected $fillable = ["user_id", "key"];

  // Relationship with the User
  public function user()
  {
    return $this->belongsTo(User::class);
  }
}
