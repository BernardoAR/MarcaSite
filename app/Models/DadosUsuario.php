<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DadosUsuario extends Model
{
    use HasFactory;
    protected $fillable = [
        'CPF',
        'empresa',
        'enderecos_id',
        'tipo_usuarios_id',
        'usuarios_id'
    ];
}
