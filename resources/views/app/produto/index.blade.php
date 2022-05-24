@extends('app.layouts.basico')

@section('titulo', 'Produto') 

@section('conteudo')

    <div class="conteudo-pagina">
        <div class="titulo-pagina-2">
            <p>Produto - Listar</p>
        </div>

        <div class="menu">
            <ul>
                <li><a href="{{ route('produto.create') }}">Novo</a></li>
                <li><a href="">Consulta</a></li>
            </ul>
        </div>

        <div class="informacao-pagina">
            <div style="width: 90%; margin-left: auto; margin-right: auto;">
                <table border="1" width="100%">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Descrição</th>
                            <th>Peso</th>
                            <th>Unidade</th>
                            <th>Comprimento</th>
                            <th>Altura</th>
                            <th>Largura</th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>

                    <body>
                        @foreach ($produtos as $produto)
                            <tr>
                                <td>{{ $produto->nome }}</td>
                                <td>{{ $produto->descricao }}</td>
                                <td>{{ $produto->peso }}</td>
                                <td>{{ $produto->unidade_id }}</td>
                                <td>{{ $produto->comprimento ?? '' }}</td>
                                <td>{{ $produto->altura ?? '' }}</td>
                                <td>{{ $produto->largura ?? '' }}</td>
                                <td><a href="{{ route('produto.show', ['produto' => $produto->id]) }}">Visualizar</a></td>
                                <td><a href="{{ route('produto.edit', ['produto' => $produto->id]) }}">Editar</a></td>
                                <td>
                                    <form id="form_{{ $produto->id }}" method="post" action="{{ route('produto.destroy', ['produto' => $produto->id]) }}">
                                        @csrf
                                        @method('DELETE')
                                        <a href="#" onclick="document.getElementById('form_{{ $produto->id }}').submit()">Excluir</a>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </body>
                </table>

                {{ $produtos->count() }} - Total de registros por página
                <br>
                {{ $produtos->total() }} - Total de registros da consulta
                <br>
                {{ $produtos->firstItem() }} - Número do primeiro registro da página
                <br>
                {{ $produtos->lastItem() }} - Número do último registro da página
                <br>
                <br>
                Exibindo {{ $produtos->count() }} produtos de {{ $produtos->total() }} ({{ $produtos->firstItem() }} de {{ $produtos->lastItem() }})
                {{ $produtos->appends($request)->links() }}                                
            </div>            
        </div>        
    </div>

@endsection