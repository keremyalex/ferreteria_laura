<?php

namespace App\Http\Controllers\Public\Pedido;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\Carrito;
use App\Models\Carrito_detalle;
use App\Models\Producto;
use Inertia\Inertia;
use App\Models\Pagina;


class ConfirmPedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $carrito = Carrito::GetCarrito();
        $detalles = Carrito_detalle::GetCarritoDetalles();
        $total = $carrito->monto_total;
        $cantProducts = count($detalles);
        $cantidades = [];

        foreach ($detalles as $detalle) {
            $cantidades[$detalle->id] = $detalle->cantidad;
        }

        Pagina::UpdateVisita('public.confirm_pedido');

        return Inertia::render('Public/Pedido/ConfirmPedido', [
            'carrito' => $carrito,
            'detalles' => $detalles,
            'total' => $total,
            'cantProducts' => $cantProducts,
            'cantidades' => $cantidades,
            'mostrarQR' => false,
            'error' => false,
            'visitas' => Pagina::GetPagina('public.confirm_pedido') ?? 0,
            'layout' => 'layouts.public',
            'fondo' => false,
        ]);
    }

    public function addCart(Request $request, $id)
    {
        $producto = Producto::GetProducto($id);
        $carrito = Carrito::GetCarrito();
        $detalle = Carrito_detalle::CreateCarritoDetalle([
            'cantidad' => $request->cantidad,
            'producto_id' => $id,
            'carrito_id' => $carrito->id,
            'precio' => $producto->precio,
        ]);
        $carrito = Carrito::UpdateMontoTotal(
            $carrito->monto_total + ($detalle->cantidad * $producto->precio)
        );

        return redirect()->back()->with([
            'message' => 'Producto añadido al carrito',
            'type' => 'success',
        ]);
    }

    public function removeCart($id)
    {
        $detalle = Carrito_detalle::DeleteCarritoDetalle($id);
        $carrito = Carrito::GetCarrito();
        $carrito = Carrito::UpdateMontoTotal($carrito->monto_total - ($detalle->cantidad * $detalle->precio));

        return redirect()->back()->with([
            'message' => 'Producto eliminado del carrito',
            'type' => 'success',
        ]);
    }

    public function updateCart(Request $request, $id)
    {
        $detalle = Carrito_detalle::UpdateCarritoDetalle($id, [
            'cantidad' => $request->cantidad,
        ]);
        $carrito = Carrito::GetCarrito();
        $carrito = Carrito::UpdateMontoTotal(
            $carrito->monto_total + ($request->cantidad * $detalle->precio)
        );

        return redirect()->back()->with([
            'message' => 'Carrito actualizado',
            'type' => 'success',
        ]);
    }

    public function confirmPedido()
    {
        $stockValid = Carrito_detalle::ValidStock();
        if ($stockValid) {
            $detalles = Carrito_detalle::GetCarritoDetalles();
            $pedido = Pedido::CreatePedido();
            return redirect()->route('public.pedido.qr', $pedido->id);
        } else {
            return redirect()->back()->with([
                'message' => 'Stock insuficiente',
                'type' => 'error',
            ]);
        }
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
