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
    Fornecedor: {{ $fornecedores[1]['nome'] }}
    <br/>
    Status: {{ $fornecedores[1]['status'] }}
    <br/>
    Telefone: ({{ $fornecedores[1]['ddd'] ?? '' }}) {{ $fornecedores[1]['telefone'] ?? '' }}
    <br/>
    @switch($fornecedores[1]['ddd'])
        @case('11')
            São Paulo - SP
            @break
        @case('32')
            Juiz de Fora - MG
            @break        
        @case('85')
            Fortaleza - CE
            @break
        @default
            Cidade/Estado Não Identificados
    @endswitch
@endisset