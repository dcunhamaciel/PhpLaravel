<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'imagem'];

    public function rules(): array
    {
        return [
            'nome' => 'required|min:3|unique:marcas,nome,' . ($this->id ?? 0),
            'imagem' => 'required|file|mimes:png'
        ];
    }

    public function feedback(): array
    {
        return [
            'required' => 'O campo :attribute é obrigatório',
            'imagem.mimes' => 'O arquivo deve ser uma imagem do tipo png',
            'nome.min' => 'O nome deve ter no mínimo 3 caracteres',
            'nome.unique' => 'O nome da marca já existe'
        ];
    }
}
