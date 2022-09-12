<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        .page-break {
           page-break-after: always;
        }

        .titulo {
            border: 1p;
            background-color: #c2c2c2;
            text-align: center;
            width: 100%;
            text-transform: uppercase;
            font-weight: bold;
            margin-bottom: 25px;
        }

        .tabela {
            width: 100%;
        }   

        table th {
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="titulo">Lista de Tarefas</div>
    <table class="tabela">
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
    <div class="page-break"></div>
    <h2>Página 2</h2>
    <div class="page-break"></div>
    <h2>Página 3</h2>    
</body>
</html>