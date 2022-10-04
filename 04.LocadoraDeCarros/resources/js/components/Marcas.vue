<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Busca de Marcas</div>

                    <div class="card-body">
                        <div class="form-row">
                            <div class="col mb-3">
                                <input-container-component id="inputId" id-help="idHelp" titulo="ID" texto-ajuda="Opcional. Informe o ID da Marca">
                                    <input type="number" id="inputId" class="form-control" aria-describedby="idHelp" placeholder="ID">
                                </input-container-component>                                
                            </div>
                            <div class="col mb-3">
                                <input-container-component id="inputNome" id-help="nomeHelp" titulo="Nome" texto-ajuda="Opcional. Informe o Nome da Marca">
                                    <input type="text" class="form-control" id="inputNome" aria-describedby="nomeHelp" placeholder="Nome">
                                </input-container-component>                                
                            </div>                        
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary btn-sm float-end">Pesquisar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
</script>
