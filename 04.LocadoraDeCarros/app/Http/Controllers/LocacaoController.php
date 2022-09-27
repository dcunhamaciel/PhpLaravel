<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use App\Models\Locacao;
use App\Repositories\LocacaoRepository;

class LocacaoController extends Controller
{
    private Locacao $locacao;

    public function __construct(Locacao $locacao)
    {
        $this->locacao = $locacao;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $locacaoRepository = new LocacaoRepository($this->locacao);

        if ($request->has('filtro')) {
            $filtro = $request->filtro;
            $locacaoRepository->addFiltro($filtro);
        }

        if ($request->has('atributos')) {
            $atributos = $request->atributos;            
            $locacaoRepository->selectAtributos($atributos);
        }
                       
        $locacoes = $locacaoRepository->getResultado();

        $httpStatusCode = empty($locacoes) 
            ? Response::HTTP_NO_CONTENT 
            : Response::HTTP_OK;
        
        return response()->json($locacoes, $httpStatusCode);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreLocacaoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->locacao->rules(), $this->locacao->feedback());

        $locacao = $this->locacao->create([
            'cliente_id' => $request->cliente_id,
            'carro_id' => $request->carro_id,
            'data_inicio_periodo' => $request->data_inicio_periodo,
            'data_final_previsto_periodo' => $request->data_final_previsto_periodo,
            'data_final_realizado_periodo' => $request->data_final_realizado_periodo,
            'valor_diaria' => $request->valor_diaria,
            'km_inicial' => $request->km_inicial,
            'km_final' => $request->km_final
        ]);

        return response()->json($locacao, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Locacao  $locacao
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $locacao = $this->locacao->find($id);

        if (empty($locacao)) {
            return response()->json(['erro' => 'Recurso pesquisado não existe.'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($locacao, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateLocacaoRequest  $request
     * @param  \App\Models\Locacao  $locacao
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $locacao = $this->locacao->find($id);

        if (empty($locacao)) {
            return response()->json(['erro' => 'Não foi possível realizar a atualização. Recurso solicitado não existe.'], Response::HTTP_NOT_FOUND);
        }
        
        if ($request->method() === 'PATCH') {
            $regrasPatch = [];

            foreach ($locacao->rules() as $field => $rule) {
                if (array_key_exists($field, $request->all())) {
                    $regrasPatch[$field] = $rule;
                }
            }

            $request->validate($regrasPatch, $locacao->feedback());
        } else {
            $request->validate($locacao->rules(), $locacao->feedback());
        }
       
        $locacao->fill($request->all());
        $locacao->save();

        return response()->json($locacao, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Locacao  $locacao
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $locacao = $this->locacao->find($id);

        if (empty($locacao)) {
            return response()->json(['erro' => 'Não foi possível realizar a exclusão. Recurso solicitado não existe.'], Response::HTTP_NOT_FOUND);
        }

        $locacao->delete();

        return response()->json(['msg' => 'A Locação foi removida com sucesso!'], Response::HTTP_ACCEPTED);
    }
}
