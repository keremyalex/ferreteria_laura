<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class salida_detalle extends Model
{
    protected $fillable = [
        "cantidad",
        "salida_id",
        "producto_id"
    ];
    protected $table = 'salida_detalle';
    use HasFactory;

    // Funciones
    static public function CreateSalidaDetalle(array $data)
    {
        $new = Salida_detalle::create([
            'cantidad' => $data['cantidad'],
            'salida_id' => $data['salida_id'],
            'producto_id' => $data['producto_id']
        ]);
        $producto = Producto::updateStock($new->producto_id, - $new->cantidad);
        return $new;
    }

    static public function DeleteSalidaDetalle($id)
    {
        $salidaDetalle = Salida_detalle::find($id);
        $producto = Producto::updateStock($salidaDetalle->producto_id, + $salidaDetalle->cantidad);
        $salidaDetalle->delete();
        return $salidaDetalle;
    }

    static public function GetSalidaDetallesByIdSalida($id)
    {
        $salidaDetalle = Salida_detalle::where('salida_id', $id)->get();
        return $salidaDetalle;
    }

    static public function GetDetalleBySalida(int $id)
    {
        $salidaDetalles = Salida_detalle::join('producto', 'producto.id', '=', 'salida_detalle.producto_id')
            ->select('salida_detalle.*', 'producto.nombre as producto', 'producto.imagen as imagen')
            ->where('salida_detalle.salida_id', '=', $id)
            ->orderBy('salida_detalle.id', 'desc')
            ->get();
        return $salidaDetalles;
    }

    static public function GetSalidaDetalle($id)
    {
        $salidaDetalle = Salida_detalle::find($id);
        return $salidaDetalle;
    }
}
