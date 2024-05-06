<template>
  <div class="container px-4">
    <h1 class="mt-4">Editar Categoria</h1>
    <div class="m-5 col-lg-4 col-md-8">
      <form class="" v-on:submit.prevent="updateCategories">
        <div class="form-group mb-3">
          <label for="exampleInputEmail1" class="mb-1">Nombre</label>
          <input type="text" class="form-control" id="exampleInputEmail1"
            placeholder="Ingresa el nombre de la clasificación" aria-describedby="emailHelp" v-model="nombre" />
          <div v-if="errors && errors.nombre">
            <p class="errors">{{ errors.nombre[0] }}</p>
          </div>
        </div>

        <button type="submit" class="btn btn-dark mt-3">Actualizar</button>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      id: this.$route.params.id,
      nombre: '',
      errors: {}
    }
  },
  mounted() {
    this.traerClasificaicon()
  },
  methods: {
    traerClasificaicon() {
      axios.get('/api/categories/edit/' + this.id)
        .then(response => {
          this.nombre = response.data.name
        })
    },
    updateCategories() {
      axios.post('/api/categories/update/' + this.id, { nombre: this.nombre })
        .then(response => {
          if (!response.data.error) {
            this.showAlert()
            this.$router.push({ name: 'show.categories' })
          }
        })
        .catch((error) => {
          if (error.response.status === 422) {
            this.errors = error.response.data.errors;
          }
        })
    },
    showAlert() {
      Swal.fire("Correcto", "Editado correctamente", "success");
    }
  }
}
</script>

<style></style>