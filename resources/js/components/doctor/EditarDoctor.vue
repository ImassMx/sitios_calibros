<template>
    <div class="container mt-4 h-100 d-flex justify-content-center align-items-center">
        <div class="row w-100">
            <div class="col-md-5 offset-md-3">
                <h3 class="card-title text-center">Editar Información</h3> 
                <form v-on:submit.prevent="updateDoctor()">
                    <div class="form-group mt-3">
                        <label for="username">Nombre</label>
                        <input type="text" class="form-control" id="username" placeholder="Ingresa tu nombre"
                            v-model="nombre">
                    </div>
                    <div class="form-group mt-3">
                        <label for="username">Apellidos</label>
                        <input type="text" class="form-control" id="username" placeholder="Ingresa tu Apellido"
                            v-model="apellido">
                    </div>
                    <div class="form-group mt-3">
                        <label for="username">Email</label>
                        <input type="text" class="form-control" id="username" placeholder="Ingrese su email" disabled
                            v-model="email">
                    </div>
                    <div class="form-group mt-3">
                        <label for="username">Cédula</label>
                        <input type="text" class="form-control" id="username" placeholder="Introduce tu N° de Cédula"
                            v-model="cedula">
                    </div>
                    <div class="form-group mt-3">
                        <label for="celular">Celular</label>
                        <input type="text" class="form-control" id="celular" placeholder="Introduce tu celular"
                            v-model="celular">
                    </div>
                    <button type="submit" class="btn btn-primary btn-block mt-4">Guardar</button>
                </form>
            </div>
        </div>
    </div>

</template>

<script>
export default {
    props: ["uuid"],
    data() {
        return {
            nombre: "",
            apellido: "",
            especialidad: "",
            email: "",
            cedula: "",
            celular: "",
        }
    }, created() {
        this.getInformation();
    }, methods: {
        async getInformation() {
            try {
                const { data } = await this.axios.get('/api/editar/doctor/' + this.uuid)
                this.nombre = data.nombres
                this.apellido = data.apellidos
                this.email = data.user.email
                this.cedula = data.cedula
                this.celular = data.user.celular
            } catch (error) {
                console.log(error)
            }
        },
        async updateDoctor() {
            try {
                const { data } = await axios.post('/api/update/doctor/' + this.uuid,{
                        nombre: this.nombre,
                        apellido: this.apellido,
                        email: this.email,
                        cedula: this.cedula,
                        celular: this.celular
                    })

                if (data.success) {
                    Swal.fire({
                        title: "Actualizado",
                        text: "Se actualizó correctamente",
                        icon: "success"
                    });
                }
            } catch (error) {
                console.log(error)
            }
        }
    }

}
</script>

<style></style>