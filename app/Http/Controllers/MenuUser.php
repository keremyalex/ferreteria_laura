<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;

class MenuUser extends Controller
{
    public function index()
    {
        $temaActual = \Illuminate\Support\Facades\Auth::user()->tema ?? 'layouts.joven';
        $temas = [
            [
                "label" => "Niño",
                "value" => "layouts.niño",
            ],
            [
                "label" => "Joven",
                "value" => "layouts.joven",
            ],
            [
                "label" => "Adulto",
                "value" => "layouts.adulto",
            ],
        ];

        return Inertia::render('MenuUser', [
            'temaActual' => $temaActual,
            'temas' => $temas,
        ]);
    }

    public function cambiarTema(Request $request)
    {
        User::cambiarTema(\Illuminate\Support\Facades\Auth::user()->id, $request->tema);
        return redirect()->route('dashboard.index');
    }
}
