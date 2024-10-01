<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EncryptedFile extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'original_name', 'encrypted_name', 'key_hash'];

    // Relationship with the User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
