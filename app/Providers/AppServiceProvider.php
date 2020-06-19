<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Notificacion;
use Konekt\Menu\Facades\Menu;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        $menu = \Menu::get('appshell');
        $menu->getItem('settings_group')->addSubItem('verifica_identidad', 'Verifica Identidad', '/administracion/verifica_identidad')->data('icon', 'account-box-phone');
        
        view()->composer('*', function ($view) {
            $this->app->concord->registerModel(\Konekt\User\Contracts\User::class, \App\User::class);
            
            $user = auth()->user();
            
            if($user!=null){
                $notificaciones = Notificacion::where('user_id', $user->id)
                                                ->where('leido', 0);

                $notificacion_count = $notificaciones->count();
            }else{
                $notificacion_count = 0;
            }
                $view->with('notificaciones_no_leidas', $notificacion_count );
            
        });  
    }
}
