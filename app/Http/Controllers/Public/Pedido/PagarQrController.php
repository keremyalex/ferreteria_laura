<?php

namespace App\Http\Controllers\Public\Pedido;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Pedido;
use App\Models\Pedido_detalle;

class PagarQrController extends Controller
{
    public function show($id)
    {
        $pedido = Pedido::GetPedido($id);
        $detalles = Pedido_detalle::GetDetalleByPedido($id);

        return Inertia::render('Public/Pedido/PagarQR', [
            'pedido' => $pedido,
            'detalles' => $detalles,
            'layout' => 'layouts.public',
            'fondo' => false,
        ]);
    }
}
