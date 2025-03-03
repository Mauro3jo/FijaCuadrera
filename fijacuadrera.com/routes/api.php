<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\HipicoController;
use App\Http\Controllers\Api\CaballoController;
use App\Http\Controllers\Api\CarreraController;
use App\Http\Controllers\Api\ContactoController;
use App\Http\Controllers\Api\FormapagoController;
use App\Http\Controllers\Api\ApuestaPollaController;
use App\Http\Controllers\Api\HipicoCarrerasController;
use App\Http\Controllers\Api\CaballoCarrerasController;
use App\Http\Controllers\Api\CarreraCaballosController;
use App\Http\Controllers\Api\ApuestamanomanoController;
use App\Http\Controllers\Api\ApuestaPollaUserController;
use App\Http\Controllers\Api\ApuestamanomanoUserController;
use App\Http\Controllers\Api\CarreraApuestaPollasController;
use App\Http\Controllers\Api\UserApuestaPollaUsersController;
use App\Http\Controllers\Api\CarreraApuestamanomanosController;
use App\Http\Controllers\Api\CaballoApuestaPollaUsersController;
use App\Http\Controllers\Api\UserApuestamanomanoUsersController;
use App\Http\Controllers\Api\CaballoApuestamanomanoUsersController;
use App\Http\Controllers\Api\ApuestaPollaApuestaPollaUsersController;
use App\Http\Controllers\Api\ApuestamanomanoApuestamanomanoUsersController;

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

Route::post('/login', [AuthController::class, 'login'])->name('api.login');

Route::middleware('auth:sanctum')
    ->get('/user', function (Request $request) {
        return $request->user();
    })
    ->name('api.user');

Route::name('api.')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::apiResource('caballos', CaballoController::class);

        // Caballo Apuestamanomano Users
        Route::get('/caballos/{caballo}/apuestamanomano-users', [
            CaballoApuestamanomanoUsersController::class,
            'index',
        ])->name('caballos.apuestamanomano-users.index');
        Route::post('/caballos/{caballo}/apuestamanomano-users', [
            CaballoApuestamanomanoUsersController::class,
            'store',
        ])->name('caballos.apuestamanomano-users.store');

        // Caballo Apuesta Polla Users
        Route::get('/caballos/{caballo}/apuesta-polla-users', [
            CaballoApuestaPollaUsersController::class,
            'index',
        ])->name('caballos.apuesta-polla-users.index');
        Route::post('/caballos/{caballo}/apuesta-polla-users', [
            CaballoApuestaPollaUsersController::class,
            'store',
        ])->name('caballos.apuesta-polla-users.store');

        // Caballo Carreras
        Route::get('/caballos/{caballo}/carreras', [
            CaballoCarrerasController::class,
            'index',
        ])->name('caballos.carreras.index');
        Route::post('/caballos/{caballo}/carreras/{carrera}', [
            CaballoCarrerasController::class,
            'store',
        ])->name('caballos.carreras.store');
        Route::delete('/caballos/{caballo}/carreras/{carrera}', [
            CaballoCarrerasController::class,
            'destroy',
        ])->name('caballos.carreras.destroy');

        Route::apiResource('carreras', CarreraController::class);

        // Carrera Apuestamanomanos
        Route::get('/carreras/{carrera}/apuestamanomanos', [
            CarreraApuestamanomanosController::class,
            'index',
        ])->name('carreras.apuestamanomanos.index');
        Route::post('/carreras/{carrera}/apuestamanomanos', [
            CarreraApuestamanomanosController::class,
            'store',
        ])->name('carreras.apuestamanomanos.store');

        // Carrera Apuesta Pollas
        Route::get('/carreras/{carrera}/apuesta-pollas', [
            CarreraApuestaPollasController::class,
            'index',
        ])->name('carreras.apuesta-pollas.index');
        Route::post('/carreras/{carrera}/apuesta-pollas', [
            CarreraApuestaPollasController::class,
            'store',
        ])->name('carreras.apuesta-pollas.store');

        // Carrera Caballos
        Route::get('/carreras/{carrera}/caballos', [
            CarreraCaballosController::class,
            'index',
        ])->name('carreras.caballos.index');
        Route::post('/carreras/{carrera}/caballos/{caballo}', [
            CarreraCaballosController::class,
            'store',
        ])->name('carreras.caballos.store');
        Route::delete('/carreras/{carrera}/caballos/{caballo}', [
            CarreraCaballosController::class,
            'destroy',
        ])->name('carreras.caballos.destroy');

        Route::apiResource('contactos', ContactoController::class);

        Route::apiResource('formapagos', FormapagoController::class);

        Route::apiResource('hipicos', HipicoController::class);

        // Hipico Carreras
        Route::get('/hipicos/{hipico}/carreras', [
            HipicoCarrerasController::class,
            'index',
        ])->name('hipicos.carreras.index');
        Route::post('/hipicos/{hipico}/carreras', [
            HipicoCarrerasController::class,
            'store',
        ])->name('hipicos.carreras.store');

        Route::apiResource('users', UserController::class);

        // User Apuestamanomano Users
        Route::get('/users/{user}/apuestamanomano-users', [
            UserApuestamanomanoUsersController::class,
            'index',
        ])->name('users.apuestamanomano-users.index');
        Route::post('/users/{user}/apuestamanomano-users', [
            UserApuestamanomanoUsersController::class,
            'store',
        ])->name('users.apuestamanomano-users.store');

        // User Apuesta Polla Users
        Route::get('/users/{user}/apuesta-polla-users', [
            UserApuestaPollaUsersController::class,
            'index',
        ])->name('users.apuesta-polla-users.index');
        Route::post('/users/{user}/apuesta-polla-users', [
            UserApuestaPollaUsersController::class,
            'store',
        ])->name('users.apuesta-polla-users.store');

        Route::apiResource(
            'apuestamanomanos',
            ApuestamanomanoController::class
        );

        // Apuestamanomano Apuestamanomano Users
        Route::get(
            '/apuestamanomanos/{apuestamanomano}/apuestamanomano-users',
            [ApuestamanomanoApuestamanomanoUsersController::class, 'index']
        )->name('apuestamanomanos.apuestamanomano-users.index');
        Route::post(
            '/apuestamanomanos/{apuestamanomano}/apuestamanomano-users',
            [ApuestamanomanoApuestamanomanoUsersController::class, 'store']
        )->name('apuestamanomanos.apuestamanomano-users.store');

        Route::apiResource('apuesta-pollas', ApuestaPollaController::class);

        // ApuestaPolla Apuesta Polla Users
        Route::get('/apuesta-pollas/{apuestaPolla}/apuesta-polla-users', [
            ApuestaPollaApuestaPollaUsersController::class,
            'index',
        ])->name('apuesta-pollas.apuesta-polla-users.index');
        Route::post('/apuesta-pollas/{apuestaPolla}/apuesta-polla-users', [
            ApuestaPollaApuestaPollaUsersController::class,
            'store',
        ])->name('apuesta-pollas.apuesta-polla-users.store');

        Route::apiResource(
            'apuesta-polla-users',
            ApuestaPollaUserController::class
        );

        Route::apiResource(
            'apuestamanomano-users',
            ApuestamanomanoUserController::class
        );
    });
