<?php

namespace Bredi\BrediDashboard\Models;

use Illuminate\Database\Eloquent\Model;

class GrupoUsuario extends Model
{
    protected $fillable = ['nome'];

    public function permissaos()
    {
        return $this->belongsToMany(\Bredi\BrediDashboard\Models\Transacao::class, 'permissaos');//, 'transacao_id', 'id'
    }
}
