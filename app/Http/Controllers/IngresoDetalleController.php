<?php

namespace App\Http\Controllers;

use App\Models\ingreso_detalle;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Pagina;
use App\Models\Producto;


class IngresoDetalleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $productos = Producto::GetAllProductos();
        $visitas = Pagina::GetPagina('ingreso-detalle.new') ?? 0;

        return Inertia::render('IngresoDetalle/CreateIngresoDetalle', [
            'layout' => \Illuminate\Support\Facades\Auth::user()->tema,
            'productos' => $productos,
            'ingreso_id' => $id,
            'visitas' => $visitas,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $new = Ingreso_detalle::CreateIngresoDetalle($request->all());
        if (!$new) {
            return redirect()->route('ingreso-detalle.create', $request->ingreso_id)->with([
                'message' => 'Error al añadir el detalle',
                'type' => 'error',
            ]);
        }
        return redirect()->route('ingreso.show', $request->ingreso_id)->with([
            'message' => 'Creado correctamente',
            'type' => 'success',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(ingreso_detalle $ingreso_detalle)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ingreso_detalle $ingreso_detalle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ingreso_detalle $ingreso_detalle)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ingreso_detalle $ingreso_detalle)
    {
        //
    }
}
