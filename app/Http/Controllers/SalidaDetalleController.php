<?php

namespace App\Http\Controllers;

use App\Models\salida_detalle;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Producto;
use App\Models\Pagina;

class SalidaDetalleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $productos = Producto::GetAllProductos();
        $visitas = Pagina::GetPagina('salida-detalle.new') ?? 0;

        return Inertia::render('SalidaDetalle/CreateSalidaDetalle', [
            'layout' =>  \Illuminate\Support\Facades\Auth::user()->tema,
            'productos' => $productos,
            'salida_id' => $id,
            'visitas' => $visitas,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $new = Salida_detalle::CreateSalidaDetalle($request->all());
        if (!$new) {
            return redirect()->route('salida-detalle.create', $request->salida_id)->with([
                'message' => 'Error al añadir el detalle',
                'type' => 'error',
            ]);
        }
        return redirect()->route('salida.show', $request->salida_id)->with([
            'message' => 'Creado correctamente',
            'type' => 'success',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(salida_detalle $salida_detalle)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(salida_detalle $salida_detalle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, salida_detalle $salida_detalle)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(salida_detalle $salida_detalle)
    {
        //
    }
}
