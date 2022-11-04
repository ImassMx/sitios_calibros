<template>
  <div class="container-fluid px-4">
    <h1 class="mt-4 mb-3">Listado de Clasificaciones</h1>
    <div>
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
              @keyup="buscarClasificacion"
            />
          </div>

          <table class="table">
            <thead>
              <tr>
                <th class="text-center" scope="col">ID</th>
                <th class="text-center" scope="col">NOMBRE</th>
                <th class="text-center" scope="col">ACCION</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="cla in clasificacion.data" :key="cla.id">
                <th scope="row cla-id">{{ cla.id }}</th>
                <td class="cla-nombre">{{ cla.nombre }}</td>
                <td class="d-flex justify-content-center gap-2">
                  <router-link :to="`/admin/editar-clasificacion/${cla.id}`" class="btn btn-outline-primary"
                    >Editar</router-link
                  >
                  <a @click="alerta(cla.id)" class="btn btn-outline-danger">
                    Eliminar
                  </a>
                </td>
              </tr>
            </tbody>
          </table>
          <Pagination
            :data="clasificacion"
            @pagination-change-page="traerClasificacion"
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
      clasificacion: {},
      buscador: "",
      timeBuscador: "",
    };
  },
  mounted() {
    this.traerClasificacion();
  },
  methods: {
    traerClasificacion(page = 1) {
      axios
        .get("/api/clasificacion?page="+page ,{params:{buscador:this.buscador}})
        .then((response) => {
          this.clasificacion = response.data;
        })
        .catch((error) => console.log(error));
    },
      buscarClasificacion(){
          clearTimeout(this.timeBuscador)
          this.timeBuscador = setTimeout(this.traerClasificacion,360)
      },
      alerta(id) {
      Swal.fire({
        title: "¿Esta seguro que desea eliminar?",
        text: "Puede que algunos libros queden sin clasificación.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si",
        cancelButtonText: "Cancelar",
      }).then((result) => {
        if (result.isConfirmed) {
          this.axios.delete('/eleminiar-clasificacion/'+id)
         .then( response => {
           this.traerClasificacion()
          Swal.fire("Eliminado", "Se elimino correctamente.", "success")
         })
         .catch(error =>{
            if (error.response.status === 500) {
           this.errorAlert()
          }
         })
          ;
        }
      });
    },
    errorAlert()
    {
      Swal.fire({
  icon: 'error',
  title: 'No se puede eliminar',
  text: 'La clasificacion esta ligada a un libro',
})
    }
  },
};
</script>

<style scoped>
.cla-nombre,.cla-id{
  text-align: center !important;
}
</style>