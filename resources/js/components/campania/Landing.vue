<template>
        <div class="col-md-10 col-sm-12 text-center mb-0">
        <a @click="clicAcceder()" style="cursor: pointer;">
            <img class="img-fluid" src="bienvenida/img5.jpg" alt="Landing a Medicos_Abril24">
        </a>
    </div>
</template>

<script>
export default {
    async mounted(){
        await axios.get('/api/save/campania/landing')
    },methods:{
        async clicAcceder(){
            await axios.get('/api/clic/acceder/landing')
            window.location.href = '/login/doctor';

        }
    }
}
</script>

<style>

</style>