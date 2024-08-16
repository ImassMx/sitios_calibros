<template>
    <div class="col-md-9 col-sm-12"> 
        <div class="table-responsive">
            <table class="table">
                <tbody>
                    <tr>
                        <td colspan="2">
                        </td>
                        <td>Precio</td>
                        <td></td>
                    </tr>
                    <tr v-for="pro in Products" :key="pro.id">
                        <td width="90px">
                            <img :src="pro.book.image" class="img-fluid rounded" alt="Libro"
                                style="max-width:90px">
                        </td>
                        <td>
                            <h5 class="fw-bold">{{ pro.book.name }}</h5>
                            <p class="fw-bold text-muted m-0 p-0">Autor: {{ pro.book.author }}</p>
                            <p class="text-muted m-0 p-0">Categoria: {{ pro.book.category.name }}</p>
                        </td>
                        <td class="fw-bold color-s">$ {{ pro.book.price}}</td>
                        <td>
                            <a href="#" @click="deleteCart(pro.id)" style="cursor:pointer !important"><img src="/img/delete.svg" class="img-fluid  mx-auto d-block" alt="Eliminar" style="width:25px"></a>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-end fw-bold">
                            Total
                        </td>
                        <td>
                            <h4 class="color-p fw-bold">$ {{ totalMount }}</h4>
                        </td>
                        <td></td>

                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-3 col-sm-12">
        <div class="card mb-3 p-3">
            <h5 class="fw-bold pb-2">Resumén de mi compra</h5>
            <p class="p-0 m-0 fw-bold mb-1">Libros a comprar: <span class="color-s">{{ cartCount }}</span></p>
            <p class="p-0 m-0 fw-bold mb-3">Total a pagar: <span class="color-s">$ {{ totalMount }} MNX</span></p>
            <a @click="processPayment()" v-if="cartCount > 0" class="btn  btn-sm text-center backg-p text-white" > Proceder al
                pago</a> 
        </div> 
    </div>
</template>

<script>
import { mapActions, mapState } from 'vuex'
import ShowBoton from '../ShowBoton.vue';
export default {
  components: { ShowBoton },
    props:["user"]
    ,created(){
        this.getInfoCart(this.user);
    }
    ,methods:{
        ...mapActions(['getInfoCart']),
        async deleteCart(id){
            try {
              await axios.post('/api/delete/product/'+id)
              this.getInfoCart(this.user)
              this.$store.dispatch('countCart',this.user)
            } catch (error) {
                console.log(error)
            }
        },
        async processPayment(){
            try {
              const {data} = await axios.post('/api/process/payment/'+this.user,{quantity:this.cartCount,price:this.totalMount})
              if(!data.error){
                window.open(data.url, "_blank");
              }
            } catch (error) {
                console.log(error)
            }
        }
    },computed:mapState(['Products','totalMount','totalPoint','cartCount'])

}
</script>

<style></style>