<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use HasFactory;
    protected $fillable = [
        'quantidade',
        'nome_curso',
        'descricao',
        'data_inicio',
        'data_fim',
        'valor'
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
