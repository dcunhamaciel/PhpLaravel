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
    Fornecedor: {{ $fornecedores[0]['nome'] }}
    <br/>
    Status: {{ $fornecedores[0]['status'] }}
    <br/>
    @isset($fornecedores[0]['cnpj'])
        CNPJ: {{ $fornecedores[0]['cnpj'] }}
        @empty($fornecedores[0]['cnpj'])
            Vazio
        @endempty
    @endisset    
@endisset    