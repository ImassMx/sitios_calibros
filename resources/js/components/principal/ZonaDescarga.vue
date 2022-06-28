<template>
 <div class="content-descargas">
            <h2>Hola Mundo</h2>
            <div class="cuerpo-descargas">
                <div class="image">
                    <img src="" alt="">
                </div>
                <div class="descripcion">
                    <p>Descripcion</p>
           
                    <a href="" id="descargar-libro" download="">Descargar</a>
                </div>
            </div>
            <hr>
        </div>
</template>

<script>
export default {
    data(){
        return{
            Libro:{}
        }
    },
    mounted(){

    },
    methods:{
        obtenerLibro(){
            axios.get('/api/libro')
            .then(response => {
                this.Libro = response.data
                console.log(this.Libro)
            })
            .catch(error => console.log(error))
        }
    }

}
</script>

<style>

</style>