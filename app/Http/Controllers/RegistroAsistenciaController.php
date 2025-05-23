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


public function registrarAsistencia(Request $request)
{
    $request->validate([
        'qr_code' => 'required|string',
        'tipo' => 'required|in:entrada,salida',
    ]);

    $personal = Personal::where('qr_code', $request->qr_code)->first();

    if (!$personal) {
        return response()->json(['message' => 'QR no válido o personal no encontrado', 'success' => false], 404);
    }

    $fechaHoy = now()->toDateString();
    $registro = RegistroAsistencia::firstOrNew([
        'personal_id' => $personal->id,
        'fecha' => $fechaHoy,
    ]);

    if ($request->tipo === 'entrada') {
        if ($registro->hora_entrada) {
            return response()->json(['message' => 'Ya registraste tu entrada hoy.', 'success' => false], 200);
        }

        $horaActual = now();
        $registro->hora_entrada = $horaActual;

        // 🕒 Obtener horario laboral del personal
        $horario = $personal->horariosLaborales()->first(); // Puedes mejorar esto con lógica por día

        if ($horario) {
            $horaEntradaProgramada = Carbon::createFromFormat('H:i:s', $horario->hora_entrada)->setDateFrom($horaActual);

            if ($horaActual->gt($horaEntradaProgramada)) {
                $minutosTarde = $horaEntradaProgramada->diffInMinutes($horaActual);
                $registro->minutos_tarde = $minutosTarde;
                $registro->horas_tarde = round($minutosTarde / 60, 2);
                $registro->observacion = 'Llegó tarde';
            } else {
                $registro->observacion = 'Llegó a tiempo';
            }
        }

    } else {
        if ($registro->hora_salida) {
            return response()->json(['message' => 'Ya registraste tu salida hoy.', 'success' => false], 200);
        }

        $horaActual = now();
        $registro->hora_salida = $horaActual;

        if ($registro->hora_entrada) {
            $horas = $registro->hora_entrada->diffInMinutes($horaActual) / 60;
            $registro->horas_trabajadas = round($horas, 2);
        }

        // Calcular horas extras si salió después de la hora de salida programada
        $horario = $personal->horariosLaborales()->first();

        if ($horario) {
            $horaSalidaProgramada = Carbon::createFromFormat('H:i:s', $horario->hora_salida)->setDateFrom($horaActual);

            if ($horaActual->gt($horaSalidaProgramada)) {
                $minutosExtras = $horaSalidaProgramada->diffInMinutes($horaActual);
                $registro->horas_extras = round($minutosExtras / 60, 2);
                $registro->observacion = trim(($registro->observacion ?? '') . ' + Horas extras');
            }
        }
    }

    $registro->save();

    return response()->json([
        'message' => ucfirst($request->tipo) . ' registrada correctamente.',
        'personal' => $personal,
        'success' => true
    ], 200);
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
