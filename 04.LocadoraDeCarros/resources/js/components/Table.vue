<template>
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col" v-for="titulo, chave in titulos" :key="chave">{{ titulo.descricao }}</th>
                <th v-if="visualizar.visivel || atualizar.visivel || remover.visivel"></th>
            </tr>
        </thead>
        <tbody>       
            <tr v-for="obj, chave in dadosFiltrados" :key="chave">
                <td v-for="valor, chaveValor in obj" :key="chaveValor">
                    <span v-if="titulos[chaveValor].tipo == 'imagem'">
                        <img :src="'/storage/' + valor" width="30" height="30">
                    </span>
                    <span v-else-if="titulos[chaveValor].tipo == 'data'">
                        {{ formatarDataHora(valor) }}
                    </span>
                    <span v-else>
                        {{ valor }}
                    </span>
                </td>
                <td v-if="visualizar.visivel || atualizar.visivel || remover.visivel">
                    <button v-if="visualizar.visivel" class="btn btn-outline-primary btn-sm" :data-bs-toggle="visualizar.dataToggle" :data-bs-target="visualizar.dataTarget" @click="setStore(obj)">Visualizar</button>
                    <button v-if="atualizar.visivel" class="btn btn-outline-primary btn-sm" :data-bs-toggle="atualizar.dataToggle" :data-bs-target="atualizar.dataTarget" @click="setStore(obj)">Atualizar</button>
                    <button v-if="remover.visivel" class="btn btn-outline-danger btn-sm" :data-bs-toggle="remover.dataToggle" :data-bs-target="remover.dataTarget" @click="setStore(obj)">Remover</button>
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script>
    export default { 
        props: ['titulos', 'dados', 'visualizar', 'atualizar', 'remover'],
        methods: {
            setStore(obj) {
                this.$store.state.item = obj;
                this.$store.state.transacao.status = '';
                this.$store.state.transacao.mensagem = '';
                this.$store.state.transacao.dados = '';
            },
            formatarDataHora(dataHora) {
                if (!dataHora) {
                    return '';
                }

                return new Date(dataHora).toLocaleString('br');
            }
        },
        computed: {
            dadosFiltrados() {
                let campos = Object.keys(this.titulos);
                let dados = [];

                this.dados.map((item, chave) => {
                    let itemFiltrado = {};

                    campos.forEach(campo => {
                        itemFiltrado[campo] = item[campo];                        
                    });

                    dados.push(itemFiltrado)                    
                });

                return dados;
            }
        }
    }
</script>
