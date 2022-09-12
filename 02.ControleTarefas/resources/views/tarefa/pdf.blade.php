<h2>Lista de Tarefas</h2>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Tarefa</th>
            <th>Data Limite Conclusão</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($tarefas as $tarefa)
            <tr>
                <th>{{ $tarefa->id }}</th>
                <td>{{ $tarefa->tarefa }}</td>
                <td>{{ date('d-m-Y', strtotime($tarefa->data_limite_conclusao)) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>