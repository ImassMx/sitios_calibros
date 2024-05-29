<template>
  <div class="container-fluid px-4">
    <h1 class="mt-4 mb-3">Reporte de Pacientes</h1>

    <a href="/export/cliente" class="btn btn-outline-success mb-3">Exportar Reporte</a>
    <div>
      <div class="card mb-4">
        <div class="card-body">
          <div class="form-group col-md-4 mb-3">
            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
              placeholder="Buscar" v-model="buscador" @keyup="buscarCliente" />
          </div>
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">FOLIO</th>
                  <th scope="col">NOMBRE COMPLETO</th>
                  <th scope="col">EMAIL</th>
                  <th scope="col">CELULAR</th>
                  <th scope="col">CÓDIGO POSTAL</th>
                  <th scope="col">ALCALDIA</th>
                  <th scope="col">CIUDAD</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="client in clientes.data" :key="client.id">
                  <td>{{ client.folio }}</td>
                  <td>{{ client.user.name }}</td>
                  <td>{{ client.user.celular }}</td>
                  <td>{{ client.user.email }}</td>
                  <td>{{ client.codigo_postal }}</td>
                  <td>{{ client.sepomex?.d_mnpio }}</td>
                  <td>{{ client.sepomex?.d_ciudad }}</td>
                </tr>
              </tbody>
            </table>
          </div>
          <Pagination :data="clientes" @pagination-change-page="traerClientes" class="d-flex justify-content-center" />
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
        });
    },
    buscarCliente() {
      clearTimeout(this.timeBuscador);
      this.timeBuscador = setTimeout(this.traerClientes, 360);
    },
  },
};
</script>

<style></style>