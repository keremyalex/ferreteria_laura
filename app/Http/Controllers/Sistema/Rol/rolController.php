<?php

namespace App\Http\Controllers\Sistema\Rol;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use App\Models\Pagina;


class rolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::where('name', 'ILIKE', '%' . request('search', '') . '%')
            ->orderBy('id', 'desc')
            ->paginate(20);
        $visitas = Pagina::GetPagina('rol.list') ?? 0;

        return Inertia::render('Rol/ListRol', [
            'roles' => $roles,
            'visitas' => $visitas,
            'layout' => \Illuminate\Support\Facades\Auth::user()->tema,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permisos = Permission::all();
        $visitas = Pagina::GetPagina('rol.new') ?? 0;

        return Inertia::render('Rol/CreateRol', [
            'permisos' => $permisos,
            'visitas' => $visitas,
            'layout' => \Illuminate\Support\Facades\Auth::user()->tema,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permisosSeleccionados' => 'required|array|min:1'
        ], [
            'name.required' => 'El campo nombre es requerido',
            'name.unique' => 'El nombre ya existe',
            'permisosSeleccionados.required' => 'Debe seleccionar al menos un permiso',
            'permisosSeleccionados.array' => 'Debe seleccionar al menos un permiso',
            'permisosSeleccionados.min' => 'Debe seleccionar al menos un permiso'
        ]);

        $rol = Role::create([
            'name' => $request->name,
            'guard_name' => 'web'
        ]);
        $rol->syncPermissions($request->permisosSeleccionados);

        return redirect()->route('rol.index')->with([
            'message' => 'Creado correctamente',
            'type' => 'success',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $rol = Role::find($id);
        $permisos = Permission::all();
        $visitas = Pagina::GetPagina('rol.edit') ?? 0;

        return Inertia::render('Rol/EditRol', [
            'rol' => $rol,
            'permisos' => $permisos,
            'visitas' => $visitas,
            'layout' => \Illuminate\Support\Facades\Auth::user()->tema,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $rol = Role::find($id);

        $request->validate([
            'name' => 'required|unique:roles,name,' . $rol->id,
            'permisosSeleccionados' => 'required|array|min:1'
        ], [
            'name.required' => 'El campo nombre es requerido',
            'name.unique' => 'El nombre ya existe',
            'permisosSeleccionados.required' => 'Debe seleccionar al menos un permiso',
            'permisosSeleccionados.array' => 'Debe seleccionar al menos un permiso',
            'permisosSeleccionados.min' => 'Debe seleccionar al menos un permiso'
        ]);

        $rol->name = $request->name;
        $rol->syncPermissions($request->permisosSeleccionados);
        $rol->save();

        return redirect()->route('rol.index')->with([
            'message' => 'Editado correctamente',
            'type' => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function delete($id)
    {
        $role = Role::find($id);

        if ($role) {
            $role->delete();
            $message = 'Eliminado correctamente';
            $type = 'success';
        } else {
            $message = 'Error al eliminar: Rol no encontrado';
            $type = 'error';
        }

        return redirect()->route('rol.index')->with([
            'message' => $message,
            'type' => $type,
        ]);
    }
}
