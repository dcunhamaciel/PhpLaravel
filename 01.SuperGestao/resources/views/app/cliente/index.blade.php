@extends('app.layouts.basico')

@section('titulo', 'Cliente') 

@section('conteudo')

    <div class="conteudo-pagina">
        <div class="titulo-pagina-2">
            <p>Cliente - Listar</p>
        </div>

        <div class="menu">
            <ul>
                <li><a href="{{ route('cliente.create') }}">Novo</a></li>
                <li><a href="">Consulta</a></li>
            </ul>
        </div>

        <div class="informacao-pagina">
            <div style="width: 90%; margin-left: auto; margin-right: auto;">
                <table border="1" width="100%">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>

                    <body>
                        @foreach ($clientes as $cliente)
                            <tr>
                                <td>{{ $cliente->nome }}</td>
                                <td><a href="{{ route('cliente.show', ['cliente' => $cliente->id]) }}">Visualizar</a></td>
                                <td><a href="{{ route('cliente.edit', ['cliente' => $cliente->id]) }}">Editar</a></td>
                                <td>
                                    <form id="form_{{ $cliente->id }}" method="post" action="{{ route('cliente.destroy', ['cliente' => $cliente->id]) }}">
                                        @csrf
                                        @method('DELETE')
                                        <a href="#" onclick="document.getElementById('form_{{ $cliente->id }}').submit()">Excluir</a>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </body>
                </table>

                {{ $clientes->count() }} - Total de registros por página
                <br>
                {{ $clientes->total() }} - Total de registros da consulta
                <br>
                {{ $clientes->firstItem() }} - Número do primeiro registro da página
                <br>
                {{ $clientes->lastItem() }} - Número do último registro da página
                <br>
                <br>
                Exibindo {{ $clientes->count() }} cliente de {{ $clientes->total() }} ({{ $clientes->firstItem() }} de {{ $clientes->lastItem() }})
                {{ $clientes->appends($request)->links() }}
            </div>            
        </div>        
    </div>

@endsection