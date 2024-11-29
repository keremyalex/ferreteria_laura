<?php

namespace App\Http\Controllers;

use App\Models\proveedor;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Pagina;


class ProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $proveedores = Proveedor::GetProveedores('', 'ASC', 20);
        $visitas = Pagina::GetPagina('proveedor.list') ?? 0;
        return Inertia::render('Proveedor/ListProveedor', [
            'proveedores' => $proveedores,
            'visitas' => $visitas,
            'layout' => \Illuminate\Support\Facades\Auth::user()->tema,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $visitas = Pagina::GetPagina('proveedor.new') ?? 0;
        return Inertia::render('Proveedor/CreateProveedor', [
            'layout' => \Illuminate\Support\Facades\Auth::user()->tema,
            'visitas' => $visitas,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $new = Proveedor::CreateProveedor($request->all());
        if (!$new) {
            return redirect()->route('proveedor.create')->with([
                'message' => 'Error al crear el proveedor',
                'type' => 'error',
            ]);
        }
        return redirect()->route('proveedor.index')->with([
            'message' => 'Creado correctamente',
            'type' => 'success',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $proveedor = Proveedor::find($id);
        $visitas = Pagina::GetPagina('proveedor.show') ?? 0;

        return Inertia::render('Proveedor/ShowProveedor', [
            'proveedor' => $proveedor,
            'visitas' => $visitas,
            'layout' => \Illuminate\Support\Facades\Auth::user()->tema,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $proveedor = Proveedor::find($id);
        $visitas = Pagina::GetPagina('proveedor.edit') ?? 0;

        return Inertia::render('Proveedor/EditProveedor', [
            'proveedor' => $proveedor,
            'visitas' => $visitas,
            'layout' => \Illuminate\Support\Facades\Auth::user()->tema,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $proveedor = Proveedor::find($id);
        $updated = $proveedor->update($request->all());
        if (!$updated) {
            return redirect()->route('proveedor.edit', $id)->with([
                'message' => 'Error al editar el proveedor',
                'type' => 'error',
            ]);
        }
        return redirect()->route('proveedor.index')->with([
            'message' => 'Editado correctamente',
            'type' => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(proveedor $proveedor)
    {
        //
    }

    public function delete($id)
    {
        if (Proveedor::DeleteProveedor($id)) {
            $message = 'Eliminado correctamente';
            $type = 'success';
        } else {
            $message = 'Error al eliminar';
            $type = 'error';
        }

        return redirect()->route('proveedor.index')->with([
            'message' => $message,
            'type' => $type,
        ]);
    }
}
