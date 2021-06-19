<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscricao extends Model
{
    use HasFactory;
    protected $table = 'inscricoes';
    protected $fillable = [
        'usuarios_id',
        'cursos_id',
        'status_id'
    ];
    protected $casts = [
        'data_inscricao' => 'datetime:Y-m-d'
    ];
}
