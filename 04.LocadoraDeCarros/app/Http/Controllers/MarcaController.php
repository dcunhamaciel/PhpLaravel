<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class MarcaController extends Controller
{
    private Marca $marca;

    public function __construct(Marca $marca)
    {
        $this->marca = $marca;        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $marcas = $this->marca->with('modelos')->get();

        $httpStatusCode = empty($marcas) 
            ? Response::HTTP_NO_CONTENT 
            : Response::HTTP_OK;
        
        return response()->json($marcas, $httpStatusCode);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->marca->rules(), $this->marca->feedback());

        $imagem = $request->file('imagem');
        $imagemUrn = $imagem->store('imagens', 'public');

        $marca = $this->marca->create([
            'nome' => $request->nome,
            'imagem' => $imagemUrn
        ]);

        return response()->json($marca, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $marca = $this->marca->with('modelos')->find($id);

        if (empty($marca)) {
            return response()->json(['erro' => 'Recurso pesquisado não existe.'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($marca, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $marca = $this->marca->find($id);

        if (empty($marca)) {
            return response()->json(['erro' => 'Não foi possível realizar a atualização. Recurso solicitado não existe.'], Response::HTTP_NOT_FOUND);
        }
        
        if ($request->method() === 'PATCH') {
            $regrasPatch = [];

            foreach ($marca->rules() as $field => $rule) {
                if (array_key_exists($field, $request->all())) {
                    $regrasPatch[$field] = $rule;
                }
            }

            $request->validate($regrasPatch, $marca->feedback());
        } else {
            $request->validate($marca->rules(), $marca->feedback());
        }

        if ($request->file('image')) {
            Storage::disk('public')->delete($marca->imagem);
        }

        $imagem = $request->file('imagem');
        $imagemUrn = $imagem->store('imagens', 'public');        
        
        $marca->update([
            'nome' => $request->nome,
            'imagem' => $imagemUrn
        ]);

        return response()->json($marca, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $marca = $this->marca->find($id);

        if (empty($marca)) {
            return response()->json(['erro' => 'Não foi possível realizar a exclusão. Recurso solicitado não existe.'], Response::HTTP_NOT_FOUND);
        }

        Storage::disk('public')->delete($marca->imagem);

        $marca->delete();

        return response()->json(['msg' => 'A marca foi removida com sucesso!'], Response::HTTP_ACCEPTED);
    }
}
