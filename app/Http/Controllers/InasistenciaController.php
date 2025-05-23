<?php

namespace App\Http\Controllers;

use App\Exports\InasistenciasMensualesExport;
use App\Exports\RegistroAsistenciaExport;
use App\Exports\RegistroInasistenciaExport;
use App\Models\Inasistencia;
use App\Models\Personal;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;
use Alert;

class InasistenciaController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $inasistencias = Inasistencia::with('personal')->get();

            return DataTables::of($inasistencias)
                ->addColumn('personal', fn($row) => $row->personal->nombre . ' ' . $row->personal->apellido)
                                ->addColumn('rif', fn($row) => $row->personal->cedula)

                ->addColumn('actions', 'inasistencias.actions')
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('inasistencias.index');
    }

    public function create()
    {
        $personales = Personal::all();
        return view('inasistencias.create', compact('personales'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'personal_id' => 'required|exists:personal,id',
            'fecha' => 'required|date',
            'motivo' => 'required|string|max:255',
        ]);

        Inasistencia::create($request->all());

        Alert::success('¡Éxito!', 'Inasistencia registrada correctamente.')->showConfirmButton('Aceptar', 'rgb(5, 68, 141)');
        return redirect()->route('inasistencias.index');
    }

    public function edit(Inasistencia $inasistencia)
    {
        $personales = Personal::all();
        return view('inasistencias.edit', compact('inasistencia', 'personales'));
    }

    public function update(Request $request, Inasistencia $inasistencia)
    {
        $request->validate([
            'personal_id' => 'required|exists:personal,id',
            'fecha' => 'required|date',
            'motivo' => 'required|string|max:255',
        ]);

        $inasistencia->update($request->all());

        Alert::success('¡Éxito!', 'Inasistencia actualizada correctamente.')->showConfirmButton('Aceptar', 'rgb(5, 68, 141)');
        return redirect()->route('inasistencias.index');
    }

    public function destroy(Inasistencia $inasistencia)
    {
        $inasistencia->delete();

        return redirect()->route('inasistencias.index')->with('success', 'Inasistencia eliminada exitosamente.');
    }

     public function exportar(Request $request)
    {
        //dd("test");
        $request->validate([
            'desde' => 'required|date',
            'hasta' => 'required|date|after_or_equal:desde',
        ]);

        $desde = $request->input('desde');
        $hasta = $request->input('hasta');

        return Excel::download(new RegistroInasistenciaExport($desde, $hasta), 'asistencias_' . now()->format('Ymd_His') . '.xlsx');
    }

     public function exportarMensual()
    {
        return Excel::download(new InasistenciasMensualesExport, 'inasistencias_mensuales.xlsx');
    }
}
