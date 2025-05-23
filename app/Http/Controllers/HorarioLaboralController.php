<?php

namespace App\Http\Controllers;

use App\Models\HorarioLaboral;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Alert;

class HorarioLaboralController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $horarios = HorarioLaboral::all();

            return DataTables::of($horarios)
                ->addColumn('actions', 'horarios.actions')
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('horarios.index');
    }

    public function create()
    {
        return view('horarios.create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'nombre' => 'required|string|max:100',
            'hora_entrada' => 'required|date_format:H:i',
            'hora_salida' => 'required|date_format:H:i|after:hora_entrada',
        ]);

        HorarioLaboral::create($request->all());

        Alert::success('¡Éxito!', 'Horario registrado correctamente.')->showConfirmButton('Aceptar', 'rgb(5, 68, 141)');
        return redirect()->route('horarios.index');
    }

    public function edit(HorarioLaboral $horario)
    {
        return view('horarios.edit', compact('horario'));
    }

    public function update(Request $request, HorarioLaboral $horario)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'hora_entrada' => 'required|date_format:H:i:s',
            'hora_salida' => 'required|date_format:H:i:s|after:hora_entrada',
        ]);


        $horario->update($request->all());

        Alert::success('¡Éxito!', 'Horario actualizado correctamente.')->showConfirmButton('Aceptar', 'rgb(5, 68, 141)');
        return redirect()->route('horarios.index');
    }

    public function destroy(HorarioLaboral $horario)
    {
        $horario->delete();
        return redirect()->route('horarios.index')->with('success', 'Horario eliminado exitosamente.');
    }
}
