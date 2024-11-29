<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class salida extends Model
{
    protected $fillable = [
        "fecha",
        "hora",
        "motivo"
    ];
    protected $table = 'salida';
    use HasFactory;

    // Funciones
    static public function CreateSalida(array $data)
    {
        $new = Salida::create([
            'fecha' => $data['fecha'],
            'hora' => $data['hora'],
            'motivo' => $data['motivo']
        ]);
        return $new;
    }

    static public function UpdateSalida($id, array $data)
    {
        $salida = Salida::find($id);
        $salida->motivo = $data['motivo'] ?? $salida->motivo;

        $salida->save();
        return $salida;
    }

    static public function DeleteSalida($id)
    {
        $salida = Salida::find($id);

        $detallesSalida = Salida_detalle::where('salida_id', $id)->get();
        foreach ($detallesSalida as $detalle) {
            $cantidad = $detalle->cantidad;
            //eliminar detalle
            $salida_detalle = Salida_detalle::DeleteSalidaDetalle($detalle->id);
        }

        $salida->delete();
        return $salida;
    }

    static public function GetSalidas($attribute, $order = "desc", $paginate)
    {
        $salida = Salida::where('fecha', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orderBy('id', $order)
            ->paginate($paginate);
        return $salida;
    }

    static public function GetAllSalidas()
    {
        $salida = Salida::all();
        return $salida;
    }

    static public function GetSalida($id)
    {
        $salida = Salida::find($id);
        return $salida;
    }
}
