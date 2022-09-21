<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Marca;

class Modelo extends Model
{
    use HasFactory;

    protected $fillable = ['marca_id', 'nome', 'imagem', 'numero_portas', 'lugares', 'air_bag', 'abs'];

    public function marca()
    {
        return $this->belongsTo(Marca::class);
    }

    public function rules(): array
    {
        return [
            'marca_id' => 'exists:marcas,id',
            'nome' => 'required|min:3|unique:modelos,nome,' . ($this->id ?? 0),
            'imagem' => 'required|file|mimes:png,jpg,jpeg',
            'numero_portas' => 'required|integer|digits_between:1,5',
            'lugares' => 'required|integer|digits_between:1,20',
            'air_bag' => 'required|boolean',
            'abs' => 'required|boolean'
        ];
    }

    public function feedback(): array
    {
        return [];
    }
}
