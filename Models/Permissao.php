<?php

namespace Bredi\BrediDashboard\Models;

use Illuminate\Database\Eloquent\Model;

class Permissao extends Model
{
    protected $fillable = ['categoria_transacao_id', 'permissao', 'descricao'];
}
