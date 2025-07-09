<?php

use App\Exports\EmpleadosExport;
use App\Http\Controllers\InasistenciaController;
use App\Http\Controllers\RegistroAsistenciaController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/registrar-asistencia', function () {
    return view('asistencia-vista');
});
Route::get('/trabajadores', function () {
    return view('personal');
});
Route::post('/registro-asistencia', [RegistroAsistenciaController::class, 'registrarAsistencia'])->name('registro.asistencia');
Route::post('/personal-datos', [RegistroAsistenciaController::class, 'personalDatos'])->name('personal-datos');


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('departamentos', App\Http\Controllers\DepartamentoController::class);
Route::resource('personal', App\Http\Controllers\PersonalController::class);
Route::resource('asistencias', App\Http\Controllers\RegistroAsistenciaController::class);
Route::resource('horarios', App\Http\Controllers\HorarioLaboralController::class);
Route::resource('inasistencias', InasistenciaController::class);
Route::resource('users', UserController::class);
Route::get('/pdfPersonal/{id}', [App\Http\Controllers\PdfController::class, 'pdfPersonal'])->name('pdf.personal');
Route::get('/exportar-empleados', function () {
    return Excel::download(new EmpleadosExport, 'empleados.xlsx');
})->name('exportar.personal');
Route::get('/pdfReporte/{id}', [App\Http\Controllers\PdfController::class, 'pdfReportePersonal'])->name('pdf.reportePersonal');
Route::get('/exportar-asistencias', [RegistroAsistenciaController::class, 'exportar'])->name('asistencias.exportar');
Route::get('/asistencias/mensuales/exportar', [App\Http\Controllers\RegistroAsistenciaController::class, 'exportarMensual'])->name('asistencias.exportar.mensual');
Route::get('/exportar-inasistencias', [InasistenciaController::class, 'exportar'])->name('inasistencias.exportar');
Route::get('/inasistencias/mensuales/exportar', [App\Http\Controllers\InasistenciaController::class, 'exportarMensual'])->name('inasistencias.exportar.mensual');
Route::post('/inasistencias/registrar-ausentes', [InasistenciaController::class, 'registrarAusentes'])->name('inasistencias.registrarAusentes');


 