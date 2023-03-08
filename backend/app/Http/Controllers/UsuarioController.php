<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use App\Http\Resources\Usuario as ResourcesUsuario;

class UsuarioController extends Controller
{

    protected $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index()
    {
        $usuarios = Usuario::all();
        return ResourcesUsuario::collection($usuarios);
    }

    public function cadastrar(Request $request)
    {
        $usuario = new Usuario;
        $usuario->nome = $request->input('nome');
        $usuario->email = $request->input('email');
        $usuario->senha = $request->input('senha');
        $usuario->nivel_usuario_id = $request->input('nivel_usuario_id');
        $usuario->save();

        if ($usuario->save()) {
            return new ResourcesUsuario($usuario);
        }
    }

    public function show($id)
    {
        $usuario = Usuario::findOrFail($id);
        return new ResourcesUsuario($usuario);
    }

    public function editar(Request $request)
    {
        $usuario = Usuario::findOrFail($request->id);
        $usuario->nome = $request->input('nome');
        $usuario->email = $request->input('email');
        $usuario->senha = $request->input('senha');
        $usuario->nivel_usuario_id = $request->input('nivel_usuario_id');

        if ($usuario->save()) {
            return new ResourcesUsuario($usuario);
        }
    }

    public function deletar($id)
    {
        $usuario = Usuario::findOrFail($id);
        if ($usuario->delete()) {
            return new ResourcesUsuario($usuario);
        }
    }
}
