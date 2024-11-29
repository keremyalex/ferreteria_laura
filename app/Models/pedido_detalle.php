<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class pedido_detalle extends Model
{
    use HasFactory;
    protected $fillable = [
        "cantidad",
        "precio",
        "pedido_id",
        "producto_id",
    ];
    protected $table = 'pedido_detalle';

    // Asociaciones

    // Funciones
    static public function GetPedidoDetalle(int $id)
    {
        return Pedido_detalle::where('id', $id)->First();
    }

    static public function GetPedidoDetalleByPedido(int $id)
    {
        return Pedido_detalle::where('pedido_id', $id)->get();
    }

    static public function crearPedidoDetalle(int $id)
    {
        $detalles = Pedido_detalle::GetCarritoDetalles();
        foreach ($detalles as $detalle) {
            Pedido_detalle::create([
                'cantidad' => $detalle->cantidad,
                'precio' => $detalle->precio,
                'pedido_id' => $id,
                'producto_id' => $detalle->producto_id,
            ]);
            Producto::updateStock($detalle->producto_id, -$detalle->cantidad);
        }
    }

    static public function GetDetalleByPedido(int $id)
    {
        $pedidoDetalles = Pedido_detalle::join('producto', 'producto.id', '=', 'pedido_detalle.producto_id')
            ->select('pedido_detalle.*', 'producto.nombre as producto', 'producto.imagen as imagen')
            ->where('pedido_detalle.pedido_id', '=', $id)
            ->orderBy('pedido_detalle.id', 'desc')
            ->get();
        return $pedidoDetalles;
    }

    static public function GetSumaCantidadProductosPedidos(){
        $totalCantidadProductos = Pedido_detalle::join('producto', 'producto.id', '=', 'pedido_detalle.producto_id')
        ->select('producto_id', DB::raw('SUM(pedido_detalle.cantidad) as total_cantidad'))
        ->groupBy('producto_id')
        ->orderBy('total_cantidad', 'DESC')
        ->get();
        return $totalCantidadProductos;
    }
}
