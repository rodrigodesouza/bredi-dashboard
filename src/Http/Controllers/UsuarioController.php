<?php

namespace Bredi\BrediDashboard\Http\Controllers;

use Bredi\BrediDashboard\Http\Requests\CreateUsuarioRequest;
use Bredi\BrediDashboard\Http\Requests\UpdateUsuarioRequest;
use Bredi\BrediDashboard\Models\GrupoUsuario;
use Bredi\BrediDashboard\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function __construct()
    {
        $this->vendor = config('bredidashboard.templates')[config('bredidashboard.default')];
    }
    /**
     * Display a listing of the resource.
     * Exibe uma listagem do recurso.
     * @return Response
     */
    public function index()
    {
        $users = User::with('grupoUsuario')->get();

        return view($this->vendor['name'] . '::controle.usuario.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     * Mostrar o formulário para criar um novo recurso.
     * @return Response
     */
    public function create()
    {
        $grupoUsuarios = GrupoUsuario::pluck('nome', 'id');

        return view($this->vendor['name'] . '::controle.usuario.form', compact('grupoUsuarios'));
    }

    /**
     * Store a newly created resource in storage.
     * Armazene um recurso recém-criado no armazenamento.
     * @param  Request $request
     * @return Response
     */
    public function store(CreateUsuarioRequest $request)
    {
        try {

            $input = $request->all();
            $input['password'] = Hash::make($input['password']);

            $user = User::create($input);

            return redirect()->route('bredidashboard::controle.usuario.index')->with('msg', 'Cadastro realizado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('msg', 'Não foi possível realizar o cadastro')->with('error', true)->with('exception', $e->getMessage());
        }
    }

    /**
     * Show the specified resource.
     * Mostrar o recurso especificado.
     * @return Response
     */
    public function show()
    {
        return view('bredidashboard::show');
    }

    /**
     * Show the form for editing the specified resource.
     * Mostrar o formulário para editar o recurso especificado.
     * @return Response
     */
    public function edit($user_id)
    {
        $grupoUsuarios = GrupoUsuario::pluck('nome', 'id');

        $user = User::find($user_id);

        return view($this->vendor['name'] . '::controle.usuario.form', compact('grupoUsuarios', 'user'));
    }

    /**
     * Update the specified resource in storage.
     * Atualize o recurso especificado no armazenamento.
     * @param  Request $request
     * @return Response
     */
    public function update(UpdateUsuarioRequest $request, $user_id)
    {
        try {

            $input = array_filter($request->all());

            if (isset($input['password']) and !empty($input['password'])) {
                $input['password'] = Hash::make($input['password']);
            }

            $user = User::find($user_id)->update($input);

            return redirect()->route('bredidashboard::controle.usuario.index')->with('msg', 'Registro atualizado com sucesso!');

        } catch (\Exception $e) {
            return redirect()->back()->with('msg', 'Não foi possível alterar o registro')->with('error', true)->with('exception', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     * Remova o recurso especificado do armazenamento.
     * @return Response
     */
    public function destroy($user_id)
    {
        try {
            $user = User::find($user_id);

            $user->delete();

            return redirect()->back()->with('msg', 'Registro excluido com sucesso!');

        } catch (\Exception $e) {
            return redirect()->back()->with('msg', 'Não foi possível excluir o registro.');
        }

    }
}
