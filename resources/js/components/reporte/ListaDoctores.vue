<template>
  <div class="container-fluid px-4">
    <h1 class="mt-4 mb-3">Reporte de médicos</h1>

    <a href="/export/doctor" class="btn btn-outline-success mb-3" download="Doctores.xlsx">Exportar Reporte</a>
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
                        <th scope="col">FOLIO</th>
                        <th scope="col">NOMBRE</th>
                        <th scope="col">APELLIDOS</th>
                        <th scope="col">ESPECIALIDAD</th>
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
      special:''
    }
  },
  mounted()
  {
    this.traerDoctor()
    this.getEspecialidades()
  },
  methods:{
      traerDoctor(page=1)
      {
        axios.get('/api/show/reporte/doctores?page='+page,{params:{buscador:this.buscador}})
        .then(res => {
            this.doctores = res.data
        })
        .catch(error => console.log())
      },
      buscarDoctor() {
      clearTimeout(this.timeBuscador);
      this.timeBuscador = setTimeout(this.traerDoctor, 360);
    },
    getEspecialidades()
    {
      axios.get('/api/especialidades')
      .then( res =>{
        this.Especialidades = res.data
      })
    }
  }

};
</script>

<style>
</style>