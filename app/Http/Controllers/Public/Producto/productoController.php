<?php

namespace App\Http\Controllers\Public\Producto;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Producto;
use App\Models\Pagina;

class productoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productos = Producto::GetAllProductos();
        Pagina::UpdateVisita('public.producto.list');
        $visitas = Pagina::GetPagina('public.producto.list') ?? 0;

        return Inertia::render('Public/Producto/ListProducto', [
            'productos' => $productos,
            'visitas' => $visitas,
            'layout' => 'layouts.public',
            'fondo' => false,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function show($id)
    {
        $producto = Producto::GetProducto($id);
        Pagina::UpdateVisita('public.producto.show');
        $visitas = Pagina::GetPagina('public.producto.show') ?? 0;

        return Inertia::render('Public/Producto/ShowProducto', [
            'producto' => $producto,
            'visitas' => $visitas,
            'layout' => 'layouts.public',
            'fondo' => false,
        ]);
    }

    public function addCart($id)
    {
        // Lógica para añadir al carrito
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
}
