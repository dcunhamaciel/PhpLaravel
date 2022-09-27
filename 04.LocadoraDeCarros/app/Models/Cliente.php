<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = ['nome'];

    public function rules(): array
    {
        return [
            'nome' => 'required'
        ];
    }

    public function feedback(): array
    {
        return [];
    }    
}
