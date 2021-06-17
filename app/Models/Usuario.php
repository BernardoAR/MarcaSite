<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $table = 'usuarios';
    /**
     * Atributos em massa
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'senha',
    ];

    /**
     * Atributos para serem escondidos
     *
     * @var array
     */
    protected $hidden = [
        'senha',
        'remember_token',
        'created_at',
        'updated_at',
        'email_verificado'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verificado' => 'datetime',
    ];
    public function getAuthPassword()
    {
        return $this->senha;
    }
}
