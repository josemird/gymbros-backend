<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VerificationCode extends Model
{
    protected $fillable = ['email', 'code', 'type', 'expires_at'];

    public $timestamps = true;

    protected $casts = [
    'expires_at' => 'datetime',
    ];
}
