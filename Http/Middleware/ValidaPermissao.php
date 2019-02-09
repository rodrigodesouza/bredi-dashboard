<?php

namespace Bredi\BrediDashboard\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Gate;
use Route;

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
        if (Gate::denies($transacao)) {
            abort(403);
        }
    }
}
