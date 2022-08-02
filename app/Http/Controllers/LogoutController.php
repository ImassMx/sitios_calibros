<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function store()
    {
        auth()->logout();
        return redirect()->route('login');
    }

    public function cerrarSesionCliente()
    {
        auth()->logout();
        return redirect()->route('login.cliente');
    }

    public function cerrarSesionDoctor()
    {
        auth()->logout();
        return redirect()->route('login.doctor');
    }
}
