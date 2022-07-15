<template>
  <div class="container-fluid px-4">
    <h1 class="mt-4 mb-3">Listar Ligas</h1>
    <div>
      <div class="card mb-4">
        <div class="card-body">
          <table class="table">
            <thead>
              <tr>
                <th class="text-center" scope="col">ID</th>
                <th class="text-center" scope="col">NOMBRE</th>
                <th class="text-center" scope="col">URL</th>
                <th class="text-center" scope="col">ACCION</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="liga in Ligas.data" :key="liga.id">
                <th scope="row" v-if="liga.estado === 1">{{ liga.id }}</th>
                <td class="nombre_liga" v-if="liga.estado === 1">
                  {{ liga.nombre }}
                </td>
                <td class="td-btn" v-if="liga.estado === 1">
                  <input
                    :id="liga.slug"
                    type="hidden"
                    :value="`${this.dominio}/registrar/doctor?slug_id=${liga.id}`"
                  />
                  <button
                    class="btn btn-outline-success"
                    @click="copiar(liga.slug)"
                  >
                    Copiar URL
                  </button>

                  <a
                    @click="donwload(liga.codigo_qr)"
                    class="btn btn-outline-success qr"
                    >Descargar QR</a
                  >
                </td>

                <td
                  class="d-flex justify-content-center flex-row gap-2"
                  v-if="liga.estado === 1"
                >
                  <router-link
                    :to="`/admin/editar-liga/${liga.id}`"
                    class="btn btn-outline-primary"
                    >Editar</router-link
                  >

                  <a @click="alerta(liga.id)" class="btn btn-outline-danger">
                    Eliminar
                  </a>
                </td>
              </tr>
            </tbody>
          </table>
          <Pagination
            :data="Ligas"
            @pagination-change-page="traerLigas"
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
      Ligas: {},
      dominio: document.domain,
      url: "",
    };
  },
  mounted() {
    this.traerLigas();
  },
  methods: {
    traerLigas(page = 1) {
      axios.get("/api/ligas?page=" + page).then((response) => {
        console.log(response.data);
        this.Ligas = response.data;
      });
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
            .post("/delete-liga/" + id)
            .then((response) => this.traerLigas());
          Swal.fire("Eliminado", "Se elimino correctamente.", "success");
        }
      });
    },
    copiar(id_elemento) {
      var aux = document.createElement("input");
      aux.setAttribute("value", document.getElementById(id_elemento).value);
      document.body.appendChild(aux);
      aux.select();
      document.execCommand("copy");
      document.body.removeChild(aux);
      this.mensajeCopiado();
    },
    mensajeCopiado() {
      Swal.fire({
        position: "top-end",
        icon: "success",
        title: "La liga se copio correctamente",
        showConfirmButton: false,
        timer: 500,
      });
    },
    donwload(image)
    {
      axios.get("/download/qr?image="+image, {responseType: 'blob'})
                .then(response => {
                   const url = window.URL.createObjectURL(new Blob([response.data]));
                  const link = document.createElement('a');
                  link.href = url;
                  link.setAttribute('download', image);
                  document.body.appendChild(link);
                  link.click();
                })
                .catch(e => {
                console.log(e);
                });
    }
  },
};
</script>

<style scoped>
.mensaje {
  color: red;
  font-weight: 700;
  margin-left: 0.5rem;
}
.qr {
  margin-left: 1rem;
}

.nombre_liga {
  text-align: center;
}
.td-btn{
  text-align: center;
}
</style>