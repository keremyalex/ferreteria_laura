<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ingreso_detalle extends Model
{
    protected $fillable = [
        "cantidad",
        "ingreso_id",
        "producto_id"
    ];
    protected $table = 'ingreso_detalle';
    use HasFactory;

    // Funciones
    static public function CreateIngresoDetalle(array $data)
    {
        $new = Ingreso_detalle::create([
            'cantidad' => $data['cantidad'],
            'ingreso_id' => $data['ingreso_id'],
            'producto_id' => $data['producto_id']
        ]);
        $producto = Producto::updateStock($new->producto_id, + $new->cantidad);
        return $new;
    }

    static public function DeleteIngresoDetalle($id)
    {
        $ingresoDetalle = Ingreso_detalle::find($id);
        $producto = Producto::updateStock($ingresoDetalle->producto_id, - $ingresoDetalle->cantidad);
        $ingresoDetalle->delete();
        return $ingresoDetalle;
    }

    static public function GetIngresoDetallesByIdIngreso($id)
    {
        $ingresoDetalle = Ingreso_detalle::where('ingreso_id', $id)->get();
        return $ingresoDetalle;
    }

    static public function GetDetalleByIngreso(int $id)
    {
        $ingresoDetalles = Ingreso_detalle::join('producto', 'producto.id', '=', 'ingreso_detalle.producto_id')
            ->select('ingreso_detalle.*', 'producto.nombre as producto', 'producto.imagen as imagen')
            ->where('ingreso_detalle.ingreso_id', '=', $id)
            ->orderBy('ingreso_detalle.id', 'desc')
            ->get();
        return $ingresoDetalles;
    }

    static public function GetIngresoDetalle($id)
    {
        $ingresoDetalle = Ingreso_detalle::find($id);
        return $ingresoDetalle;
    }
}
