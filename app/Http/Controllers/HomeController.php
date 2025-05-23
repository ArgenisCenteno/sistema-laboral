<?php

namespace App\Http\Controllers;

use App\Models\Departamento;
use App\Models\Inasistencia;
use App\Models\Personal;
use App\Models\RegistroAsistencia;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */ 

    public function index()
    {
        $departamentos = Departamento::count();
        $personales = Personal::count();
        $asistencias = RegistroAsistencia::count();
        $inasistencias = Inasistencia::count();

        // Agrupar asistencias por mes
        $asistenciasMensuales = RegistroAsistencia::selectRaw('MONTH(fecha) as mes, COUNT(*) as total')
            ->groupByRaw('MONTH(fecha)')
            ->orderByRaw('MONTH(fecha)')
            ->pluck('total', 'mes');

        // Agrupar inasistencias por mes
        $inasistenciasMensuales = Inasistencia::selectRaw('MONTH(fecha) as mes, COUNT(*) as total')
            ->groupByRaw('MONTH(fecha)')
            ->orderByRaw('MONTH(fecha)')
            ->pluck('total', 'mes');

        // Preparar los datos para los charts
        $meses = collect(range(1, 12))->map(function ($mes) {
            return Carbon::create()->month($mes)->format('F');
        });

        $asistenciasData = $meses->mapWithKeys(function ($mes, $index) use ($asistenciasMensuales) {
            return [$mes => $asistenciasMensuales[$index + 1] ?? 0];
        });

        $inasistenciasData = $meses->mapWithKeys(function ($mes, $index) use ($inasistenciasMensuales) {
            return [$mes => $inasistenciasMensuales[$index + 1] ?? 0];
        });

        return view('home', compact(
            'departamentos',
            'personales',
            'asistencias',
            'inasistencias',
            'asistenciasData',
            'inasistenciasData'
        ));
    }

}
