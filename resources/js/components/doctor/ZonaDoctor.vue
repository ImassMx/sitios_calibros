<template>
    <h1>DR. {{this.nombre}}</h1>
        <h4>Compartir acceso a paciente</h4>
    <div class="content-form">
        <form action="" v-on:submit.prevent="enviarMensaje()">
            <input type="text" v-model="numero" placeholder="Ingrese un número de celular" class="numero-cliente">
            <input type="submit" class="btn" value="Enviar SMS">
        </form>
    </div>
</template>

<script>
export default {
    data(){
        return{
            mensaje:'',
            numero:'',
            nombre:'',
            folio:''
        }
    },
    mounted(){
        this.obtenerFolio()
    },
    methods:{
       enviarMensaje()
       {
         axios.get("/enviar/sms/doctor/"+this.numero+"/"+this.folio)
         .then(res => {
            this.numero = ""
            Swal.fire("Correcto", "Se envio correctamente el mensaje", "success");
         })
       },
       obtenerFolio ()
       {
        const valores = window.location.search;
        const urlParams = new URLSearchParams(valores);
        var producto = urlParams.get("folio");
        this.folio = producto

         axios.get('/api/mostrar/nombre/doctor/'+producto)
         .then(res =>{
            this.nombre = `${res.data.nombres} ${res.data.apellidos}`
         })
        
       }
    }
}
</script>

<style scoped>
h1,h4{
    text-align: center;
}
.content-form{
    display: flex;
    justify-content: center;
}
.content-form form{
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

.btn{
    padding: .4rem .5rem;
    background: rgba(0, 0, 0, 0.0);
    border: 2px solid #056743;
    color: #056743;
    cursor: pointer;
    border-radius: 5px;
    transition: all .4s;
}
.btn:hover{
    background: #056743;
    color: white;
}

.numero-cliente{
    padding: .4rem .5rem;
}
</style>