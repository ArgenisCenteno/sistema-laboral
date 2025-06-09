<?php

namespace App\Http\Controllers;

use App\Exports\AsistenciasMensualesExport;
use App\Exports\RegistroAsistenciaExport;
use App\Models\Personal;
use App\Models\RegistroAsistencia;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use Alert;
class RegistroAsistenciaController extends Controller
{


    public function index(Request $request)
    {
        if ($request->ajax()) {
            $productos = RegistroAsistencia::with('personal')->get(); // Cargar la relación subCategoria

            return DataTables::of($productos)

                ->addColumn('personal', function ($row) {
                    return $row->personal->nombre . ' ' . $row->personal->apellido;
                })
                ->addColumn('cedula', function ($row) {
                    return $row->personal->cedula ?? 'S/D';
                })
                ->addColumn('motivo_salida_anticipada', function ($row) {
                    return $row->motivo_salida_anticipada ?? 'S/D';
                })
                ->addColumn('fecha', function ($row) {
                    return $row->fecha->format('d-m-Y');
                })
                ->addColumn('hora_salida', function ($row) {
                    return $row->hora_salida
                        ? $row->hora_salida->format('H:m')
                        : '<span class="badge badge-danger">Sin completar</span>';
                    ;
                })
                ->addColumn('horas_trabajadas', function ($row) {
                    return $row->horas_trabajadas
                        ? $row->horas_trabajadas
                        : '<span class="badge badge-danger">Sin completar</span>';
                    ;
                })
                ->addColumn('actions', 'asistencias.actions')


                ->rawColumns(['actions', 'horas_trabajadas', 'hora_salida'])
                ->make(true);
        } else {

            return view('asistencias.index');
        }
    }

    public function create()
    {
        return view('asistencias.create');
    }

    public function registrarAsistencia(Request $request)
    {
        $request->validate([
            'qr_code' => 'required|string',
            'motivo' => 'nullable|string|max:255',
        ]);

        $personal = Personal::where('qr_code', $request->qr_code)
            ->orWhere('cedula', $request->qr_code)
            ->first();

        if (!$personal) {
            return response()->json([
                'message' => 'Código QR o cédula no válida o personal no encontrado',
                'success' => false
            ], 404);
        }

        $fechaHoy = now()->toDateString();
        $horaActual = now();
        $horaLimite = now()->setTime(16, 0, 0); // 4:00 PM

        $registro = RegistroAsistencia::firstOrNew([
            'personal_id' => $personal->id,
            'fecha' => $fechaHoy,
        ]);

        // Si no tiene entrada → registrar entrada
        if (!$registro->hora_entrada) {
            $registro->hora_entrada = $horaActual;
            $registro->save();

            return response()->json([
                'message' => 'Entrada registrada correctamente',
                'success' => true,
                'tipo' => 'entrada',
                'personal' => $personal
            ]);
        }

        // Ya tiene entrada pero no salida
        if (!$registro->hora_salida) {
            // Si es antes de la hora límite, se requiere motivo
            if ($horaActual->lt($horaLimite) && !$request->motivo) {
                return response()->json([
                    'message' => 'Se requiere motivo para salida anticipada',
                    'success' => false,
                    'tipo' => 'motivo',
                    'personal' => $personal
                ]);
            }

            $registro->hora_salida = $horaActual;
            $registro->motivo_salida_anticipada = $request->motivo ?? null;
            $registro->save();

            return response()->json([
                'message' => 'Salida registrada correctamente',
                'success' => true,
                'tipo' => 'salida',
                'personal' => $personal
            ]);
        }

        // Ya tiene entrada y salida
        return response()->json([
            'message' => 'Ya se registró entrada y salida para hoy',
            'success' => false,
            'tipo' => 'completo',
            'personal' => $personal
        ]);
    }



    public function personalDatos(Request $request)
    {
        $request->validate([
            'qr_code' => 'required|string'
        ]);

        $personal = Personal::with('departamento', 'horariosLaborales')->where('qr_code', $request->qr_code)->first();

        if (!$personal) {
            return response()->json(['message' => 'QR no válido o personal no encontrado', 'success' => false], 404);
        }



        return response()->json(['personal' => $personal, 'success' => true], 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'observacion' => 'nullable|string|max:1000',
        ]);

        $registro = RegistroAsistencia::findOrFail($id);
        $registro->observacion = $request->input('observacion');
        $registro->save();
        Alert::success('¡Exito!', 'Registro actualizado correctamente.')->showConfirmButton('Aceptar', 'rgb(5, 68, 141)');

        return redirect()->route('asistencias.index')
            ->with('success', 'Observación actualizada correctamente.');
    }
    public function destroy($id)
    {
        $registro = RegistroAsistencia::findOrFail($id);
        $registro->delete();
        Alert::success('¡Exito!', 'Registro eliminado correctamente.')->showConfirmButton('Aceptar', 'rgb(5, 68, 141)');

        return redirect()->route('asistencias.index')
            ->with('success', 'Registro de asistencia eliminado correctamente.');
    }

    public function edit($id)
    {
        $asistencia = RegistroAsistencia::findOrFail($id);
        return view('asistencias.edit', compact('asistencia'));
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

        return Excel::download(new RegistroAsistenciaExport($desde, $hasta), 'inasistencias_' . now()->format('Ymd_His') . '.xlsx');
    }

    public function exportarMensual()
    {
        return Excel::download(new AsistenciasMensualesExport, 'asistencias_mensuales.xlsx');
    }
}
