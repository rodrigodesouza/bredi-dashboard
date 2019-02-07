<?php

namespace Bredi\BrediDashboard\Providers;

use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\Factory;
// use Illuminate\Support\ServiceProvider;
use Bredi\BrediDashboard\Models\Permissao;
use Bredi\BrediDashboard\Models\UserGrupoUsuario;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class BrediDashboardServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        
        // dd('aqsdfsfsdui');
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->registerFactories();
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        $this->registraPermissoes();
  
    }
    public function registraPermissoes()
    {
        $this->registerPolicies();
        
        dd('aqwio', Auth::user(), session());
        if (session()->has('permissao') and session('permissao')) {
            foreach (session('permissao') as $permissao) {
                dd($permissao);
            }
        }
        // if (Schema::hasTable('transacaos')) {
        //     $transacaos = Transacao::get();

        //     if (isset($transacaos)) {
        //         foreach ($transacaos as $transacao) {
        //             Gate::define($transacao->nome, function ($user) use ($transacao) {
        //                 return array_key_exists($transacao->id, session('permissao'));
        //             });
        //         }
        //     }
        // }
            
        if(\Schema::hasTable('transacaos')) {
            $transacaos = DB::table('transacaos')->get();
            $permissaos = DB::table('permissaos')->get()->KeyBy('transacao_id')->toArray();

            if (isset($transacaos)) {
                foreach ($transacaos as $transacao) {
                    // dd($transacao, $permissaos);
                    // Gate::define($transacao->permissao, function () use ($transacao) {
                    //     dd($transacao);
                    //     // in_array($permissaos)
                    //     return true; //array_key_exists($transacao->id, $permissaos);
                    // });
                }
            }
        }
    }
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__ . '/../Config/config.php' => config_path('bredidashboard.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__ . '/../Config/config.php', 'bredidashboard'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/bredidashboard');

        $sourcePath = __DIR__ . '/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath,
        ], 'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/bredidashboard';
        }, \Config::get('view.paths')), [$sourcePath]), 'bredidashboard');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/bredidashboard');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'bredidashboard');
        } else {
            $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'bredidashboard');
        }
    }

    /**
     * Register an additional directory of factories.
     *
     * @return void
     */
    public function registerFactories()
    {
        if (!app()->environment('production')) {
            app(Factory::class)->load(__DIR__ . '/../Database/factories');
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
