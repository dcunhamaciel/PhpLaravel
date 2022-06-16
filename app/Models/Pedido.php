<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Produto;

class Pedido extends Model
{
    use HasFactory;

    protected  $fillable = ['id', 'cliente_id'];

    public function produtos() 
    {
        return $this->belongsToMany(Produto::class, 'pedido_produtos')->withPivot('quantidade', 'created_at');
    }
}
