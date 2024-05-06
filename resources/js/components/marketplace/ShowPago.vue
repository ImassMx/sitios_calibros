<template>
    <div class="container bg-white mt-3">
        <div class="row pt-3 justify-content-center">
            <div class="col-md-12 col-sm-12">
                <h1><img src="/img/money.svg" alt="pago" width="50"> Finalizar compra</h1>
            </div>
            <div class="col-md-9 col-sm-12 pt-2">
                <div class="row">
                    <div class="col-md-10 col-sm-12">
                        <form class="was-validation">
                            <div class="row">
                                <div class="col-md-10 col-sm-12">
                                    <h5 class="fw-bold pb-2">Seleccione forma de pago</h5>
                                    <div class="border border-1 mb-2 p-2" style="border-radius:15px">
                                        <div class="form-check ">
                                            <input type="radio" class="form-check-input" id="validationFormCheck2"
                                                name="radio-stacked" required>
                                            <label class="form-check-label" for="validationFormCheck2"><img
                                                    src="/img/TDC.svg" alt="pago" width="30"> Tarjeta
                                                Débito</label>
                                        </div>
                                    </div>
                                    <div class="border border-1 mb-2 p-2" style="border-radius:15px">
                                        <div class="form-check ">
                                            <input type="radio" class="form-check-input" id="validationFormCheck3"
                                                name="radio-stacked" required>
                                            <label class="form-check-label" for="validationFormCheck3"><img
                                                    src="/img/TDC.svg" alt="pago" width="30"> Tarjeta
                                                Crédito
                                            </label>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="row justify-content-center pt-3">
                                <div class="col-md-12 col-sm-12 p-2">
                                    <h5 class="fw-bold">Datos titular de la tarjeta</h5>
                                </div>
                                <div class="col-md-4 col-sm-12 p-2">
                                    <label for="validationCustom01" class="form-label">Nombre</label>
                                    <input type="text" class="form-control" placeholder="Escribir" required>
                                </div>
                                <div class="col-md-4 col-sm-12 p-2">
                                    <label for="validationCustom02" class="form-label">Apellido paterno</label>
                                    <input type="text" class="form-control" placeholder="Escribir" required>
                                </div>
                                <div class="col-md-4 col-sm-12 p-2">
                                    <label for="validationCustom02" class="form-label">Apellido materno</label>
                                    <input type="text" class="form-control" placeholder="Escribir" required>
                                </div>
                                <div class="col-md-6 col-sm-12 p-2">
                                    <label for="fecha" class="form-label">Número de la tarjeta</label>
                                    <input type="text" name="fecha" id="fecha" class="form-control"
                                        placeholder="0000-0000-0000-0000">
                                </div>
                                <div class="col-md-2 col-sm-12 p-2">
                                    <label for="fecha" class="form-label">Mes</label>
                                    <input type="text" name="fecha" id="fecha" class="form-control">
                                </div>
                                <div class="col-md-2 col-sm-12 p-2">
                                    <label for="fecha" class="form-label">Año</label>
                                    <input type="text" name="fecha" id="fecha" class="form-control">
                                </div>
                                <div class="col-md-3 col-sm-12 p-2">
                                    <label for="validationCustom05" class="form-label">CVV</label>
                                    <input type="password" class="form-control" id="validationCustom05"
                                        placeholder="000" required>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-12 pt-2">
                <div class="card mb-3 p-3">
                    <img src="/img/logo.jpg" alt="" class="mx-auto d-block mb-3" width="145">
                    <h5 class="fw-bold">Resumén de mi compra</h5>
                    <p class="color-s fw-bold m-0 p-0 text-center">Total a pagar:<span class="color-s"> $
                            {{ totalMount }}</span></p>
                    <hr>
                    <p class="p-0 m-0 fw-bold">Libros: <span class="color-s"> {{ cartCount }}</span></p>
                    <p class="p-0 m-0 fw-bold">Total puntos: <span class="color-s"> {{ totalPoint }}</span></p>
                    <a href="/marketplace/pasarela" class="btn w-100 mt-3 backg-p text-white">Pagar</a>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapState, mapActions } from 'vuex'

export default {
    props: ["user"],
    data() {
        return {

        }
    },
    created() {

        this.getInfoCart(this.user)
    },
    methods: {
        ...mapActions(['getInfoCart'])
    },
    computed: mapState(['totalMount', 'totalPoint', 'cartCount'])
}
</script>

<style></style>