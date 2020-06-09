<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Notificacion;

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
        view()->composer('*', function ($view) {
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
