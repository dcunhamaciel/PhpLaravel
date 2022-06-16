<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MotivoContato;
use App\Models\SiteContato;

class ContatoController extends Controller
{
    public function contato(Request $request) {
        $motivo_contatos = MotivoContato::all();
        
        return view('site.contato', ['motivo_contatos' => $motivo_contatos]);
    }

    public function salvar(Request $request) {
        $request->validate([
            'nome' => 'required|min:3|max:40|unique:site_contatos',
            'telefone' => 'required',
            'email' => 'email',
            'motivo_contatos_id' => 'required',
            'mensagem' => 'required|max:2000'
            ],
            [
            'nome.min' => 'O campo nome precisa ter no mínimo 3 caracteres',
            'nome.max' => 'O campo nome deve ter no máximo 40 caracteres',
            'nome.unique' => 'O nome informado já está em uso',
            'email.email' => 'O e-mail informado não é valido',
            'mensagem.max' => 'O campo mensagem deve ter no máximo 2000 caracteres',
            'required' => 'O campo :attribute precisa ser preenchido'
            ]
        );
        /*
        $contato = new SiteContato();
        $contato->nome = $request->input('nome');
        $contato->telefone = $request->input('telefone');
        $contato->email = $request->input('email');
        $contato->motivo_contato = $request->input('motivo_contato');
        $contato->mensagem = $request->input('mensagem');
        $contato->save();
        */

        /*
        $contato = new SiteContato();
        $contato->fill($request->all());
        $contato->save();
        */

        SiteContato::create($request->all());

        return redirect()->route('site.index');
    }
}
