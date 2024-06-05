<template>
  <div class="container-fluid px-4">
    <h1 class="mt-4 mb-3">Reporte de médicos</h1>
    <div class="row mb-3">
            <div class="col-2 col-md-3 d-flex justify-content-start align-items-end">
                <a :href="`/export/doctor?starDate=${startDate}&endDate=${endDate}`"
                    class="btn btn-outline-success ">Exportar Reporte</a>
            </div>
            <div class="col-2 col-md-3">
                <label for="startDate" class="form-label">Fecha de Inicio</label>
                <input type="date" class="form-control" id="startDate" name="startDate" v-model="startDate"
                    @change="updateStartDate">
            </div>
            <div class="col-2 col-md-3">
                <label for="endDate" class="form-label">Fecha de Fin</label>
                <input type="date" class="form-control" id="endDate" name="endDate" v-model="endDate"
                    @change="updateEndDate">
            </div>
            <div class="col-2 col-md-3 d-flex justify-content-start align-items-end">
                <a @click="clearFields" class="btn btn-outline-success ">Limpiar</a>
            </div>
        </div>
    <div>
      <div class="card mb-4">
    <div class="card-body">
        <div class="d-flex gap-4 col-md-4 mb-3">
            <input
                type="text"
                class="form-control"
                id="exampleInputEmail1"
                aria-describedby="emailHelp"
                placeholder="Buscar"
                v-model="buscador"
                @keyup="buscarDoctor"
            />
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">FOLIO MÉDICO</th>
                        <th scope="col">NOMBRE</th>
                        <th scope="col">APELLIDOS</th>
                        <th scope="col">ESPECIALIDAD</th>
                        <th scope="col">CÉDULA PROF.</th>
                        <th scope="col">EMAIL</th>
                        <th scope="col">TELÉFONO</th>
                        <th scope="col">CÓDIGO POSTAL</th>
                        <th scope="col">ALCALDIA</th>
                        <th scope="col">CIUDAD</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="doc in doctores.data" :key="doc.id">
                        <th scope="row">{{ doc.folio }}</th>
                        <td>{{ doc.nombres }}</td>
                        <td>{{ doc.apellidos }}</td>
                        <td>{{ doc.especialidad.nombre }}</td>
                        <td>{{ doc.cedula ?? '' }}</td>
                        <td>{{ doc.user.email }}</td>
                        <td>{{ doc.user.celular }}</td>
                        <td>{{ doc.cp }}</td>
                        <td>{{ doc.sepomex?.d_mnpio }}</td>
                        <td>{{ doc.sepomex?.d_ciudad }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <Pagination
            :data="doctores"
            @pagination-change-page="traerDoctor"
            class="d-flex justify-content-center"
        />
    </div>
</div>

    </div>
  </div>
</template>

<script>
export default {

  data(){
    return{
      doctores:{},
      buscador: "",
      buscadorEspecilidad:"",
      timeBuscador: "",
      Especialidades : {},
      special:'',
      startDate: "",
      endDate: ""
    }
  },
  mounted()
  {
    this.traerDoctor()
    this.getEspecialidades()
  },
  methods:{
    traerDoctor(page = 1) {
      axios.get('/api/show/reporte/doctores?page=' + page, { params: { buscador: this.buscador, startDate : this.startDate,endDate: this.endDate } })
        .then(res => {
          this.doctores = res.data
        })
        .catch(error => console.log())
    },
    buscarDoctor() {
      clearTimeout(this.timeBuscador);
      this.timeBuscador = setTimeout(this.traerDoctor, 360);
    },
    getEspecialidades() {
      axios.get('/api/especialidades')
        .then(res => {
          this.Especialidades = res.data
        })
    }, updateStartDate(){
      this.traerDoctor();
    },
    updateEndDate(){
      this.traerDoctor();
    },clearFields(){
      this.endDate = ''
      this.startDate = ''
      this.traerDoctor()
    }
  }

};
</script>

<style>
</style>