<?php

namespace App\Http\Controllers\Sistema\Usuario;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Pagina;
use App\Models\User;
use Spatie\Permission\Models\Role;

class usuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::GetUsuarios('', 'ASC', 20);
        $visitas = Pagina::GetPagina('usuario.list') ?? 0;
        return Inertia::render('Usuario/ListUsuario', [
            'users' => $users,
            'visitas' => $visitas,
            'layout' => \Illuminate\Support\Facades\Auth::user()->tema,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        $areas = [
            "Almacenista",
            "Vendedor",
            "Administracion",
        ];
        $visitas = Pagina::GetPagina('usuario.new') ?? 0;

        return Inertia::render('Usuario/CreateUsuario', [
            'roles' => $roles,
            'areas' => $areas,
            'visitas' => $visitas,
            'layout' => \Illuminate\Support\Facades\Auth::user()->tema,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $userArray = $request->all();
        if ($userArray['rol'] == 1) $userArray['es_administrador'] = true;
        if ($userArray['rol'] == 4) {
            $userArray['es_cliente'] = true;
            $userArray['es_personal'] = false;
        }
        $new = User::CreateUsuario($userArray);
        $new->assignRole($userArray['rol']);
        if (!$new) {
            return redirect()->route('usuario.create')->with([
                'message' => 'Error al crear el usuario',
                'type' => 'error',
            ]);
        }
        return redirect()->route('usuario.index')->with([
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
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
        if (User::DeleteUsuario($id)) {
            $message = 'Eliminado correctamente';
            $type = 'success';
        } else {
            $message = 'Error al eliminar';
            $type = 'error';
        }

        return redirect()->route('usuario.index')->with([
            'message' => $message,
            'type' => $type,
        ]);
    }
}
