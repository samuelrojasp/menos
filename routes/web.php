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

    Auth::routes(['verify' => true]);



Route::get('/verify', 'Auth\RegisterController@register');

Route::post('/verify', 'Auth\RegisterController@verify')->name('verify');

Route::get('/registrar_datos', 'Auth\RegisterController@mostrarFormularioRegistro');
Route::post('/registrar_datos', 'Auth\RegisterController@registrar');

Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

Route::prefix('mi_cuenta')->middleware('auth')->group(function (){
    Route::get('resumen', 'DatosUsuarioController@index');
    Route::get('cambiar_datos', 'DatosUsuarioController@edit');
    Route::put('cambiar_datos', 'DatosUsuarioController@update');
    Route::get('direcciones', 'DatosUsuarioController@addressIndex');
    Route::get('direcciones/nueva', 'DatosUsuarioController@addressCreate');
    Route::post('direcciones/nueva', 'DatosUsuarioController@addressStore');
    Route::get('seguridad', 'DatosUsuarioController@seguridad');
    Route::match(['get', 'post'], 'seguridad/cambiar_telefono', 'DatosUsuarioController@updateTelephone');
    Route::post('seguridad/verificar_telefono', 'DatosUsuarioController@verifyPhone');
    Route::post('seguridad/cambiar_contrasena', 'DatosUsuarioController@updatePassword');
    Route::post('seguridad/cambiar_email', 'DatosUsuarioController@updateEmail');
});

Route::prefix('billetera')->middleware('auth')->group(function (){
    Route::get('resumen', 'BilleteraController@resumen');
    Route::get('historial', 'BilleteraController@historial');
    Route::get('transferir', 'BilleteraController@transferir');
    Route::post('confirmar_transferencia', 'BilleteraController@confirmarTransferencia');
    Route::get('depositar', 'BilleteraController@depositar');
    Route::get('retirar', 'BilleteraController@retirar');
    //Route::post('verificar', 'BilleteraController@verificar');
    
    Route::get('pagoQR', 'QRCodeController@pagoQR');
    Route::post('generarQR', 'QRCodeController@generarQR');
    Route::get('leerQR/{message}', 'QRCodeController@readQR')->name('leerQR');

    Route::post('depositar', 'TransaccionController@depositar');
    Route::post('transferir', 'TransaccionController@transferir');
    Route::post('retirar', 'TransaccionController@retirar');
    //Route::post('verificar', 'TransaccionController@verificar');

    Route::get('transaccion/{id}', 'TransaccionController@show');


    Route::view('servicios', 'menos.proximamente');
    
    Route::view('inversion', 'menos.proximamente');
    Route::view('credito', 'menos.proximamente');
    Route::view('delivery', 'menos.proximamente');

});

Route::resource('admin2/tipos_cuenta', 'TipoCuentaController');
Route::resource('admin2/tipos_transaccion', 'TipoTransaccionController');