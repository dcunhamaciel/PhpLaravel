<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Cliente;
use App\Repositories\ClienteRepository;

class ClienteController extends Controller
{
    private Cliente $cliente;

    public function __construct(Cliente $cliente)
    {
        $this->cliente = $cliente;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $clienteRepository = new ClienteRepository($this->cliente);

        if ($request->has('filtro')) {
            $filtro = $request->filtro;
            $clienteRepository->addFiltro($filtro);
        }

        if ($request->has('atributos')) {
            $atributos = $request->atributos;            
            $clienteRepository->selectAtributos($atributos);
        }
                       
        $clientes = $clienteRepository->getResultado();

        $httpStatusCode = empty($clientes) 
            ? Response::HTTP_NO_CONTENT 
            : Response::HTTP_OK;
        
        return response()->json($clientes, $httpStatusCode);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->cliente->rules(), $this->cliente->feedback());

        $cliente = $this->cliente->create([
            'nome' => $request->nome
        ]);

        return response()->json($cliente, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $cliente = $this->cliente->find($id);

        if (empty($cliente)) {
            return response()->json(['erro' => 'Recurso pesquisado não existe.'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($cliente, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $cliente = $this->cliente->find($id);

        if (empty($cliente)) {
            return response()->json(['erro' => 'Não foi possível realizar a atualização. Recurso solicitado não existe.'], Response::HTTP_NOT_FOUND);
        }
        
        if ($request->method() === 'PATCH') {
            $regrasPatch = [];

            foreach ($cliente->rules() as $field => $rule) {
                if (array_key_exists($field, $request->all())) {
                    $regrasPatch[$field] = $rule;
                }
            }

            $request->validate($regrasPatch, $cliente->feedback());
        } else {
            $request->validate($cliente->rules(), $cliente->feedback());
        }
       
        $cliente->fill($request->all());
        $cliente->save();

        return response()->json($cliente, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $cliente = $this->cliente->find($id);

        if (empty($cliente)) {
            return response()->json(['erro' => 'Não foi possível realizar a exclusão. Recurso solicitado não existe.'], Response::HTTP_NOT_FOUND);
        }

        $cliente->delete();

        return response()->json(['msg' => 'O cliente foi removido com sucesso!'], Response::HTTP_ACCEPTED);
    }
}
