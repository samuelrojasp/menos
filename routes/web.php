<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


    Route::get('/', function () {
        return redirect('shop');
    });

    Auth::routes();



Route::get('/verify', function () {
    return view('auth.verify');
})->name('verify');

Route::post('/verify', 'Auth\RegisterController@verify')->name('verify');

Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');


Route::get('mi_cuenta', 'BilleteraController@dashboard');
//Route::get('cambiar_datos', 'Datos Controller')

Route::get('admin2/depositar', 'BilleteraController@depositar');

Route::post('admin2/depositar', 'TransaccionController@depositar');

Route::get('admin2/transferir', 'BilleteraController@transferir');

Route::post('admin2/transferir', 'TransaccionController@transferir');

Route::get('admin2/retirar', 'BilleteraController@retirar');

Route::post('admin2/retirar', 'TransaccionController@retirar');

Route::resource('admin2/tipos_cuenta', 'TipoCuentaController');

Route::resource('admin2/tipos_transaccion', 'TipoTransaccionController');