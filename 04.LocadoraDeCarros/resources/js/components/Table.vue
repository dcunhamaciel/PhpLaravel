<template>
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col" v-for="titulo, chave in titulos" :key="chave">{{ titulo.descricao }}</th>
            </tr>
        </thead>
        <tbody>       
            <tr v-for="obj, chave in dadosFiltrados" :key="chave">
                <td v-for="valor, chaveValor in obj" :key="chaveValor">
                    <span v-if="titulos[chaveValor].tipo == 'imagem'">
                        <img :src="'/storage/' + valor" width="30" height="30">
                    </span>
                    <span v-else-if="titulos[chaveValor].tipo == 'data'">
                        ... {{ valor }}
                    </span>
                    <span v-else>
                        {{ valor }}
                    </span>
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script>
    export default { 
        props: ['titulos', 'dados'],
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
