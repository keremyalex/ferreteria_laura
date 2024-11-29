<?php

namespace App\Http\Controllers;

use App\Models\producto;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Pagina;


class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productos = Producto::GetProductos('', 'ASC', 20);
        $visitas = Pagina::GetPagina('producto.list') ?? 0;
        return Inertia::render('Producto/ListProducto', [
            'productos' => $productos,
            'visitas' => $visitas,
            'layout' => \Illuminate\Support\Facades\Auth::user()->tema,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $visitas = Pagina::GetPagina('producto.new') ?? 0;
        return Inertia::render('Producto/CreateProducto', [
            'layout' => \Illuminate\Support\Facades\Auth::user()->tema,
            'visitas' => $visitas,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $new = Producto::CreateProducto($request->all());
        if (!$new) {
            return redirect()->route('producto.create')->with([
                'message' => 'Error al crear el producto',
                'type' => 'error',
            ]);
        }
        return redirect()->route('producto.index')->with([
            'message' => 'Creado correctamente',
            'type' => 'success',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $producto = Producto::find($id);
        $visitas = Pagina::GetPagina('producto.show') ?? 0;

        return Inertia::render('Producto/ShowProducto', [
            'producto' => $producto,
            'visitas' => $visitas,
            'layout' => \Illuminate\Support\Facades\Auth::user()->tema,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $producto = Producto::find($id);
        $visitas = Pagina::GetPagina('producto.edit') ?? 0;

        return Inertia::render('Producto/EditProducto', [
            'producto' => $producto,
            'visitas' => $visitas,
            'layout' => \Illuminate\Support\Facades\Auth::user()->tema,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $producto = Producto::find($id);
        $updated = $producto->update($request->all());
        if (!$updated) {
            return redirect()->route('producto.edit', $id)->with([
                'message' => 'Error al editar el producto',
                'type' => 'error',
            ]);
        }
        return redirect()->route('producto.index')->with([
            'message' => 'Editado correctamente',
            'type' => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(producto $producto)
    {
        //
    }

    public function delete($id)
    {
        if (Producto::DeleteProducto($id)) {
            $message = 'Eliminado correctamente';
            $type = 'success';
        } else {
            $message = 'Error al eliminar';
            $type = 'error';
        }

        return redirect()->route('producto.index')->with([
            'message' => $message,
            'type' => $type,
        ]);
    }
}
