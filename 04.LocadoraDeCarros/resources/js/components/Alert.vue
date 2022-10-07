<template>
    <div :class="estilo" role="alert">
        {{ titulo }}        
        <span v-if="detalhes.data.message">
            <hr>
            {{ detalhes.data.message }}
        </span>        
        <br>
        <ul v-if="detalhes.data.errors">
            <li v-for="error, key in detalhes.data.errors" :key="key">
                {{ error[0] }}
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
