@if(isset($pedido->id))
    <form method="post" action="{{ route('pedido.update', ['pedido' => $pedido->id]) }}">
    @csrf
    @method('PUT')                    
@else
    <form method="post" action="{{ route('pedido.store') }}">
        @csrf
@endif
    <select name="cliente_id">
        <option value="">-- Selecione o Cliente --</option>
        @foreach ($clientes as $cliente)
            <option value="{{ $cliente->id }}" {{ ($cliente->cliente_id ?? old('cliente_id')) == $cliente->id ? 'selected' : '' }}>{{ $cliente->nome }}</option>
        @endforeach                                                
    </select>
    {{ $errors->has('cliente_id') ? $errors->first('cliente_id') : '' }}

    <button type="submit" classe="borda-preta">Cadastrar</button>
</form>