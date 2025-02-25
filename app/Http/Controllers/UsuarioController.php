<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB; // Importação correta

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

    public function cadastrarUsuario(Request $request)
    {
        
        $request->validate([
            'nome' => 'required|string|max:255',
            'idade' => 'required|integer|min:0',
            'data_nascimento' => 'required|date',
            'profissao' => 'required|string',
        ]);

        try {
            DB::beginTransaction();
            $novoUsuario = Usuario::create([
              'nome'=> $request->nome,
              'idade'=> $request->idade,
              'data_nascimento' => $request ->data_nascimento,
              'profissao' => $request ->profissao,
            ]);
            
            DB::commit();
            
            return $novoUsuario;

        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Erro ao criar usuário: ' . $e->getMessage()], 500);
        }

    }
     
    public function telaUsuario()
{
    $usuarios = Usuario::all();
    return response()->json($usuarios);
}



    public function visualizarUsuarios($id)
    {
        try {
                    $usuario = Usuario::findOrFail($id);
            return response()->json($usuario);
        } catch (Exception $e) {
                  return response()->json(['error' => 'Erro ao buscar usuário: ' . $e->getMessage()], 500);
        }
    }

    public function AtualizarUsuario(Request $request, $id)
{
    try {
        $usuario = Usuario::findOrFail($id);
        $usuario->update($request->only(['nome', 'idade', 'data_nascimento', 'profissao']));

        return response()->json(['message' => 'Usuário atualizado com sucesso!']);
    } catch (Exception $e) {
        return response()->json(['error' => 'Erro ao atualizar usuário: ' . $e->getMessage()], 500);
    }
}



    public function deletarUsuario($id)
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
