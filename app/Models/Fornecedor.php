<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fornecedor extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'fornecedores';

    // indica que irá receber os atributos abaixo por array no método estático create
    protected $fillable = ['nome', 'site', 'uf', 'email'];
}
