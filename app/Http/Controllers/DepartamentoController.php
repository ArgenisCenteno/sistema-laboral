<?php

namespace App\Http\Controllers;

use App\Models\Departamento;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Alert;
class DepartamentoController extends Controller
{
    /**
     * Muestra una lista de todos los departamentos.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $productos = Departamento::get(); // Cargar la relación subCategoria

            return DataTables::of($productos)

                ->addColumn('actions', 'departamentos.actions')
                ->editColumn('estado', function ($row) {
                    return $row->estado == '1'
                        ? '<span class="badge badge-primary">Activo</span>'
                        : '<span class="badge badge-danger">Inactivo</span>';
                })

                ->rawColumns(['actions', 'estado'])
                ->make(true);
        } else {

            return view('departamentos.index');
        }
    }

    /**
     * Muestra el formulario para crear un nuevo departamento.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
    
        return view('departamentos.create');
    }

    /**
     * Almacena un nuevo departamento en la base de datos.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
           
            'estado' => 'required|boolean',
       
        ]);

        Departamento::create($request->all());
        Alert::success('¡Exito!', 'Registro hecho correctamente.')->showConfirmButton('Aceptar', 'rgb(5, 68, 141)');

        return redirect()->route('departamentos.index')->with('success', 'Departamento creado exitosamente.');
    }

    /**
     * Muestra el formulario para editar un departamento existente.
     *
     * @param \App\Models\Departamento $departamento
     * @return \Illuminate\View\View
     */
    public function edit(Departamento $departamento)
    {

        return view('departamentos.edit', compact('departamento'));
    }

    /**
     * Actualiza un departamento existente en la base de datos.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Departamento $departamento
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Departamento $departamento)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
         
            'estado' => 'required|boolean',
           
        ]);

        $departamento->update($request->all());
        Alert::success('¡Exito!', 'Registro actualizado correctamente.')->showConfirmButton('Aceptar', 'rgb(5, 68, 141)');

        return redirect()->route('departamentos.index')->with('success', 'Departamento actualizado exitosamente.');
    }

    /**
     * Elimina un departamento de la base de datos.
     *
     * @param \App\Models\Departamento $departamento
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Departamento $departamento)
    {
        $departamento->delete();

        return redirect()->route('departamentos.index')->with('success', 'Departamento eliminado exitosamente.');
    }

    
}
