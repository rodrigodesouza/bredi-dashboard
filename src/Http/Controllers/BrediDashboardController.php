<?php

namespace Bredi\BrediDashboard\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Rd7\ImagemUpload\ImagemUpload;
use Illuminate\Support\Facades\DB;

class BrediDashboardController extends Controller
{
    public function __construct()
    {
        $this->vendor = config('bredidashboard.templates')[config('bredidashboard.default')];
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view($this->vendor['name'] . '::controle.index.index');
    }
    public function formLogin()
    {
        return view($this->vendor['name'] . '::login');
    }
    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('bredidashboard::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('bredidashboard::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('bredidashboard::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }

    /**
     * Faz upload de imagens do summernote
     * @return Response
     */
    public function uploadEditor(Request $request)
    {
        $imagem = ImagemUpload::salva(['input_file' => 'file', 'destino' => 'upload']);//, 'resolucao' => ['p' => ['w' => 100, 'h' => 100], 'm' => ['w' => 100, 'h' => 100]]

        return route('imagem.render', 'upload/' . $imagem);

    }

    public function deleteImageEditor(Request $request)
    {
        $nomeImagem = explode("/", $request->get('image'));
        $deleteImagem = ImagemUpload::deleta(['imagem' => end($nomeImagem), 'destino' => 'upload']);

        return response(['status' => $deleteImagem]);
    }

    public function ordenacaoUpdate(Request $request)
    {
        $tabela = $request->get('table');
        $lista = $request->get('order');
        
        try {
            foreach ($lista as $id => $value) {
                $id = (int) $value['id'];
                $cases[] = "WHEN {$id} then ?";
                $params[] = $value['order'];
                $ids[] = $id;
            }
        
            $ids = implode(',', $ids);
            $cases = implode(' ', $cases);
            $params[] = \Carbon\Carbon::now();
    
            $update = \DB::update("UPDATE `{$tabela}` SET `order` = CASE `id` {$cases} END, `updated_at` = ? WHERE `id` in ({$ids})", $params);

            return response(['msg' => $update, 'error' => false], 200);

        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
        

    }
}
