<?php

namespace App\Http\Controllers\Public\Pedido;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Pedido;
use App\Models\Pagina;

class ListPedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = \Illuminate\Support\Facades\Auth::user()->id;
        $pedidos = Pedido::GetPedidosByUsuario($userId);
        Pagina::UpdateVisita('public.pedido');
        $visitas = Pagina::GetPagina('public.pedido') ?? 0;

        return Inertia::render('Public/Pedido/ListPedido', [
            'pedidos' => $pedidos,
            'visitas' => $visitas,
            'layout' => 'layouts.public',
            'fondo' => false,
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
