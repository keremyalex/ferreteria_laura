<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;


class Search extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search', '');
        $resultados = [];

        if ($search != '') {
            $resultados = DB::table('users')
                ->select('id', 'name as nombre', DB::raw("'' as apellido"), DB::raw("'usuario' as tabla"))
                ->orWhere('name', 'ILIKE', '%' . strtolower($search) . '%')
                ->orWhere('email', 'ILIKE', '%' . strtolower($search) . '%')
                ->union(
                    DB::table('proveedor')
                        ->select('id', 'nombre', DB::raw("'' as apellido"), DB::raw("'proveedor' as tabla"))
                        ->orWhere('nombre', 'ILIKE', '%' . strtolower($search) . '%')
                        ->orWhere('correo', 'ILIKE', '%' . strtolower($search) . '%')
                )
                ->union(
                    DB::table('producto')
                        ->select('id', 'nombre', DB::raw("'' as apellido"), DB::raw("'producto' as tabla"))
                        ->orWhere('nombre', 'ILIKE', '%' . strtolower($search) . '%')
                        ->orWhere('categoria', 'ILIKE', '%' . strtolower($search) . '%')
                )
                ->union(
                    DB::table('compra')
                        ->select('compra.id as id', 'proveedor.nombre as nombre', DB::raw("'' as apellido"), DB::raw("'compra' as tabla"))
                        ->join('proveedor', 'proveedor.id', '=', 'compra.proveedor_id')
                        ->orWhere('proveedor.nombre', 'ILIKE', '%' . strtolower($search) . '%')
                        ->orWhere('compra.id', 'ILIKE', '%' . strtolower($search) . '%')
                )
                ->union(
                    DB::table('pedido')
                        ->select('pedido.id as id', 'users.name as nombre', DB::raw("'' as apellido"), DB::raw("'pedido' as tabla"))
                        ->join('users', 'users.id', '=', 'pedido.usuario_id')
                        ->orWhere('users.name', 'ILIKE', '%' . strtolower($search) . '%')
                        ->orWhere('pedido.id', 'ILIKE', '%' . strtolower($search) . '%')
                )
                ->get();
        }

        return Inertia::render('Search', [
            'resultados' => $resultados,
            'search' => $search,
        ]);
    }
}
