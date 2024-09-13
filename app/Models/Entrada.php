<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Entrada extends Model
{
    use HasFactory;
    use HasUuids;
    protected $fillable = [
        'fk_id_produto',
        'quantidade',
        'fk_id_fornecedor',
    ];
    
}
