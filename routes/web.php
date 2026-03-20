<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CobrosController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::post('/cobros/{cobro}/guardar-pago', [CobrosController::class, 'registrarPago'])->name('cobros.guardar-pago')->middleware('auth');
Route::get('/cobros/{cobro}/pagar', [CobrosController::class, 'pagar'])->name('cobros.pagar')->middleware('auth');
Route::get('/cobros/{cobro}/descargar-comprobante', [CobrosController::class, 'descargarComprobante'])->name('cobros.descargar-comprobante')->middleware('auth');

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'storeRegister']);
Route::get('/api/check-medidor', function (Request $request) {
    $existe = \App\Models\Cliente::where('numero_medidor', $request->medidor)->exists();
    return response()->json(['existe' => $existe]);
	
});


Route::middleware(['auth'])->group(function () {
	Route::get('/cliente/dashboard', [ClientePortalController::class, 'dashboard'])->name('cliente.dashboard');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('clientes', ClienteController::class);
    Route::resource('cobros', CobrosController::class);
	Route::patch('/cobros/{cobro}/pagar', [CobrosController::class, 'pagar'])
    ->name('cobros.pagar');
	
});
