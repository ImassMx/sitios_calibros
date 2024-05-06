<template>
        <li>
                <a href="/marketplace/carrito" class="p-2 fw-bold backg-p text-white" style="border-radius:26px">
                        <img src="/img/shop-b.svg" alt="buscar" width="26">
                        <span>{{ cartCount }}</span>
                </a>
        </li>
</template>

<script>
import { mapActions, mapState } from 'vuex'
export default {
        props: ["user"],
        created() {
                this.countCart(this.user)
        }, methods: {   
                ...mapActions(['countCart'])
        },computed:mapState(["cartCount"])
        
}
</script>

<style></style>