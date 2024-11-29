<?php

namespace App\Http\Controllers;

use App\Models\salida;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Pagina;
use App\Models\Salida_detalle;

class SalidaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $salidas = Salida::GetAllSalidas();
        $visitas = Pagina::GetPagina('salida.list') ?? 0;
        return Inertia::render('Salida/ListSalida', [
            'salidas' => $salidas,
            'visitas' => $visitas,
            'layout' =>  \Illuminate\Support\Facades\Auth::user()->tema,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $visitas = Pagina::GetPagina('salida.new') ?? 0;
        return Inertia::render('Salida/CreateSalida', [
            'layout' =>  \Illuminate\Support\Facades\Auth::user()->tema,
            'visitas' => $visitas,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $new = Salida::CreateSalida($request->all());
        if (!$new) {
            return redirect()->route('salida.create')->with([
                'message' => 'Error al crear la salida',
                'type' => 'error',
            ]);
        }
        return redirect()->route('salida.index')->with([
            'message' => 'Creado correctamente',
            'type' => 'success',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $salida = Salida::GetSalida($id);
        $detalles = Salida_detalle::GetDetalleBySalida($id);
        $visitas = Pagina::GetPagina('salida.show') ?? 0;

        return Inertia::render('Salida/ShowSalida', [
            'salida' => $salida,
            'detalles' => $detalles,
            'visitas' => $visitas,
            'layout' =>  \Illuminate\Support\Facades\Auth::user()->tema,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return redirect()->route('salida.show', $id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, salida $salida)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(salida $salida)
    {
        //
    }
    public function delete($id)
    {
        if (Salida::DeleteSalida($id)) {
            $message = 'Eliminado correctamente';
            $type = 'success';
        } else {
            $message = 'Error al eliminar';
            $type = 'error';
        }

        return redirect()->route('salida.index')->with([
            'message' => $message,
            'type' => $type,
        ]);
    }
}
