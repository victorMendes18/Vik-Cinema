<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sessão;
use App\Sala;
use App\Filme;
use App\Http\Requests\SessaoFormRequest;

class SessaoController extends Controller
{
    private $sessao;
    private $sala;
    private $filme;

    public function __construct(Sessão $sessao, Sala $sala, Filme $filme)
    {
        $this->sessao = $sessao;
        $this->sala = $sala;
        $this->filme = $filme;

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sessoes = $this->sessao->all();
        foreach ($sessoes as $sessao) {
            $sessao->idFilme =  $this->filme->find($sessao->idFilme)->nome;
            $sessao->idSala = $this->sala->find($sessao->idSala)->nome;
        }
        $titulo = "Listar Sessões";
        return view('Sessão.ListarSessoes',compact('sessoes','titulo'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $titulo = "Cadastrar Sessão";
        $hora = ['10:00','14:00','18:00','22:00'];
        return view('Sessão.CadastrarSessao',compact('titulo','hora'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SessaoFormRequest $request)
    {
        //validação de Sessão
        $filme = $this->filme->where('nome',$request->idFilme)->get();
        if(count($filme) == 0){
            return redirect()->back();
        }
        $sala = $this->sala->where('nome',$request->idSala)->get();
        if(count($sala) == 0){
            return redirect()->back();
        }
        $valSessao = $this->sessao->where([['data',$request->data],['hora',$request->hora],['idSala',$sala[0]->id]])->get();
        if(count($valSessao) > 0){
            return redirect()->back();
        }

        //cadastrando a Sessão        
        $dados = $request->except('_token');
        $dados['idFilme'] = $filme[0]->id;
        $dados['idSala'] = $sala[0]->id;
        $sessao = $this->sessao;
        $insert = $sessao->create($dados);

        if($insert){
            return redirect()->route('listarSessoes');
        }else{
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sessao = $this->sessao->find($id);
        $sala = $this->sala->find($sessao->idSala);
        $filme = $this->filme->find($sessao->idFilme);
        $titulo = "Ver Sessão";
        return view('Sessão.VerSessao',compact('sessao','sala','filme','titulo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sessao = $this->sessao->find($id);
        $filme = $this->filme->find($sessao->idFilme);
        $sala = $this->sala->find($sessao->idSala);
        $titulo = "Editar Sessão";
        $hora = ['10:00','14:00','18:00','22:00'];
        return view('Sessão.EditarSessao',compact('sessao','filme','sala','titulo','hora'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SessaoFormRequest $request, $id)
    {
        //validação de Sessão
        $filme = $this->filme->where('nome',$request->idFilme)->get();
        if(count($filme) == 0){
            return redirect()->back();
        }
        $sala = $this->sala->where('nome',$request->idSala)->get();
        if(count($sala) == 0){
            return redirect()->back();
        }
        $valSessao = $this->sessao->where([['data',$request->data],['hora',$request->hora],['idSala',$sala[0]->id]])->get();
        if(count($valSessao) > 0){
            return redirect()->back();
        }

        //update Sessão        
        $dados = $request->except('_token','_method');
        $dados['idFilme'] = $filme[0]->id;
        $dados['idSala'] = $sala[0]->id;
        $sessao = $this->sessao->find($id);
        $delete = $sessao->update($dados);

        if($delete){
            return redirect()->route('listarSessoes');
        }else{
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sessao = $this->sessao->find($id);
        $delete = $sessao->delete();

        if($delete){
            return redirect()->route('listarSessoes');
        }else{
            return redirect()->back();
        }
    }
}