<template>
  <div class="container-fluid px-4">
    <h1 class="mt-4 mb-3">Listar Libros</h1>
    <div>
      <a href="/export/book" class="btn btn-outline-success mb-3"
        >Exportar Excel</a
      >
      <div class="card mb-4">
        <div class="card-body">
          <div class="form-group col-md-4 mb-3">
            <input
              type="text"
              class="form-control"
              id="exampleInputEmail1"
              aria-describedby="emailHelp"
              placeholder="Buscar"
              v-model="buscador"
              @keyup="buscarLibros"
            />
          </div>

          <table class="table"> 
            <thead>
              <tr>
                <th class="text-center" scope="col">ID</th>
                <th class="text-center" scope="col">NOMBRE</th>
                <th class="text-center" scope="col">DESCRIPCION</th>
                <th class="text-center" scope="col">IMAGEN</th>
                <th class="text-center" scope="col">ESTADO</th>
                <th class="text-center" scope="col">N° DESCARGAS</th>
                <th class="text-center" scope="col">ACCION</th>
              </tr>
            </thead>
            <tbody v-for="lib in Libros.data" :key="lib.id">
              <tr>
                <th scope="row">{{ lib.id }}</th>
                <td>{{ lib.nombre }}</td>
                <td class="col-sm-3">
                  {{ lib.descripcion.substr(0, 100) }} ...
                </td>
                <td>
                  <img :src="`portada/${lib.portada}`" alt="" class="img" />
                </td>
                <!--    <td>{{activo}}</td> -->
                <div v-if="lib.estado === 1">
                  <td>Activo</td>
                </div>
                <div v-else>
                  <td>Inactivo</td>
                </div>
                <th class="text-center">{{ lib.descargas }}</th>
                <td class="d-flex justify-content-center gap-2">
                  <router-link
                    :to="`/admin/editar/${lib.id}`"
                    class="btn btn-outline-primary"
                    >Editar</router-link
                  >
                  <a
                    @click="desactivar(lib.id)"
                    class="btn btn-outline-secondary"
                    v-if="lib.estado === 1"
                  >
                    Desactivar
                  </a>
                  <a
                    @click="activar(lib.id)"
                    class="btn btn-outline-success"
                    v-if="lib.estado === 2"
                    >Activar</a
                  >
                  <a @click="alerta(lib.id)" class="btn btn-outline-danger"
                    ><svg
                      xmlns="http://www.w3.org/2000/svg"
                      class="h-6 w-6"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke="currentColor"
                      stroke-width="2"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                      /></svg
                  ></a>
                </td>
              </tr>
            </tbody>
          </table>
          <Pagination
            :data="Libros"
            @pagination-change-page="traerLibros"
            class="d-flex justify-content-center"
          />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      Libros: {},
      id: null,
      nombre: null,
      descripcion: null,
      activo: "Activo",
      buscador: "",
      timeBuscador: "",
    };
  },
  mounted() {
    this.traerLibros();
  },
  methods: {
    traerLibros(page = 1) {
      axios
        .get("/api/book?page=" + page, { params: { buscador: this.buscador } })
        .then((response) => {
          this.Libros = response.data;
          /* console.log(this.Libros) */
        })
        .catch((error) => {
          console.log(error);
        });
    },
    desactivar(id) {
      axios.post("/des/" + id, { id: this.id }).then((response) => {
        this.traerLibros();
      });
    },
    activar(id) {
      axios.post("/act/" + id, { id: this.id }).then((response) => {
        this.traerLibros();
      });
    },
    buscarLibros() {
      clearTimeout(this.timeBuscador);
      this.timeBuscador = setTimeout(this.traerLibros, 360);
    },
    alerta(id) {
      Swal.fire({
        title: "¿Esta seguro que desea eliminar?",
        text: "Despues de eliminar ya no se puede revertir",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si",
      }).then((result) => {
        if (result.isConfirmed) {
          this.axios
            .delete("/eliminar-libros/" + id)
            .then((response) => {
              this.traerLibros();
              Swal.fire("Eliminado", "Se elimino correctamente.", "success");
            })
            .catch((error) => {
              if (error.response.status === 500) {
                this.errorAlert();
              }
            });
        }
      });
    },
    errorAlert() {
      Swal.fire({
        icon: "error",
        title: "No se puede eliminar",
        text: "El libro esta relacionado a una liga",
      });
    },
  },
};
</script>

<style scoped>
.img {
  width: 4.5rem;
}

a svg {
  width: 1.5rem;
}
</style>