<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class compra_detalle extends Model
{
    protected $fillable = [
        "cantidad",
        "precio",
        "compra_id",
        "producto_id"
    ];
    protected $table = 'compra_detalle';
    use HasFactory;

    // Funciones
    static public function CreateCompraDetalle(array $data)
    {
        $new = Compra_detalle::create([
            'cantidad' => $data['cantidad'],
            'precio' => $data['precio'],
            'compra_id' => $data['compra_id'],
            'producto_id' => $data['producto_id']
        ]);
        $monto = $new->cantidad * $new->precio;
        $producto = Producto::updateStock($new->producto_id, +$new->cantidad);
        Producto::UpdatePrecio($new->producto_id, $new->precio);
        $compra = Compra::find($new->compra_id);
        $compra->monto_total = $compra->monto_total + $monto;
        $compra->save();
        return $new;
    }

    static public function DeleteCompraDetalle($id)
    {
        $compraDetalle = Compra_detalle::find($id);
        $monto = $compraDetalle->cantidad * $compraDetalle->precio;
        $compra = Compra::find($compraDetalle->compra_id);
        $compraDetalle->delete();
        $compra->monto_total = $compra->monto_total - $monto;
        $compra->save();
        return $compraDetalle;
    }

    static public function GetCompraDetallesByIdCompra($id)
    {
        $compraDetalle = Compra_detalle::where('compra_id', $id)->get();
        return $compraDetalle;
    }

    static public function GetDetalleByCompra(int $id)
    {
        $compraDetalles = Compra_detalle::join('producto', 'producto.id', '=', 'compra_detalle.producto_id')
            ->select('compra_detalle.*', 'producto.nombre as producto', 'producto.imagen as imagen')
            ->where('compra_detalle.compra_id', '=', $id)
            ->orderBy('compra_detalle.id', 'desc')
            ->get();
        return $compraDetalles;
    }

    static public function GetCompraDetalle($id)
    {
        $compraDetalle = Compra_detalle::find($id);
        return $compraDetalle;
    }
}
