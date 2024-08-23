<template>
    <div class="card mb-3 p-3 text-center" v-if="isBuy !== true">
        <h5>Adquiere <span class="fw-bold color-p">{{ name }}</span></h5>
        <button @click="comprarBook()" class="btn  btn-sm text-center backg-p text-white"> Comprar ahora</button>
        <button @click="addToBook()" class="btn btn-outline-success btn-sm text-center "><img src="/img/shop.svg" alt="buscar" width="20">
            Añadir a carrito</button>
    </div>
</template>

<script>
export default {
        props:["name","uuid","user"],
        data(){
            return{
                isBuy:true
            }
        },
        async created(){
            const {data} = await axios.get('/api/validate/buy/book',{params: {book : this.uuid,user : this.user}})
            this.isBuy = data
        },  
        methods:{
            addToBook() {
            this.$store.dispatch('addToCart', { uuid: this.uuid, user: this.user })
            },async comprarBook(){
                try {
                    await axios.post('/api/add/product/' + this.uuid, { user: this.user })
                        window.location.href = '/marketplace/carrito'
                } catch (error) {
                    window.location.href = '/login/doctor'
                    console.log(error)
                }
            }
        }
}
</script>

<style>

</style>