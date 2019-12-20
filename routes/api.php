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
Route::prefix('v1')->group(function(){
    Route::post('login', 'Api\AuthController@login');
    Route::post('register', 'Api\AuthController@register');
    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('user', 'Api\AuthController@user');
        Route::get('logout', 'Api\AuthController@logout');
        Route::resource('users.empresas','EmpresaUserController',[ 'except'=>['show','edit','create']]);
        Route::resource('empresa','EmpresaController',[ 'only'=>['index','show'] ]);
        // Ruta para las categorias de cada empresa
        Route::resource('empresa.categoria','EmpresaCategoriaController',[ 'except'=>['show','edit','create']]);
        Route::resource('categoria.subcategoria','CategoriaSubcategoriaController',[ 'except'=>['show','edit','create','index']]);
        Route::resource('empresa.subcategoria.ingreso','EmpresaIngresoController',[ 'except'=>['show','edit','create','index']]);
        Route::resource('empresa.subcategoria.egreso','EmpresaEgresoController',[ 'except'=>['show','edit','create','index']]);
    });
});
