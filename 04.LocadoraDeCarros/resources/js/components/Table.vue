<template>
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col" v-for="titulo, indice in titulos" :key="indice">{{ titulo.toUpperCase() }}</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="obj in dados" :key="obj.id">
                <td v-for="valor, chave in obj" :key="chave">
                    <span v-if="titulos.includes(chave)">
                        <span v-if="chave == 'imagem'">
                            <img :src="'/storage/' + valor" width="30" height="30">
                        </span>
                        <span v-else>
                            {{ valor }}
                        </span>                        
                    </span>
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script>
    export default { 
        props: ['titulos', 'dados']
    }
</script>
