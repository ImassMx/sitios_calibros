<template>
    <div class="content-factura">
        <div class="content-factura-quest">
            <h4>¿Deseas factura?</h4>
            <div class="content-check">
                <input type="checkbox" id="checkbox" v-model="isChecked" @change="toggleMessage">
            <label for="checkbox">Sí</label>
            </div>
        </div>

        <div v-if="isChecked">
            <p>Para facturar, favor de enviar un correo al siguiente email.</p>
            <p><b>facturas@vistobuenoeditoreas.com.mx.</b></p>
            <p>Por disposiciones fiscales, la facturación debe hacerse el mismo mes de la compra</p>
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
</style>