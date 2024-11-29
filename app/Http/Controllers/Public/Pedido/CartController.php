<?php

namespace App\Http\Controllers\Public\Pedido;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Carrito;
use App\Models\Pedido;
use App\Models\Carrito_detalle;
use App\Models\Producto;


class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!\Illuminate\Support\Facades\Auth::user()) {
            $cantProducts = 0;
            return Inertia::render('Public/Pedido/Cart', [
                'detalles' => [],
                'cantProducts' => $cantProducts,
                'carrito' => null,
            ]);
        }

        $carrito = Carrito::GetCarrito();
        $detalles = Carrito_detalle::GetCarritoDetalles();
        $cantProducts = count($detalles);

        return Inertia::render('Public/Pedido/Cart', [
            'detalles' => $detalles,
            'cantProducts' => $cantProducts,
            'carrito' => $carrito,
        ]);
    }

    public function addCart(Request $request, $id)
    {
        $producto = Producto::GetProducto($id);
        $carrito = Carrito::GetCarrito();
        $detalle = Carrito_detalle::CreateCarritoDetalle([
            'cantidad' => $request->cant,
            'producto_id' => $id,
            'carrito_id' => $carrito->id,
            'precio' => $producto->precio,
        ]);
        $carrito = Carrito::UpdateMontoTotal($carrito->monto_total + ($detalle->cantidad * $producto->precio));

        return redirect()->back()->with([
            'message' => 'Producto añadido al carrito',
            'type' => 'success',
        ]);
    }

    public function removeCart($id)
    {
        $detalle = Carrito_detalle::DeleteCarritoDetalle($id);
        $carrito = Carrito::GetCarrito();
        $carrito = Carrito::UpdateMontoTotal($carrito->monto_total - ($detalle->cantidad * $detalle->producto->precio));

        return redirect()->back()->with([
            'message' => 'Producto eliminado del carrito',
            'type' => 'success',
        ]);
    }

    public function updateCart(Request $request, $id)
    {
        $detalle = Carrito_detalle::UpdateCarritoDetalle($id, [
            'cantidad' => $request->cant,
        ]);
        $carrito = Carrito::GetCarrito();
        $carrito = Carrito::UpdateMontoTotal($carrito->monto_total - ($detalle->cantidad * $detalle->producto->precio));

        return redirect()->back()->with([
            'message' => 'Carrito actualizado',
            'type' => 'success',
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
}
