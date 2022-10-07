<template>
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col" v-for="titulo, indice in titulos" :key="indice">{{ titulo }}</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="dado in dados" :key="dado.id">
                <th scope="row">{{ dado.id }}</th>
                <td>{{ dado.nome }}</td>
                <td><img :src="'/storage/' + dado.imagem" width="30" height="30"></td>
            </tr>
        </tbody>
    </table>
</template>

<script>
    export default { 
        props: ['titulos', 'dados']
    }
</script>
