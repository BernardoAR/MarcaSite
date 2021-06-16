<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CursoMaterial extends Model
{
    use HasFactory;
    protected $table = 'curso_materiais';
    protected $fillable = [
        'cursos_id',
        'materiais_id',
    ];
}
