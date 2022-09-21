<?php

namespace App\Http\Controllers;

use App\Models\Modelo;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class ModeloController extends Controller
{
    private Modelo $modelo;

    public function __construct(Modelo $modelo)
    {
        $this->modelo = $modelo;        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $modelos = $this->modelo->with('marca')->get();

        $httpStatusCode = empty($modelos) 
            ? Response::HTTP_NO_CONTENT 
            : Response::HTTP_OK;
        
        return response()->json($modelos, $httpStatusCode);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->modelo->rules(), $this->modelo->feedback());

        $imagem = $request->file('imagem');
        $imagemUrn = $imagem->store('imagens/modelos', 'public');

        $modelo = $this->modelo->create([
            'marca_id' => $request->marca_id,
            'nome' => $request->nome,
            'imagem' => $imagemUrn,
            'numero_portas' => $request->numero_portas,
            'lugares' => $request->lugares,
            'air_bag' => $request->air_bag,
            'abs' => $request->abs
        ]);

        return response()->json($modelo, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Modelo  $modelo
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $modelo = $this->modelo->with('marca')->find($id);

        if (empty($modelo)) {
            return response()->json(['erro' => 'Recurso pesquisado não existe.'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($modelo, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Modelo  $modelo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $modelo = $this->modelo->find($id);

        if (empty($modelo)) {
            return response()->json(['erro' => 'Não foi possível realizar a atualização. Recurso solicitado não existe.'], Response::HTTP_NOT_FOUND);
        }
        
        if ($request->method() === 'PATCH') {
            $regrasPatch = [];

            foreach ($modelo->rules() as $field => $rule) {
                if (array_key_exists($field, $request->all())) {
                    $regrasPatch[$field] = $rule;
                }
            }

            $request->validate($regrasPatch, $modelo->feedback());
        } else {
            $request->validate($modelo->rules(), $modelo->feedback());
        }

        if ($request->file('image')) {
            Storage::disk('public')->delete($modelo->imagem);
        }

        $imagem = $request->file('imagem');
        $imagemUrn = $imagem->store('imagens/modelos', 'public');        
        
        $modelo->update($request->all());
        $modelo->imagem = $imagemUrn;
        $modelo->save();

        return response()->json($modelo, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Modelo  $modelo
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $modelo = $this->modelo->find($id);

        if (empty($modelo)) {
            return response()->json(['erro' => 'Não foi possível realizar a exclusão. Recurso solicitado não existe.'], Response::HTTP_NOT_FOUND);
        }

        Storage::disk('public')->delete($modelo->imagem);

        $modelo->delete();

        return response()->json(['msg' => 'O modelo foi removido com sucesso!'], Response::HTTP_ACCEPTED);
    }
}
