<template>
  <div class="container-fluid px-4">
    <h1 class="mt-4 mb-3">Reporte de Pacientes</h1>

    <div class="row mb-3">
      <div class="col-2 col-md-3 d-flex justify-content-start align-items-end">
        <a :href="`/export/cliente?starDate=${startDate}&endDate=${endDate}`" class="btn btn-outline-success ">Exportar Reporte</a>
      </div>
      <div class="col-2 col-md-3">
        <label for="startDate" class="form-label">Fecha de Inicio</label>
        <input type="date" class="form-control" id="startDate" name="startDate" v-model="startDate" @change="updateStartDate">
      </div>
      <div class="col-2 col-md-3">
        <label for="endDate" class="form-label">Fecha de Fin</label>
        <input type="date" class="form-control" id="endDate" name="endDate" v-model="endDate" @change="updateEndDate">
      </div>
      <div class="col-2 col-md-3 d-flex justify-content-start align-items-end">
        <a @click="clearFields" class="btn btn-outline-success ">Limpiar</a>
      </div>
    </div>
    <div>
      <div class="card mb-4">
        <div class="card-body">
          <div class="form-group col-md-4 mb-3">
            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
              placeholder="Buscar" v-model="buscador" @keyup="buscarCliente" />
          </div>
          <div class="table-responsive">
            <table class="table table-sm">
              <thead>
                <tr>
                  <th scope="col">FOLIO MÉDICO</th>
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
                  <td>{{ client.user.email }}</td>
                  <td>{{ client.user.celular }}</td>
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
      startDate :"",
      endDate : ""
    };
  },
  mounted() {
    this.traerClientes();
  },
  methods: {
    traerClientes(page = 1) {
      axios
        .get("/api/show/clientes?page=" + page, {
          params: { buscador: this.buscador , startDate : this.startDate,endDate: this.endDate },
        })
        .then((res) => {
          this.clientes = res.data;
        });
    },
    buscarCliente() {
      clearTimeout(this.timeBuscador);
      this.timeBuscador = setTimeout(this.traerClientes, 360);
    },
    updateStartDate(){
      this.traerClientes();
    },
    updateEndDate(){
      this.traerClientes();
    },clearFields(){
      this.endDate = ''
      this.startDate = ''
      this.traerClientes()
    }
  },
};
</script>

<style></style>