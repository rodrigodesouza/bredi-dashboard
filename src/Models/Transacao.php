<?php

namespace Bredi\BrediDashboard\Models;

use Illuminate\Database\Eloquent\Model;

class Transacao extends Model
{
    protected $fillable = ['categoria_transacao_id', 'permissao', 'descricao'];
}
