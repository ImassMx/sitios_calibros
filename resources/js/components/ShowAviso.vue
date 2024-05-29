<template>
    <div class="content-factura">
        <div class="content-factura-quest text-center">
            <h2>¿Deseas factura?</h2>
            <div class="content-check">
                <input type="checkbox" id="checkbox" v-model="isChecked" @change="toggleMessage">
            <label for="checkbox">Sí</label>
            </div>
        </div>

        <div v-if="isChecked" class="container-facturacion">
            <img src="/img/facturacion_img.jpg" alt="" srcset="" class="img-facturacion">
        </div>
    </div>
    <a href="/marketplace" class="btn-custom-nuevo">Regresar a tienda</a>
</template>

<script>
export default {
    data() {
        return {
            isChecked: false
        }
    }
}
</script>

<style>
.content-factura {
    width: 800px;
}
.content-check{
    display: flex;
    gap: .5rem;
}
.container-facturacion{
    width: 100%;
    display: flex;
    justify-content: center;
}
.img-facturacion{
    width: 700px;
}
</style>