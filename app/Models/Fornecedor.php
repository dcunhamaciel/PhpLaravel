<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fornecedor extends Model
{
    use HasFactory;

    protected $table = 'fornecedores';

    // indica que irá receber os atributos abaixo por array no método estático create
    protected $fillable = ['nome', 'site', 'uf', 'email'];
}
