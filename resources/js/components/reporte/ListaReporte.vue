<template>
  <div class="container-fluid px-4">
    <h1 class="mt-4 mb-3">Reporte Pacientes</h1>

    <a href="/export/cliente" class="btn btn-outline-success mb-3">Exportar Reporte</a>
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
              @keyup="buscarCliente"
            />
          </div>
          <table class="table">
            <thead>
              <tr>
                <th scope="col">ID</th>
                <th scope="col">NOMBRE</th>
                <th scope="col">FOLIO</th>
                <th scope="col">CELULAR</th>
                <th scope="col">CP.</th>
                <th scope="col">CIUDAD</th>
                <th scope="col">F. REGISTRO</th>
                <th scope="col">F. DESCARGA</th>
                <th scope="col">LIBRO DESCARGADO</th>
                <th scope="col">DOCTOR</th>
                <th scope="col">DESCARGAS</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="client in clientes.data" :key="client.id">
                <th scope="row">{{ client.id }}</th>
                <td>{{ client.user.name }}</td>
                <td>{{ client.folio }}</td>
                <td>{{ client.user.celular }}</td>
                <td>{{ client.codigo_postal }}</td>
                <td>{{ client.ciudad }}</td>
                <td>{{ client.created_at.slice(0,10) }}</td>
                <td>{{ client.fecha_descarga }}</td>
                <td v-for="lib in client.libro" :key="lib.id">
                  {{ lib.nombre }}
                </td>
                <td>{{ client.nombre_doctor }}</td>
                <td>{{ client.descargas }}</td>
              </tr>
            </tbody>
          </table>
          <Pagination
            :data="clientes"
            @pagination-change-page="traerClientes"
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
      clientes: {},
      buscador: "",
      timeBuscador: "",
    };
  },
  mounted() {
    this.traerClientes();
  },
  methods: {
    traerClientes(page = 1) {
      axios
        .get("/api/show/clientes?page=" + page, {
          params: { buscador: this.buscador },
        })
        .then((res) => {
          this.clientes = res.data;
          console.log(res.data);
        });
    },
    buscarCliente() {
      clearTimeout(this.timeBuscador);
      this.timeBuscador = setTimeout(this.traerClientes, 360);
    },
  },
};
</script>

<style>
</style>