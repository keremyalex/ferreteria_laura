<?php

namespace App\Http\Controllers\Public\Pedido;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Pedido;
use App\Models\Pedido_detalle;
use App\Models\Pagina;

class ShowPedidoController extends Controller
{
    public function show($id)
    {
        $pedido = Pedido::GetPedido($id);
        $detalles = Pedido_detalle::GetDetalleByPedido($id);
        Pagina::UpdateVisita('public.pedido.show');
        $visitas = Pagina::GetPagina('public.pedido.show') ?? 0;

        return Inertia::render('Public/Pedido/ShowPedido', [
            'pedido' => $pedido,
            'detalles' => $detalles,
            'visitas' => $visitas,
            'layout' => 'layouts.public',
            'fondo' => false,
        ]);
    }
}
