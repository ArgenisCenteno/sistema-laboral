<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Personal;
use App\Models\Departamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
  public function index(Request $request)
{
    if ($request->ajax()) {
        $personales = User::get();

        return DataTables::of($personales)
            ->editColumn('created_at', function ($user) {
                return $user->created_at ? $user->created_at->format('d/m/Y H:i') : '';
            })
            ->editColumn('updated_at', function ($user) {
                return $user->updated_at ? $user->updated_at->format('d/m/Y H:i') : '';
            })
            ->addColumn('actions', 'users.actions')
            ->rawColumns(['actions'])
            ->make(true);
    }

    return view('users.index');
}



    public function create()
    {
        $departamentos = Departamento::all();
        return view('users.create', compact('departamentos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'is_personal' => 'nullable|boolean',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if ($request->is_personal) {
            $request->validate([
                'nombre' => 'required',
                'apellido' => 'required',
                'cedula' => 'required|unique:personal,cedula',
                'telefono' => 'nullable',
                'email_personal' => 'nullable|email',
                'direccion' => 'nullable',
                'departamento_id' => 'required|exists:departamentos,id',
            ]);

            Personal::create([
                'nombre' => $request->nombre,
                'apellido' => $request->apellido,
                'cedula' => $request->cedula,
                'telefono' => $request->telefono,
                'email' => $request->email_personal,
                'direccion' => $request->direccion,
                'departamento_id' => $request->departamento_id,
            ]);
        }

        Alert::success('Usuario creado', 'El usuario se ha creado exitosamente.');
        return redirect()->route('users.index');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

   public function update(Request $request, User $user)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'password' => 'nullable|string|min:8|confirmed', // si usas confirmación
    ]);

    $data = $request->only('name', 'email');

    // Si se proporcionó una nueva contraseña, la hasheamos
    if ($request->filled('password')) {
        $data['password'] = bcrypt($request->password);
    }

    $user->update($data);

    Alert::success('Usuario actualizado', 'Los datos han sido actualizados correctamente.');
    return redirect()->route('users.index');
}

    public function destroy(User $user)
    {
        $user->delete();
        Alert::success('Usuario eliminado', 'El usuario ha sido eliminado correctamente.');
        return redirect()->route('users.index');
    }
}
