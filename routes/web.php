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

Route::resource('admin2/tipos_cuenta', 'TipoCuentaController');

Route::resource('admin2/tipos_transaccion', 'TipoTransaccionController');

Route::get('admin2/dashboard', 'BilleteraController@dashboard');

Route::get('admin2/depositar', 'BilleteraController@depositar');