<?php

namespace App\Http\Controllers;

use App\Models\compra_detalle;
use App\Models\Producto;
use Inertia\Inertia;
use App\Models\Pagina;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompraDetalleController extends Controller
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
        $visitas = Pagina::GetPagina('compra-detalle.new') ?? 0;

        return Inertia::render('CompraDetalle/CreateCompraDetalle', [
            'layout' => \Illuminate\Support\Facades\Auth::user()->tema,
            'productos' => $productos,
            'compra_id' => $id,
            'visitas' => $visitas,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(compra_detalle $compra_detalle)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(compra_detalle $compra_detalle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, compra_detalle $compra_detalle)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(compra_detalle $compra_detalle)
    {
        //
    }
}
