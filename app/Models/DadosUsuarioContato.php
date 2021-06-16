<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DadosUsuarioContato extends Model
{
    use HasFactory;
    protected $fillable = [
        'dados_usuarios_id',
        'contatos_id'
    ];
}
