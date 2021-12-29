<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpleadosController;
use App\Http\Controllers\LoginController;


route::get('mensaje',[EmpleadosController::class,'mensaje']);
route::get('pago',[EmpleadosController::class,'pago']);
route::get('nomina/{diast}/{pago}',[EmpleadosController::class,'nomina']);
route::get('saludo/{nombre}/{dias}',[EmpleadosController::class,'saludo']);
route::get('salir',[EmpleadosController::class,'salir'])->name('salir');

route::get('vb',[EmpleadosController::class,'vb'])->name('vb');
route::get('altaempleado',[EmpleadosController::class,'altaempleado'])->name('altaempleado');
route::post('guardarempleado',[EmpleadosController::class,'guardarempleado'])->name('guardarempleado');

route::get('eloquent',[EmpleadosController::class,'eloquent'])->name('eloquent');

route::get('reporteempleados',[EmpleadosController::class,'reporteempleados'])->name('reporteempleados');
route::get('desactivaempleado/{ide}',[EmpleadosController::class,'desactivaempleado'])->name('desactivaempleado');
route::get('activarempleado/{ide}',[EmpleadosController::class,'activarempleado'])->name('activarempleado');
route::get('borrarempleado/{ide}',[EmpleadosController::class,'borrarempleado'])->name('borrarempleado');
route::get('modificaempleado/{ide}',[EmpleadosController::class,'modificaempleado'])->name('modificaempleado');
route::post('guardacambios',[EmpleadosController::class,'guardacambios'])->name('guardacambios');

route::get('login',[LoginController::class, 'login'])->name('login');
route::post('validar',[LoginController::class, 'validar'])->name('validar');
route::get('principal',[LoginController::class, 'principal'])->name('principal');
route::get('cerrarsesion',[LoginController::class, 'cerrarsesion'])->name('cerrarsesion');


Route::get('/', function () {
    return view('welcome');
});
