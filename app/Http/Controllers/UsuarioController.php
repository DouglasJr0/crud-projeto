<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Exception;

class UsuarioController extends Controller
{
    public function index()
    {
        try {
            $usuarios = Usuario::all();
            return view('usuarios', compact('usuarios'));
        } catch (Exception $e) {
            return response()->json(['error' => 'Erro ao buscar usuários: ' . $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'idade' => 'required|integer|min:0',
            'data_nascimento' => 'required|date',
            'profissao' => 'required|string',
        ]);

        try {
            Usuario::create($request->all());
            return response()->json(['message' => 'Usuário criado com sucesso!']);
        } catch (Exception $e) {
            return response()->json(['error' => 'Erro ao criar usuário: ' . $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $usuario = Usuario::findOrFail($id);
            return response()->json($usuario);
        } catch (Exception $e) {
            return response()->json(['error' => 'Erro ao buscar usuário: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $usuario = Usuario::findOrFail($id);

            $request->validate([
                'nome' => 'required|string|max:255',
                'idade' => 'required|integer|min:0',
                'data_nascimento' => 'required|date',
                'profissao' => 'required|string',
            ]);

            $usuario->update($request->all());
            return response()->json(['message' => 'Usuário atualizado com sucesso!']);
        } catch (Exception $e) {
            return response()->json(['error' => 'Erro ao atualizar usuário: ' . $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $usuario = Usuario::findOrFail($id);
            $usuario->delete();
            return response()->json(['message' => 'Usuário excluído com sucesso!']);
        } catch (Exception $e) {
            dd('aqui');
            return response()->json(['error' => 'Erro ao excluir usuário: ' . $e->getMessage()], 500);
        }
    }
}
