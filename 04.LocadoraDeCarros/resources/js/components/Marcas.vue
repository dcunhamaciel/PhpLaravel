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

                <card-component titulo="Relação de Marcas">
                    <template v-slot:conteudo>
                        <table-component :titulos="['id', 'nome', 'imagem']" :dados="marcas"></table-component>
                    </template>
                    <template v-slot:rodape>
                        <button type="button" class="btn btn-primary btn-sm float-end" data-bs-toggle="modal" data-bs-target="#modalMarca">Adicionar</button>
                    </template>
                </card-component>             
            </div>
        </div>
        <modal-component id="modalMarca" titulo="Adicionar Marca">
            <template v-slot:alertas>
                <alert-component tipo="success" titulo="Marca cadastrada com sucesso" :detalhes="transacaoDetalhes" v-if="transacaoStatus == 'adicionado'"></alert-component>
                <alert-component tipo="danger" titulo="Erro ao cadastrar a Marca" :detalhes="transacaoDetalhes" v-if="transacaoStatus == 'erro'"></alert-component>
            </template>

            <template v-slot:conteudo>
                <div class="form-group">
                    <input-container-component id="novoNome" id-help="novoNomeHelp" titulo="Nome" texto-ajuda="Informe o Nome da Marca">
                        <input type="text" class="form-control" id="novoNome" aria-describedby="novoNomeHelp" placeholder="Nome" v-model="nomeMarca">
                    </input-container-component>

                    <input-container-component id="novoImagem" id-help="novoImagemHelp" titulo="Imagem" texto-ajuda="Selecione uma Imagem">
                        <input type="file" class="form-control-file" id="novoImagem" aria-describedby="novoImagemHelp" placeholder="Selecione uma Imagem" @change="carregarImagem($event)">
                    </input-container-component>    
                </div>
            </template>

            <template v-slot:rodape>
                <button type="button" class="btn btn-primary" @click="salvar()">Salvar</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </template>
        </modal-component>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                urlBase: 'http://localhost:8000/api/v1/marca',
                nomeMarca: '',
                arquivoImagem: [],
                transacaoStatus: '',
                transacaoDetalhes: {},
                marcas: []
            }
        },
        computed: {
            token() {
                let cookies = document.cookie.split(';');
                
                let token = cookies.find(indice => {
                    return indice.startsWith('token=');
                });                

                token = token.split('=')[1];

                return 'Bearer ' + token;
            }
        },
        methods: {
            carregarImagem(event) {
                this.arquivoImagem = event.target.files;
            },
            carregarLista() {
                let config = {
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': this.token
                    }
                }

                axios.get(this.urlBase, config)
                    .then(response => {
                        this.marcas = response.data;
                    })
                    .catch(errors => {
                        console.log(errors);
                    });
            },            
            salvar() {
                let formData = new FormData();
                formData.append('nome', this.nomeMarca);
                formData.append('imagem', this.arquivoImagem[0]);

                let config = {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                        'Accept': 'application/json',
                        'Authorization': this.token
                    }
                }

                axios.post(this.urlBase, formData, config)
                    .then(response => {
                        this.transacaoStatus = 'adicionado';
                        this.transacaoDetalhes = {
                            mensagem: 'ID do Registro: ' + response.data.id
                        };
                    })
                    .catch(errors => {
                        this.transacaoStatus = 'erro';
                        this.transacaoDetalhes = {
                            mensagem: errors.response.data.message,
                            dados: errors.response.data.errors
                        };                        
                    });
            }
        },
        mounted() {
            this.carregarLista();
        }
    }
</script>
