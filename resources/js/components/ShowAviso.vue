<template>
     <div class="col-md-9 col-sm-12 text-center pt-3"> 
            <a href="/marketplace" class="btn-custom-nuevo" style="width:120px">Finalizar</a>
            <p></p>
            <button type="button" class="button-factura"  data-bs-toggle="modal" data-bs-target="#exampleModal">¿Cómo solicitar mi factura?</button>
               
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Proceso de facturación</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <img src="/img/facturacion_img.jpg" alt="Facturacion" class="img-fluid"> 
                    </div> 
                    </div>
                </div>
            </div>
    </div>
   
</template>

<script>
export default {
    data() {
        return {
            isChecked: false
        }
    },
    methods:{
        facturacion(){
            this.isChecked=true
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
.button-factura{
    border: 1px solid #fff;
    background: #fff;
}
</style>