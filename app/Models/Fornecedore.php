<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Fornecedore extends Model
{
    use HasFactory;
    use HasUuids;
    protected $fillable = [
        'nome_fornecedor',
        'cnpj',
        'endereco',
        'telefone',
        'email',
        'contato',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
