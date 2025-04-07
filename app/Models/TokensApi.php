<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class TokensApi extends Model
{
    use HasFactory;
    protected $fillable = [
        'token',
        'id_user'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'token',
        'id_user',
    ];

}
