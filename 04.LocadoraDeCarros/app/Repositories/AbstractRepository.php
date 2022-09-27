<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractRepository
{
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function selectAtributos(string $atributos)
    {
        $this->model = $this->model->selectRaw($atributos);
    }

    public function selectAtributosRegistrosRelacionados(string $atributos)
    {
        $this->model = $this->model->with($atributos);
    }

    public function addFiltro(string $filtro)
    {
        $condicoes = explode(':', $filtro);

        $this->model = $this->model->where($condicoes[0], $condicoes[1], $condicoes[2]);
    }

    public function getResultado()
    {
        return $this->model->get();
    }
}