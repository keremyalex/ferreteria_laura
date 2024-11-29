<?php

namespace App\Http\Controllers\Public\Pedido;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ShowCarritoController extends Controller
{
    public function index()
    {
        return Inertia::render('Public/Pedido/ShowCarrito', [
            'layout' => 'layouts.public',
            'fondo' => false,
        ]);
    }
}
