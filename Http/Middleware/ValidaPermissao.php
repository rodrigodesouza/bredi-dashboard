<?php

namespace Bredi\BrediDashboard\Http\Middleware;

use Auth;
use Closure;
use Gate;
use Log;
use Route;

class ValidaPermissao
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // dd(Route::current()->action['permissao']);

        if (isset(Route::current()->action['permissao'])) {
            $this->verificaPermissao(Route::current()->action['permissao']);
        }

        return $next($request);
    }

    public function verificaPermissao($transacao)
    {
        dd(session('permissao'), $transacao);
        if (Gate::denies($transacao)) {
            $this->forbidden();
        }
    }

    public function forbidden()
    {
        // Log::alert('Usuário sem permissão para acessar URL', [Auth::user()->nome, url()->current()]);
        // abort(403);
        dd('sem permissao');
    }
}
