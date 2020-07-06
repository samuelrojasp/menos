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
    return redirect('/shop/index');
});

/**
 * These are the routes for the e-commerce Module
 */

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'shop', 'as' => 'product.'], function() {
    Route::get('index', 'ProductController@index')->name('index');
    Route::get('c/{taxonomyName}/{taxon}', 'ProductController@index')->name('category');
    Route::get('p/{product}', 'ProductController@show')->name('show');
});

Route::group(['prefix' => 'cart', 'as' => 'cart.', 'middleware' => 'auth'], function() {
    Route::get('show', 'CartController@show')->name('show');
    Route::post('add/{product}', 'CartController@add')->name('add');
    Route::post('update/{cart_item}', 'CartController@update')->name('update');
    Route::post('remove/{cart_item}', 'CartController@remove')->name('remove');
});

Route::group(['prefix' => 'checkout', 'as' => 'checkout.', 'middleware' => 'auth'], function() {
    Route::get('show', 'CheckoutController@show')->name('show');
    Route::post('submit', 'CheckoutController@submit')->name('submit');
});

/**
 * These are the routes for the authentication / registration
 */

Auth::routes(['verify' => true]);
        
Route::get('/verify', 'Auth\RegisterController@register');

Route::post('/verify', 'Auth\RegisterController@verify')->name('verify');

Route::get('/registrar_datos', 'Auth\RegisterController@mostrarFormularioRegistro');
Route::post('/registrar_datos', 'Auth\RegisterController@registrar');

Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

Route::prefix('administracion')->middleware('auth')->group(function (){
    Route::resource('verifica_identidad', 'IdentificacionController');
    Route::get('verifica_transacciones', 'TransaccionController@verificarTransaccionIndex');
    Route::put('verifica_transaccion/{id}', 'TransaccionController@verificarTransaccionUpdate');
});

/** 
 * These are the routes for the user account management module
 */

Route::prefix('mi_cuenta')->middleware('auth')->group(function (){
    Route::get('resumen', 'DatosUsuarioController@index');
    Route::get('cambiar_datos', 'DatosUsuarioController@edit');
    Route::put('cambiar_datos', 'DatosUsuarioController@update');
    Route::get('direcciones', 'DatosUsuarioController@addressIndex');
    Route::get('direcciones/nueva', 'DatosUsuarioController@addressCreate');
    Route::post('direcciones/nueva', 'DatosUsuarioController@addressStore');
    Route::delete('direcciones/{id}', 'DatosUsuarioController@addressDelete');
    Route::get('seguridad', 'DatosUsuarioController@seguridad');
    Route::match(['get', 'post'], 'seguridad/cambiar_telefono', 'DatosUsuarioController@updateTelephone');
    Route::post('seguridad/verificar_telefono', 'DatosUsuarioController@verifyPhone');
    Route::post('seguridad/cambiar_contrasena', 'DatosUsuarioController@updatePassword');
    Route::post('seguridad/cambiar_email', 'DatosUsuarioController@updateEmail');
    Route::post('mail_confirmacion', 'DatosUsuarioController@verificacionEmail');
    Route::get('notificaciones', 'NotificacionController@index');

    Route::get('verifica_identidad', 'VerificaIdentidadController@showIdentificationVerificationForm');
    Route::post('verifica_identidad', 'VerificaIdentidadController@uploadsFiles');

    Route::resource('cuenta_bancaria', 'CuentaBancariaController');

});

/**
 *  These are the routes for the user's wallet management module
 */

Route::prefix('billetera')->middleware('auth')->group(function (){
    Route::get('resumen', 'BilleteraController@resumen');
    Route::get('historial', 'BilleteraController@historial');
    Route::get('transferir', 'BilleteraController@transferir');
    Route::post('confirmar_transferencia', 'BilleteraController@confirmarTransferencia');
    Route::get('depositar', 'BilleteraController@depositar');
    Route::get('retirar', 'BilleteraController@retirar');
    Route::post('confirmar_retiro', 'BilleteraController@confirmarRetiro');
    Route::post('confirmar_carga', 'BilleteraController@confirmarCarga');
    
    Route::get('pagoQR', 'QRCodeController@pagoQR');
    Route::post('generarQR', 'QRCodeController@generarQR');
    Route::get('leerQR/{message}', 'QRCodeController@readQR')->name('leerQR');

    Route::post('depositar', 'TransaccionController@depositar');
    Route::post('transferir', 'TransaccionController@transferir');
    Route::post('retirar', 'TransaccionController@retirar');

    Route::get('transaccion/{id}', 'TransaccionController@show');


    Route::view('servicios', 'menos.proximamente');
    
    Route::view('inversion', 'menos.proximamente');
    Route::view('credito', 'menos.proximamente');
    Route::view('delivery', 'menos.proximamente');

});

Route::prefix('business')->middleware('auth')->group(function (){
    Route::view('unete', 'menos.unete.pricing');
    Route::get('plan-checkout', 'BusinessController@checkout');
    Route::post('plan-checkout', 'BusinessController@userMlmAfiliation');
    Route::get('office', 'BusinessController@office');
    Route::get('binaria', 'BusinessController@binary');
    Route::get('generacional', 'BusinessController@sponsors');
    Route::get('prospectos', 'BusinessController@prospects');
});