<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <card-component titulo="Busca de Marcas">
                    <template v-slot:conteudo>
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
                    </template>
                    <template v-slot:rodape>
                        <button type="submit" class="btn btn-primary btn-sm float-end">Pesquisar</button>
                    </template>
                </card-component>

                <card-component titulo="Relação Marcas">
                    <template v-slot:conteudo>
                        <table-component></table-component>
                    </template>
                    <template v-slot:rodape>
                        <button type="button" class="btn btn-primary btn-sm float-end" data-bs-toggle="modal" data-bs-target="#modalMarca">Adicionar</button>
                    </template>
                </card-component>             
            </div>
        </div>
        <modal-component id="modalMarca" titulo="Adicionar Marca">
            <template v-slot:conteudo>
                <div class="form-group">
                    <input-container-component id="novoNome" id-help="novoNomeHelp" titulo="Nome" texto-ajuda="Informe o Nome da Marca">
                        <input type="text" class="form-control" id="novoNome" aria-describedby="novoNomeHelp" placeholder="Nome">
                    </input-container-component>

                    <input-container-component id="novoImagem" id-help="novoImagemHelp" titulo="Imagem" texto-ajuda="Selecione uma Imagem">
                        <input type="file" class="form-control-file" id="novoImagem" aria-describedby="novoImagemHelp" placeholder="Selecione uma Imagem">
                    </input-container-component>          
                </div>
            </template>
            <template v-slot:rodape>
                <button type="button" class="btn btn-primary">Salvar</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </template>
        </modal-component>
    </div>
</template>

<script>
</script>
