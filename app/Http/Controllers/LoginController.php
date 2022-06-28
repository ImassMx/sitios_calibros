<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
       
    }

    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'email' => 'required',
                'password' => 'required'
            ],
            [
                'email.required' => 'El email es requerido',
                'email.email' => 'Ingrese un correo válido',
                'password.required' => 'El password es requerido'
            ]
        );
        
        if(!auth()->attempt($request->only('email','password'),$request->remember)){
            return back()->with('mensaje','Credenciales Incorrectas');
        }
        return redirect()->route('home');
    }
}
