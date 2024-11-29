<?php

namespace App\Http\Controllers;

use App\Models\ingreso;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Pagina;
use App\Models\Ingreso_detalle;

class IngresoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ingresos = Ingreso::GetAllIngresos();
        $visitas = Pagina::GetPagina('ingreso.list') ?? 0;
        return Inertia::render('Ingreso/ListIngreso', [
            'ingresos' => $ingresos,
            'visitas' => $visitas,
            'layout' => \Illuminate\Support\Facades\Auth::user()->tema,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $visitas = Pagina::GetPagina('ingreso.new') ?? 0;
        return Inertia::render('Ingreso/CreateIngreso', [
            'layout' => \Illuminate\Support\Facades\Auth::user()->tema,
            'visitas' => $visitas,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $new = Ingreso::CreateIngreso($request->all());
        if (!$new) {
            return redirect()->route('ingreso.create')->with([
                'message' => 'Error al crear el ingreso',
                'type' => 'error',
            ]);
        }
        return redirect()->route('ingreso.show', $new->id)->with([
            'message' => 'Creado correctamente',
            'type' => 'success',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $ingreso = Ingreso::GetIngreso($id);
        $detalles = Ingreso_detalle::GetDetalleByIngreso($id);
        $visitas = Pagina::GetPagina('ingreso.show') ?? 0;

        return Inertia::render('Ingreso/ShowIngreso', [
            'ingreso' => $ingreso,
            'detalles' => $detalles,
            'visitas' => $visitas,
            'layout' => \Illuminate\Support\Facades\Auth::user()->tema,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ingreso $id)
    {
        return redirect()->route('ingreso.show', $id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ingreso $ingreso)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ingreso $ingreso)
    {
        //
    }
    public function delete($id)
    {
        if (Ingreso::DeleteIngreso($id)) {
            $message = 'Eliminado correctamente';
            $type = 'success';
        } else {
            $message = 'Error al eliminar';
            $type = 'error';
        }

        return redirect()->route('ingreso.index')->with([
            'message' => $message,
            'type' => $type,
        ]);
    }
}
