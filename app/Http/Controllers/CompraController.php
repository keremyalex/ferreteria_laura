<?php

namespace App\Http\Controllers;

use App\Models\compra;
use App\Models\Proveedor;
use App\Models\Compra_detalle;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Pagina;

class CompraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $compras = Compra::all();
        $visitas = Pagina::GetPagina('pedido.list') ?? 0;
        return Inertia::render('Compra/ListCompra', [
            'compras' => $compras,
            'visitas' => $visitas,
            'layout' => \Illuminate\Support\Facades\Auth::user()->tema,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $proveedores = Proveedor::GetAllProveedores();
        return Inertia::render('Compra/CreateCompra', [
            'layout' => \Illuminate\Support\Facades\Auth::user()->tema,
            'proveedores' => $proveedores,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $new = Compra::CreateCompra($request->all());
        if (!$new) {
            return redirect()->route('compra.create')->with([
                'message' => 'Error al crear la compra',
                'type' => 'error',
            ]);
        }
        return redirect()->route('compra.show', $new->id)->with([
            'message' => 'Creado correctamente',
            'type' => 'success',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $compra = Compra::GetCompra($id);
        $proveedor = Proveedor::GetProveedor($compra->proveedor_id);
        $detalles = Compra_detalle::GetDetalleByCompra($id);
        $visitas = Pagina::GetPagina('compra.show') ?? 0;

        return Inertia::render('Compra/ShowCompra', [
            'compra' => $compra,
            'proveedor' => $proveedor,
            'detalles' => $detalles,
            'visitas' => $visitas,
            'layout' =>  \Illuminate\Support\Facades\Auth::user()->tema,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return redirect()->route('compra.show', $id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, compra $compra)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        if (Compra::DeleteCompra($id)) {
            $message = 'Eliminado correctamente';
            $type = 'success';
        } else {
            $message = 'Error al eliminar';
            $type = 'error';
        }

        return redirect()->route('compra.index')->with([
            'message' => $message,
            'type' => $type,
        ]);
    }
}
