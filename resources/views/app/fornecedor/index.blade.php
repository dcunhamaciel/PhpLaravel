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
    @for($i = 0; isset($fornecedores[$i]); $i++)
        Fornecedor: {{ $fornecedores[$i]['nome'] }}
        <br/>
        Status: {{ $fornecedores[$i]['status'] }}
        <br/>
        Telefone: ({{ $fornecedores[$i]['ddd'] ?? '' }}) {{ $fornecedores[1]['telefone'] ?? '' }}
        <hr>
    @endfor
@endisset