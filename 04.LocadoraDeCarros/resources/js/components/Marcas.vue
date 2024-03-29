<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <card-component titulo="Busca de Marcas">
                    <template v-slot:conteudo>
                        <div class="form-row">
                            <div class="col mb-3">
                                <input-container-component id="inputId" id-help="idHelp" titulo="ID" texto-ajuda="Opcional. Informe o ID da Marca">
                                    <input type="number" id="inputId" class="form-control" aria-describedby="idHelp" placeholder="ID" v-model="busca.id">
                                </input-container-component>                                
                            </div>
                            <div class="col mb-3">
                                <input-container-component id="inputNome" id-help="nomeHelp" titulo="Nome" texto-ajuda="Opcional. Informe o Nome da Marca">
                                    <input type="text" class="form-control" id="inputNome" aria-describedby="nomeHelp" placeholder="Nome" v-model="busca.nome">
                                </input-container-component>                                
                            </div>                        
                        </div>
                    </template>
                    <template v-slot:rodape>
                        <button type="submit" class="btn btn-primary btn-sm float-end" @click="pesquisar()">Pesquisar</button>
                    </template>
                </card-component>

                <card-component titulo="Relação de Marcas">
                    <template v-slot:conteudo>
                        <table-component 
                            :titulos="{
                                id: { descricao: 'ID', tipo: 'texto' },
                                nome: { descricao: 'Nome', tipo: 'texto' },
                                imagem: { descricao: 'Imagem', tipo: 'imagem' },
                                created_at: { descricao: 'Data Inclusão', tipo: 'data' }
                            }" 
                            :dados="marcas.data"
                            :visualizar="{ visivel: true, dataToggle: 'modal', dataTarget: '#modalMarcaVisualizar' }"
                            :atualizar="{ visivel: true, dataToggle: 'modal', dataTarget: '#modalMarcaAtualizar' }"
                            :remover="{ visivel: true, dataToggle: 'modal', dataTarget: '#modalMarcaRemover' }"
                        ></table-component>
                    </template>
                    <template v-slot:rodape>
                        <dir class="row">
                            <div class="col-10">
                                <paginate-component>
                                    <li v-for="link, key in marcas.links" :key="key" @click="paginacao(link)" :class="link.active ? 'page-item active' : 'page-item'">
                                        <a v-html="link.label" class="page-link"></a>
                                    </li>
                                </paginate-component>
                            </div>
                            <div class="col">
                                <button type="button" class="btn btn-primary btn-sm float-end" data-bs-toggle="modal" data-bs-target="#modalMarca">Adicionar</button>                            
                            </div>                                                        
                        </dir>
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

        <modal-component id="modalMarcaVisualizar" titulo="Visualizar Marca">
            <template v-slot:conteudo>
                <input-container-component titulo="ID">
                    <input type="text" class="form-control" :value="$store.state.item.id" disabled>
                </input-container-component>
                <input-container-component titulo="Nome">
                    <input type="text" class="form-control" :value="$store.state.item.nome" disabled>
                </input-container-component>
                <input-container-component titulo="Data de Inclusão">
                    <input type="text" class="form-control" :value="$store.state.item.created_at" disabled>
                </input-container-component>                
                <input-container-component titulo="">
                    <img :src="'/storage/' + $store.state.item.imagem">
                </input-container-component>                
            </template>

            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </template>            
        </modal-component>

        <modal-component id="modalMarcaAtualizar" titulo="Atualizar Marca">
            <template v-slot:alertas>
                <alert-component tipo='success' titulo='Transação realizada com sucesso' :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'sucesso'"></alert-component>
                <alert-component tipo='danger' titulo='Erro na transação' :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'erro'"></alert-component>
            </template>

            <template v-slot:conteudo>
                <div class="form-group">
                    <input-container-component id="atualizarNome" id-help="atualizarNomeHelp" titulo="Nome" texto-ajuda="Informe o Nome da Marca">
                        <input type="text" class="form-control" id="atualizarNome" aria-describedby="atualizarNomeHelp" placeholder="Nome" v-model="$store.state.item.nome">
                    </input-container-component>

                    <input-container-component id="atualizarImagem" id-help="atualizarImagemHelp" titulo="Imagem" texto-ajuda="Selecione uma Imagem">
                        <input type="file" class="form-control-file" id="atualizarImagem" aria-describedby="atualizarImagemHelp" placeholder="Selecione uma Imagem" @change="carregarImagem($event)">
                    </input-container-component>    
                </div>
            </template>

            <template v-slot:rodape>
                <button type="button" class="btn btn-primary" @click="atualizar()">Atualizar</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </template>
        </modal-component>    

        <modal-component id="modalMarcaRemover" titulo="Remover Marca">
            <template v-slot:alertas>
                <alert-component tipo='success' titulo='Transação realizada com sucesso' :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'sucesso'"></alert-component>
                <alert-component tipo='danger' titulo='Erro na transação' :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'erro'"></alert-component>
            </template>

            <template v-slot:conteudo v-if="$store.state.transacao.status != 'sucesso'">
                <input-container-component titulo="ID">
                    <input type="text" class="form-control" :value="$store.state.item.id" disabled>
                </input-container-component>
                <input-container-component titulo="Nome">
                    <input type="text" class="form-control" :value="$store.state.item.nome" disabled>
                </input-container-component>                
            </template>

            <template v-slot:rodape>
                <button type="button" class="btn btn-danger" @click="remover()" v-if="$store.state.transacao.status != 'sucesso'">Remover</button>
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
                urlPaginacao: '',
                urlFiltro: '',
                nomeMarca: '',
                arquivoImagem: [],
                transacaoStatus: '',
                transacaoDetalhes: {},
                marcas: { data: [] },
                busca: { id: '', nome: '' }
            }
        },
        methods: {
            paginacao(link) {
                if (link.url) {
                    let url = link.url.split('?');
                    this.urlPaginacao = url[1];
                    this.carregarLista();
                }
            },
            pesquisar() {
                let filtro = '';

                for (let chave in this.busca) {
                    if (this.busca[chave]) {
                        filtro += chave + ':like:' + this.busca[chave] + ';';
                    }
                }

                filtro = filtro.substring(0, filtro.length - 1);

                this.urlFiltro = '';
                this.urlPaginacao = '';

                if (filtro != '') {
                    this.urlFiltro = '&filtro=' + filtro;
                }

                this.carregarLista();
            },
            carregarImagem(event) {
                this.arquivoImagem = event.target.files;
            },
            carregarLista() {
                let url = this.urlBase + '?' + this.urlPaginacao + this.urlFiltro;

                axios.get(url)
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
                        'Content-Type': 'multipart/form-data'
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
            },
            atualizar() {
                let url = this.urlBase + '/' + this.$store.state.item.id;

                let formData = new FormData();
                formData.append('_method', 'patch');
                formData.append('nome', this.$store.state.item.nome);

                if (this.arquivoImagem[0]) {
                    formData.append('imagem', this.arquivoImagem[0]); 
                }
                
                let config = {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }

                axios.post(url, formData, config)
                    .then(response => {
                        atualizarImagem.value = '';
                        this.$store.state.transacao.status = 'sucesso';
                        this.$store.state.transacao.mensagem = 'Marca atualizada com sucesso';
                        this.carregarLista();
                    })
                    .catch(errors => {
                        this.$store.state.transacao.status = 'erro';
                        this.$store.state.transacao.mensagem = errors.response.data.mensage;
                        this.$store.state.transacao.dados = errors.response.data.errors;
                    });
            },
            remover() {
                let url = this.urlBase + '/' + this.$store.state.item.id;

                console.log(url, this.$store.state.item.id);

                let formData = new FormData();
                formData.append('_method', 'delete');

                axios.post(url, formData)
                    .then(response => {
                        this.$store.state.transacao.status = 'sucesso';
                        this.$store.state.transacao.mensagem = response.data.msg;
                        this.carregarLista();
                    })
                    .catch(errors => {
                        this.$store.state.transacao.status = 'erro';
                        this.$store.state.transacao.mensagem = errors.response.data.erro;
                    });
            }
        },
        mounted() {
            this.carregarLista();
        }
    }
</script>
