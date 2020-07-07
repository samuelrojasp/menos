<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Notificacion;
use Konekt\Menu\Facades\Menu;
use App\Cuenta;

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
        $menu->getItem('settings_group')->addSubItem('verifica_transacciones', 'Verifica Transacciones', '/administracion/verifica_transacciones')->data('icon', 'money-box');
        
        $business_menu = \Menu::create('business_menu', ['share' => true]);
        $business_menu->addItem('office', 'Dashboard', 'business/office');
        $business_menu->addItem('binaria','Arbol Red Binaria', 'business/binaria');
        $business_menu->addItem('binaria_ubicar', 'Ubicar Nuevo Afiliado', 'business/binaria/ubicar-afiliado');
        $business_menu->addItem('generacional','Arbol de Patrocinadores', 'business/generacional');
        $business_menu->addItem('prospectos','Mis Prospectos', 'business/prospectos');

        //dd($business_menu);
        
        view()->composer('*', function ($view) {
            $this->app->concord->registerModel(\Konekt\User\Contracts\User::class, \App\User::class);
            
            $user = auth()->user();

            if($user!=null){
                $cuenta_usuario_autenticado = Cuenta::where('user_id', $user->id)->first();

                $notificaciones = Notificacion::where('user_id', $user->id)
                                                ->where('leido', 0);

                $notificacion_count = $notificaciones->count();
            }else{
                $notificacion_count = 0;
            }
                $view->with([
                    'notificaciones_no_leidas' => $notificacion_count,
                    'saldo_cuenta' => $cuenta_usuario_autenticado->saldo ?? null,
                    'user' => $user ?? null
                ]);
            
        });  
    }
}
