<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HipicoController;
use App\Http\Controllers\CaballoController;
use App\Http\Controllers\CarreraController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\FormapagoController;
use App\Http\Controllers\ApuestaPollaController;
use App\Http\Controllers\ApuestamanomanoController;
use App\Http\Controllers\ApuestaPollaUserController;
use App\Http\Controllers\ApuestamanomanoUserController;
use App\Http\Controllers\LlaveController;
use App\Http\Controllers\SalonesController;
use App\Http\Controllers\Admin;
use App\Http\Controllers\HistorialController;

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
    return view('welcome');
});

Route::middleware(['auth'])
    ->get('/dashboard', function () {
        return view('dashboard');
    })
    ->name('dashboard');

require __DIR__ . '/auth.php';

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name(
        'profile.edit'
    );
    Route::patch('/profile', [ProfileController::class, 'update'])->name(
        'profile.update'
    );
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name(
        'profile.destroy'
    );
});






Route::prefix('/')
    ->middleware('auth')
    ->group(function () {
        Route::resource('historiales', HistorialController::class);
        Route::put('/historiales/{historial}', [HistorialController::class, 'update'])->name('historiales.update');


        Route::get('/admin/apuestas-armadas2', [Admin::class, 'index2'])->name('admin.apuestas-armadas2');
Route::get('/admin/usuarios', [Admin::class, 'listadoUsuarios'])->name('admin.usuarios.listado');
Route::get('/admin/apuestamanomanos', [Admin::class, 'index'])->name('admin.apuestamanomanos.index');

        Route::resource('caballos', CaballoController::class);
        Route::resource('carreras', CarreraController::class);
        Route::resource('contactos', ContactoController::class);
        Route::patch('carreras/{carrera}/cerrar', [CarreraController::class, 'cerrar'])->name('carreras.cerrar');
        Route::resource('formapagos', FormapagoController::class);
        Route::resource('hipicos', HipicoController::class);
        Route::resource('users', UserController::class);
        Route::resource('apuestamanomanos', ApuestamanomanoController::class);
        Route::resource('apuesta-pollas', ApuestaPollaController::class);
        Route::resource(
            'apuesta-polla-users',
            ApuestaPollaUserController::class
        );
        Route::resource(
            'apuestamanomano-users',
            ApuestamanomanoUserController::class
        );
        Route::get('/reuniones', [HipicoController::class, 'reuniones'])->name('reuniones');
Route::get('/llaves', [LlaveController::class, 'index'])->name('llaves');
Route::get('/llaves/create', [LlaveController::class, 'create']);
Route::post('/llaves', [LlaveController::class, 'store']);
Route::get('/carreras/proximas/{id}', [CarreraController::class, 'proximasCarreras'])->name('carreras.proximas');
Route::get('carreras/{id}/apuestas/manomano', [ApuestamanomanoController::class, 'mostrarApuestasManoMano'])->name('carreras.apuestas.manomano');
Route::post('carreras/{id}/apuestas/manomano/guardar', [ApuestamanomanoController::class, 'guardarApuesta'])->name('carreras.apuestas.guardar');
Route::post('/carreras/{id}/apuestas/manomano/guardar2', [ApuestamanomanoController::class, 'aceptarApuesta'])->name('carreras.apuestas.aceptar');
Route::post('/comprar-llave/{id}', [LlaveController::class, 'comprarLlave'])->name('comprarLlave');
Route::get('/llaves2', [LlaveController::class, 'index2'])->name('llaves2');
Route::post('/llaves/{llave}/{llaveUser}/ganar', [LlaveController::class, 'ganar'])->name('llaves.ganar');
Route::get('/historial-jugadas', [UserController::class, 'showHistorialJugadas'])->name('historial-jugadas');
Route::get('carreras/apuestas/todas', [SalonesController::class, 'mostrarTodasLasApuestas'])->name('carreras.apuestas.todas');
//Route::get('/armar-apuestas', [ArmarApuestaController::class, 'armarApuestas'])->name('armar.apuestas');

Route::get('carreras/{id}/apuestas/polla', [ApuestaPollaController::class, 'mostrarApuestasPolla'])->name('carreras.apuestas.polla');
// Definir la ruta con el método post, el controlador y el nombre
Route::post('carreras/{id}/apuestas/polla/guardar', [ApuestaPollaController::class, 'guardar'])->name('apuestaPolla.guardar');
Route::post('carreras/{id}/apuestas/polla/entrar', [ApuestaPollaController::class, 'entrar'])->name('apuestaPolla.entrar');

Route::get('/cargar-saldo', [FormapagoController::class, 'cargarSaldo'])->name('cargar.saldo');

Route::post('/procesar-deuda/{id}/{accion}', [Admin::class, 'procesarDeuda'])->name('admin.procesar-deuda');


Route::get('/ayuda', function () {
    return view('Ayuda');
})->name('ayuda');

Route::get('/reglamento', function () {
    return view('Reglamento');
})->name('reglamento');
       

    });
