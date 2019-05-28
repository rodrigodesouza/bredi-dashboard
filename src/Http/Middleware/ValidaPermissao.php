<?php

namespace Bredi\BrediDashboard\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Gate;
use Route;
use Bredi\BrediDashboard\Models\Permissao;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;

class ValidaPermissao
{
    public function __construct()
    {
        $this->vendor = config('bredidashboard.templates')[config('bredidashboard.default')];
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (isset(Route::current()->action['permissao'])) {
            $this->verificaPermissao(Route::current()->action['permissao']);
        }

        return $next($request);
    }

    public function verificaPermissao($transacao)
    {
        if (Schema::hasTable('transacaos')) {
            $permissaos = Permissao::select('transacaos.*', 'permissaos.grupo_usuario_id')
                            ->join('transacaos', 'permissaos.transacao_id', '=', 'transacaos.id')
                            ->where('permissaos.grupo_usuario_id', Auth::user()->grupo_usuario_id)
                            ->get();

            foreach($permissaos as $permissao) {
                Gate::define($permissao->permissao, function ($user) use ($transacao) {
                    return true;
                });
            }

            if (Gate::denies($transacao)) {
                abort(403);
            }
        }
    }
}
