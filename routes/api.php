<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('byPhone/{phone}', 'CheckoutController@apiGetByPhone');

Route::get('afiliates_binary_tree/{id}', 'BusinessController@apiGetBinaryTreeAfiliates');
Route::get('afiliates_sponsor_tree/{id}', 'BusinessController@apiGetSponsorTreeAfiliates');


Route::get('binary_child_available_side/{id}', 'BusinessController@apiGetAvailableSides');