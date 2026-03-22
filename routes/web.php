<?php
use App\Http\Controllers\ClientePortalController;
use App\Http\Controllers\ClienteAuthController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CobrosController;
use App\Http\Controllers\LecturaController;
use App\Http\Controllers\MedidorController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// ============ STAFF AUTH (Users) ============
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ============ CLIENTE AUTH (Separate) ============
Route::get('/cliente/login', [ClienteAuthController::class, 'loginForm'])->name('cliente.login');
Route::post('/cliente/login', [ClienteAuthController::class, 'login']);
Route::get('/cliente/register', [ClienteAuthController::class, 'registerForm'])->name('cliente.register');
Route::post('/cliente/register', [ClienteAuthController::class, 'register']);
Route::post('/cliente/logout', [ClienteAuthController::class, 'logout'])->name('cliente.logout');

// ============ CLIENTE PORTAL (Protected by cliente guard) ============
Route::middleware(['auth:cliente'])->group(function () {
    Route::get('/cliente/dashboard', [ClientePortalController::class, 'dashboard'])->name('cliente.dashboard');
    Route::post('/cobros/{cobro}/guardar-pago', [CobrosController::class, 'registrarPago'])->name('cobros.guardar-pago');
    Route::get('/cobros/{cobro}/descargar-comprobante', [CobrosController::class, 'descargarComprobante'])->name('cobros.descargar-comprobante');
});

Route::get('/api/check-medidor', function (Request $request) {
    $existe = \App\Models\Medidor::where('numero_medidor', $request->medidor)->exists();
    return response()->json(['existe' => $existe]);
});

// ============ STAFF DASHBOARD (Protected by web guard - Users only) ============
Route::middleware(['auth:web'])->group(function () {
    // Admin, Cajero & Supervisor Routes
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('role:admin,cajero,supervisor');
    
    Route::resource('clientes', ClienteController::class)->middleware('role:admin,cajero,supervisor');
    Route::resource('medidores', MedidorController::class)->middleware('role:admin,cajero,supervisor');
    Route::resource('cobros', CobrosController::class)->middleware('role:admin,cajero');
    Route::get('/cobros/{cobro}/pagar', [CobrosController::class, 'pagar'])->name('cobros.pagar')->middleware('role:admin,cajero');
    
    // Lecturas (Admin, Cajero, Supervisor)
    Route::resource('lecturas', LecturaController::class)->middleware('role:admin,cajero,supervisor');
    
    // Reports (Admin, Cajero, Supervisor)
    Route::get('/reportes', [ReportController::class, 'index'])->name('reports.index')->middleware('role:admin,cajero,supervisor');
    Route::get('/reportes/recaudacion', [ReportController::class, 'recaudacion'])->name('reports.recaudacion')->middleware('role:admin,cajero,supervisor');
    Route::get('/reportes/mora', [ReportController::class, 'mora'])->name('reports.mora')->middleware('role:admin,cajero,supervisor');
    Route::get('/reportes/ingresos', [ReportController::class, 'ingresos'])->name('reports.ingresos')->middleware('role:admin,cajero,supervisor');
    
    // Admin only - Full management
    Route::resource('users', UsersController::class)->middleware('role:admin');
    Route::resource('roles', RolesController::class)->middleware('role:admin');
});
