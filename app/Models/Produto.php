<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'descricao', 'peso', 'fornecedor_id', 'unidade_id'];

    public function produtoDetalhe() 
    {
        return $this->hasOne('App\Models\ProdutoDetalhe');
    }

    public function fornecedor() 
    {
        return $this->belongsTo('App\Models\Fornecedor');
    }
}
