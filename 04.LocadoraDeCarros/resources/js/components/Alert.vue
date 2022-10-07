<template>
    <div :class="estilo" role="alert">
        {{ titulo }}        
        <hr>
        {{ detalhes.mensagem }}        
        <ul v-if="detalhes.dados">
            <li v-for="dado, key in detalhes.dados" :key="key">
                {{ dado[0] }}
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        props: ['tipo', 'titulo', 'detalhes'],
        computed: {
            estilo() {
                return 'alert alert-' + this.tipo;
            }
        }
    }
</script>
