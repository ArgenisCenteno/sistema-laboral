<?php

namespace App\Http\Controllers;

use App\Models\HorarioLaboral;
use App\Models\Personal;
use App\Models\Departamento;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Alert;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;

class PersonalController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $personales = Personal::with('departamento')->get();

            return DataTables::of($personales)
                ->addColumn('departamento', fn($row) => $row->departamento->nombre ?? '')
                ->addColumn('actions', 'personal.actions')
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('personal.index');
    }

    public function create()
    {
        $departamentos = Departamento::where('estado', 1)->get();
        return view('personal.create', compact('departamentos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'cedula' => 'required|string|max:20|unique:personal,cedula',
            'rif' => 'nullable|string|max:20',
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'direccion' => 'nullable|string',
            'departamento_id' => 'required|exists:departamentos,id',
        ]);

        // Generar un código único para el QR
        $qrCode = Str::uuid()->toString();

        $personal = Personal::create([
            ...$request->except('qr_code'),
            'qr_code' => $qrCode,
        ]);

        Alert::success('¡Éxito!', 'Personal registrado correctamente.')->showConfirmButton('Aceptar', 'rgb(5, 68, 141)');
        return redirect()->route('personal.index');
    }

    public function edit(Personal $personal)
    {
        $horarios = HorarioLaboral::all();
        $departamentos = Departamento::where('estado', 1)->get();
        return view('personal.edit', compact('personal', 'departamentos', 'horarios'));
    }

    public function update(Request $request, Personal $personal)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'cedula' => 'required|string|max:20|unique:personal,cedula,' . $personal->id,
            'rif' => 'nullable|string|max:20',
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'direccion' => 'nullable|string',
            'departamento_id' => 'required|exists:departamentos,id',
        ]);

        $personal->update($request->all());
        if ($request->filled('horario_laboral_id')) {
            // Desvincula horarios anteriores si deseas uno único
            $personal->horariosLaborales()->sync([$request->horario_laboral_id]);
        }


        Alert::success('¡Éxito!', 'Registro actualizado correctamente.')->showConfirmButton('Aceptar', 'rgb(5, 68, 141)');
        return redirect()->route('personal.index');
    }

    public function destroy(Personal $personal)
    {
        $personal->delete();
        return redirect()->route('personal.index')->with('success', 'Personal eliminado exitosamente.');
    }
}
