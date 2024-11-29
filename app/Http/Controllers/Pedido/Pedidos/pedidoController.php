<?php

namespace App\Http\Controllers\Pedido\Pedidos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\Pagina;
use App\Models\Pedido_detalle;
use Inertia\Inertia;
use App\Models\User;

class pedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pedidos = Pedido::GetPedidos('', 'ASC', 20);
        $visitas = Pagina::GetPagina('pedido.list') ?? 0;
        return Inertia::render('Pedido/ListPedido', [
            'pedidos' => $pedidos,
            'visitas' => $visitas,
            'layout' => \Illuminate\Support\Facades\Auth::user()->tema,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $usuarios = User::GetAllUsuarios();
        $visitas = Pagina::GetPagina('pedido.new') ?? 0;
        return Inertia::render('Pedido/CreatePedido', [
            'layout' => \Illuminate\Support\Facades\Auth::user()->tema,
            'usuarios' => $usuarios,
            'visitas' => $visitas,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $new = Pedido::CreatePedido($request->all());
        if (!$new) {
            return redirect()->route('pedido.create')->with([
                'message' => 'Error al crear el pedido',
                'type' => 'error',
            ]);
        }
        return redirect()->route('pedido.index')->with([
            'message' => 'Creado correctamente',
            'type' => 'success',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
        $pedido = Pedido::GetPedido($id);
        $detalles = Pedido_detalle::GetDetalleByPedido($id);
        $visitas = Pagina::GetPagina('pedido.show') ?? 0;

        return Inertia::render('Pedido/ShowPedido', [
            'pedido' => $pedido,
            'detalles' => $detalles,
            'visitas' => $visitas,
            'layout' => \Illuminate\Support\Facades\Auth::user()->tema,
        ]);
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

    public function delete($id)
    {
        $pedido = Pedido::find($id);

        if ($pedido) {
            // Eliminar los detalles del pedido antes de eliminar el pedido
            Pedido_detalle::where('pedido_id', $pedido->id)->delete();

            // Eliminar el pedido
            $pedido->delete();

            $message = 'Eliminado correctamente';
            $type = 'success';
        } else {
            $message = 'Error al eliminar';
            $type = 'error';
        }

        return redirect()->route('pedido.index')->with([
            'message' => $message,
            'type' => $type,
        ]);
    }
}
