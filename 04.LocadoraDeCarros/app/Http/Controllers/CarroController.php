<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use App\Models\Carro;
use App\Repositories\CarroRepository;

class CarroController extends Controller
{
    private Carro $carro;

    public function __construct(Carro $carro)
    {
        $this->carro = $carro;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $carroRepository = new CarroRepository($this->carro);

        $atributosModelo = '';

        if ($request->has('atributos_modelo')) {
            $atributosModelo = 'modelo:id,' . $request->atributos_modelo;                        
        } else {
            $atributosModelo = 'modelo';
        }

        $carroRepository->selectAtributosRegistrosRelacionados($atributosModelo);

        if ($request->has('filtro')) {
            $filtro = $request->filtro;
            $carroRepository->addFiltro($filtro);
        }

        if ($request->has('atributos')) {
            $atributos = $request->atributos;            
            $carroRepository->selectAtributos($atributos);
        }
                       
        $carros = $carroRepository->getResultado();

        $httpStatusCode = empty($carros) 
            ? Response::HTTP_NO_CONTENT 
            : Response::HTTP_OK;
        
        return response()->json($carros, $httpStatusCode);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCarroRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->carro->rules(), $this->carro->feedback());

        $carro = $this->carro->create([
            'modelo_id' => $request->modelo_id,
            'placa' => $request->placa,
            'disponivel' => $request->disponivel,
            'km' => $request->km
        ]);

        return response()->json($carro, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Carro  $carro
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $carro = $this->carro->with('modelo')->find($id);

        if (empty($carro)) {
            return response()->json(['erro' => 'Recurso pesquisado não existe.'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($carro, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCarroRequest  $request
     * @param  \App\Models\Carro  $carro
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $carro = $this->carro->find($id);

        if (empty($carro)) {
            return response()->json(['erro' => 'Não foi possível realizar a atualização. Recurso solicitado não existe.'], Response::HTTP_NOT_FOUND);
        }
        
        if ($request->method() === 'PATCH') {
            $regrasPatch = [];

            foreach ($carro->rules() as $field => $rule) {
                if (array_key_exists($field, $request->all())) {
                    $regrasPatch[$field] = $rule;
                }
            }

            $request->validate($regrasPatch, $carro->feedback());
        } else {
            $request->validate($carro->rules(), $carro->feedback());
        }
       
        $carro->fill($request->all());
        $carro->save();

        return response()->json($carro, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Carro  $carro
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $carro = $this->carro->find($id);

        if (empty($carro)) {
            return response()->json(['erro' => 'Não foi possível realizar a exclusão. Recurso solicitado não existe.'], Response::HTTP_NOT_FOUND);
        }

        $carro->delete();

        return response()->json(['msg' => 'O carro foi removido com sucesso!'], Response::HTTP_ACCEPTED);
    }
}
