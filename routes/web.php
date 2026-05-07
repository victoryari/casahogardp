<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\PersonalController;
use App\Http\Controllers\TurnoController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\FacturacionController;
use App\Http\Controllers\FinanzasController;
use App\Http\Controllers\MarketingController;
use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\MedicationController;
use Illuminate\Support\Facades\Route;

// ── Auth ──────────────────────────────────────────────
Route::get('/',      [LoginController::class, 'showLogin'])->name('login');
Route::post('/',     [LoginController::class, 'login']);
Route::get('/login', [LoginController::class, 'showLogin']);
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ── Autenticado ────────────────────────────────────────
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Personal
    Route::resource('personal', PersonalController::class)
         ->parameters(['personal' => 'personal']);

    // Turnos
    Route::get('turnos/calendario', [TurnoController::class, 'calendario'])->name('turnos.calendario');
    Route::post('turnos/{turno}/validar', [TurnoController::class, 'validar'])->name('turnos.validar');
    Route::resource('turnos', TurnoController::class)
         ->parameters(['turnos' => 'turno']);

    // Pacientes
    Route::resource('pacientes', PacienteController::class)
         ->parameters(['pacientes' => 'paciente']);

    // Servicios
    Route::resource('servicios', ServicioController::class)
         ->parameters(['servicios' => 'servicio']);

    // Facturación
    Route::get('facturacion/{factura}/pdf', [FacturacionController::class, 'generarPdf'])->name('facturacion.pdf');
    Route::resource('facturacion', FacturacionController::class)
         ->only(['index', 'create', 'store', 'show', 'destroy'])
         ->parameters(['facturacion' => 'factura']);

    // Finanzas
    Route::prefix('finanzas')->name('finanzas.')->group(function () {
        Route::get('/',                [FinanzasController::class, 'index'])->name('index');
        Route::get('/ingreso/crear',   [FinanzasController::class, 'createIngreso'])->name('ingreso.create');
        Route::post('/ingreso',        [FinanzasController::class, 'storeIngreso'])->name('ingreso.store');
        Route::get('/egreso/crear',    [FinanzasController::class, 'createEgreso'])->name('egreso.create');
        Route::post('/egreso',         [FinanzasController::class, 'storeEgreso'])->name('egreso.store');
    });

    // Marketing
    Route::resource('marketing', MarketingController::class)
         ->parameters(['marketing' => 'marketing']);

    // Medicación
    Route::prefix('medication')->name('medication.')->group(function () {
        Route::get('/dashboard', [MedicationController::class, 'dashboard'])->name('dashboard');
        Route::get('/create/{paciente}', [MedicationController::class, 'create'])->name('create');
        Route::post('/store', [MedicationController::class, 'store'])->name('store');
        Route::post('/{administracion}/administrar', [MedicationController::class, 'administrar'])->name('administrar');
    });

    // Solo administrador
    Route::middleware('rol:Administrador')->group(function () {
        Route::resource('usuarios', UsuarioController::class)
             ->parameters(['usuarios' => 'usuario']);
        Route::resource('roles', RolController::class)
             ->parameters(['roles' => 'rol'])->except(['show', 'destroy']);
        Route::get('configuracion',    [ConfiguracionController::class, 'index'])->name('configuracion.index');
        Route::put('configuracion',    [ConfiguracionController::class, 'update'])->name('configuracion.update');
    });
});
