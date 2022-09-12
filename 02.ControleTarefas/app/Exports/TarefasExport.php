<?php

namespace App\Exports;

use App\Models\Tarefa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TarefasExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return auth()->user()->tarefas()->get();
    }

    /**
     * @return array
     */    
    public function headings(): array
    {
        return [
            'ID Tarefa',
            'Tarefa',
            'Data Limite Conclusão'
        ];
    }

    /**
     * @param  mixed  $row
     * @return array
     */
    public function map($row): array
    {
        return [
            $row->id,
            $row->tarefa,
            date('d-m-Y', strtotime($row->data_limite_conclusao))
        ];
    }
}
