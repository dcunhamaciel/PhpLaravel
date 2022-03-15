<h3>Fornecedor</h3>

@php
    /*
    if(empty($variavel)) {} //retorna true se a variável estiver vazia
    - '' string vazia
    - 0 inteiro zero
    - 0.0 ponto flutuante zero
    - '0' string contendo zero
    - null
    - false
    - array() vazio
    - $var variável somente declarada
    */
@endphp

{{-- @unless executa se o retorno for false --}}

@isset($fornecedores)
    @forelse($fornecedores as $fornecedor)
        Iteração atual: {{ $loop->iteration }}
        <br/>
        Fornecedor: {{ $fornecedor['nome'] }}
        <br/>
        Status: {{ $fornecedor['status'] }}
        <br/>
        Telefone: ({{ $fornecedor['ddd'] ?? '' }}) {{ $fornecedores[1]['telefone'] ?? '' }}
        <br/>
        @if($loop->first)
            Primeira iteração do loop
        @endif
        @if($loop->last)
            Última iteração do loop
            <br/>
            Total de registros: {{ $loop->count }}
        @endif        
        <hr>
    @empty
        Não existem fornecedores cadastrados
    @endforelse
@endisset