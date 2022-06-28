<template>
  <div class="container px-4">
    <h1 class="mt-4">Crear Clasificación</h1>
    <div class="m-5 col-lg-4 col-md-8">
      <form class="" v-on:submit.prevent="saveClasificacion">
        <div class="form-group mb-3">
          <label for="exampleInputEmail1" class="mb-1">Nombre</label>
          <input
            type="text"
            class="form-control"
            id="exampleInputEmail1"
            placeholder="Ingresa el nombre de la clasificación"
            aria-describedby="emailHelp"
            v-model="nombre"
          />
          <div v-if="errors && errors.nombre">
            <p class="errors">{{ errors.nombre[0] }}</p>
          </div>
        </div>

        <button type="submit" class="btn btn-dark mt-3">Agregar</button>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      nombre: null,
      errors: {},
    };
  },
  methods: {
    saveClasificacion() {
      axios
        .post("/clasificacion/create", { nombre: this.nombre })
        .then((response) => {
          this.nombre = "";
          this.showAlert()
        })
        .catch((error) => {
          if (error.response.status === 422) {
            this.errors = error.response.data.errors;
          }
        });
    },
    showAlert() {
      Swal.fire("Correcto", "Clasificación creada correctamente", "success");
    },
  },
};
</script>

<style>
.errors {
  margin-top: 0.5rem;
  color: red;
  font-weight: bold;
}
</style>