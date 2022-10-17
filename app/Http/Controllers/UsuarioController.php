<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Relations\Pivot;

class UsuarioController extends Controller
{
    

    public function store(Request $request)
    {
        $this->validate($request,[
            'nombre'=> 'required',
            'usuario'=>'required|unique:users,email',
            'contraseña'=>'required',
            'rol'=>'required'
        ],[
            'nombre.required'=> 'El nombre es requerido',
            'usuario.required' => 'El usuario es requerido',
            'contraseña.required' => 'La contraseña es requerida',
            'rol.required' =>'El rol es requerido',
            'usuario.unique' => 'Este usuario ya existe'
        ]);


        User::create([
            'name' => $request->nombre,
            'email'=> $request->usuario,
            'password' => Hash::make($request->contraseña)
        ])->assignRole($request->rol);
    }

    public function edit($id)
    {
        $user = User::where('id',$id)->with('roles')->get();
        return response()->json($user);
    }

    public function update(Request $request,$id)
    {
        $user = User::find($id);

        $user->update([
            'name'=> $request->nombre,
            'email'=> $request->usuario,
            'password'=> $request->contraseña ? Hash::make($request->contraseña) : $user->password,
        ]);

        DB::table('model_has_roles')->where('model_id',$id)->delete();

        $user->assignRole($request->rol);

            $actualizado = 1;
    
        return response()->json($actualizado);
    }

    public function usuarios(Request $request)
    {
        $filtro = $request->buscador;
        $users = User::where('name','LIKE','%'.$filtro.'%')->role(['Admin','Asistente'])->with('roles')->paginate(4);
        return response()->json($users);
    }

    public function destroy( $id)
    {
        $user = User::where('id',$id)->first();
        $user->delete();
    }
}
