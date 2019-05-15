<?php

namespace Bredi\BrediDashboard\Models;

use Illuminate\Database\Eloquent\Model;
use App\User as Usuario;

class User extends Usuario
{
    protected $fillable = [
        'grupo_usuario_id',
        'name',
        'email',
        'password',
        'imagem'
    ];

    
    public function grupoUsuario()
    {
        return $this->belongsTo(\Bredi\BrediDashboard\Models\GrupoUsuario::class);
    }
    
}
