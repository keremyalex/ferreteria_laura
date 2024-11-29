<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Pagina;
use App\Models\Producto;
use App\Models\Inicio_sesiones;
use App\Models\Pedido;
use App\Models\Compra;
use App\Models\User;

class Dashboard extends Controller
{
    public function index()
    {
        Pagina::UpdateVisita('dashboard');
        $paginas = Pagina::GetMoreVisited();
        $ingresos = Inicio_sesiones::GetLastSesiones();
        $productos = count(Producto::all());
        $ventas = Pedido::GetValueVentas();
        $compras = Compra::GetValueCompras();
        $clientes = User::GetClientes();
        $colores = [
            '#FFCE56',
            '#FF6384',
            '#36A2EB',
            '#FFCD56',
        ];
        $visitas = Pagina::GetPagina('dashboard') ?? 0;

        return Inertia::render('Dashboard', [
            'paginas' => $paginas,
            'ingresos' => $ingresos,
            'productos' => $productos,
            'ventas' => $ventas,
            'compras' => $compras,
            'clientes' => $clientes,
            'colores' => $colores,
            'visitas' => $visitas,
            'layout' =>  \Illuminate\Support\Facades\Auth::user()->tema,
        ]);
    }
}
