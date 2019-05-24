<?php

namespace Bredi\BrediDashboard\Providers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\Factory;
use Bredi\BrediDashboard\Models\Permissao;
use Bredi\BrediDashboard\Models\UserGrupoUsuario;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use Illuminate\Contracts\Auth\Guard;

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
    public function boot(Guard $auth)
    {   
        $file = __DIR__.'/../Http/Helper/Helper.php';

        if (file_exists($file)) {
            require_once($file);
        }

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
        
        Gate::before(function ($user, $ability) {

            if (in_array($user->email, config('bredidashboard.superadmin'))) {
                return true;
            }
        });

        $this->app->booted(function($auth) {
            try {
                DB::connection()->getPdo();
                if (Schema::hasTable('transacaos')) {
                    $permissaos = DB::table('permissaos')->select('transacaos.*')->join('transacaos', 'permissaos.transacao_id', '=', 'transacaos.id')->where('grupo_usuario_id', Auth::user()->grupo_usuario_id)->get();
                    // dd($permissaos);
                    if (isset($permissaos)) {
                        foreach ($permissaos as $permissao) {
                            Gate::define($permissao->permissao, function ($user) {
                                return true;
                            });
                        }
                    }
                }
            } catch (\Exception $e) {
                // dd("Não foi possível conectar ao bando de dados", $e);
            }
        });
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
        $this->publishes([
            __DIR__ . '/../Config/config.php' => config_path('bredidashboard.php'),
        ], 'bredidashboard-config');
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
