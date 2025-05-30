<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Produto extends Model
{
    use HasFactory;
    use HasUuids;
    protected $fillable = [
        'nome_produto',
        'categoria',
        'marca',
        'medida',
        'preco_custo',
        'preco_venda',
        'estoque_atual',
        'estoque_minimo',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}