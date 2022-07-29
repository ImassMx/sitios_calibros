<template>
  <div class="container-fluid px-4">
    <h1 class="mt-4 mb-4">Agregar Liga {{id}}</h1>
    <div class="container">
      <div class="row cambiar">
        <div class="col">
          <div class="m-5">
            <form class="" method="POST" v-on:submit.prevent="saveLiga()">
              <div class="form-group mb-3">
                <label for="exampleInputEmail1" class="mb-1"
                  >Nombre (Doctor,Clínica, Hospital)</label
                >
                <input
                  type="text"
                  class="form-control"
                  id="exampleInputEmail1"
                  aria-describedby="emailHelp"
                  v-model="nombre"
                />
              </div>
              <div class="form-group mb-3">
                <label for="exampleInputEmail1" class="mb-1">Celular</label>
                <input
                  type="text"
                  class="form-control"
                  id="exampleInputEmail1"
                  aria-describedby="emailHelp"
                  v-model="celular"
                />
              </div>
              <div class="form-group mb-3">
                <label for="exampleInputEmail1" class="mb-1">Email</label>
                <input
                  type="email"
                  class="form-control"
                  id="exampleInputEmail1"
                  aria-describedby="emailHelp"
                  v-model="email"
                />
              </div>

              <!-- <div class="form-group mb-3">
                <label for="inputState" class="mb-1">Vigencia</label>
                <select id="inputState" class="form-control" v-model="vigencia">
                  <option selected>--- Seleccione ---</option>
                  <option>Si</option>
                  <option>No</option>
                </select>
              </div> -->
              <div class="form-group mb-3">
                <label for="inputState" class="mb-1">Estado</label>
                <select id="inputState" class="form-select" v-model="estado">
                  <option value="">--- Seleccione ---</option>
                  <option value="1">Activo</option>
                  <option value="2">Inactivo</option>
                </select>
              </div>
              <div class="form-group">
                <div class="card mb-4">
                  <div class="card-body">
                    <div class="form-group">
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
                          <th scope="col"></th>
                          <th class="text-center" scope="col">NOMBRE</th>
                          <th class="text-center" scope="col">ESTADO</th>
                        </tr>
                      </thead>
                      <tbody v-for="lib in Libros.data" :key="lib.id">
                        <tr>
                          <td class="text-center">
                            <input
                              type="radio"
                              :value="`${lib.id}`"
                              v-model="book"
                            />
                          </td>
                          <td >{{ lib.nombre }}</td>
                          <div v-if="lib.estado === 1">
                            <td class="text-center">Activo</td>
                          </div>
                          <div v-else>
                            <td class="text-center">Inactivo</td>
                          </div>
                        </tr>
                      </tbody>
                    </table>
                    <Pagination :data="Libros" @pagination-change-page="traerLibros" />
                  </div>
                </div>
                <div class="form-group mb-3">
                <label for="exampleInputEmail1" class="mb-1">Logo Laboratorio</label>
                <input
                  type="file"
                  class="form-control"
                  id="logoLaboratorio"
                  aria-describedby="emailHelp"
                  @change="LogoLab"
                />

              </div>
              </div>
              <button type="submit" class="btn btn-dark mt-3">Agregar</button>
            </form>
          </div>
        </div>
        <div class="col contenido-logo" v-if="url">
          <img :src="url" alt="" class="logo" />
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
      book: [],
      nombre: null,
      celular: null,
      email: null,
      estado: '',
      id:this.$route.params.id,
      url:''
    };
  },
  created() {
    this.traerLibros();
    this.traerliga();
  },
  methods: {

    traerLibros(page=1){
        axios
      .get('/api/book?page='+page,{params:{buscador:this.buscador}})
      .then((response) => {
        this.Libros = response.data
        console.log(this.Libros)
      })
      .catch((error) => {
        console.log(error);
      });
    },
    traerliga()
    {
        axios.get('/liga/'+this.id+'/edit')
        .then(response =>{
            this.nombre = response.data[0].nombre
            this.celular = response.data[0].celular
            this.email = response.data[0].correo
            this.estado = response.data[0].estado
           this.book =  response.data[0].publicacion[0].libro_id
           this.url = `/storage/logo/${response.data[0].img_lab}`

        })
    }
    ,
    saveLiga() {
  const config = { headers: { "content-type": "multipart/form-data" } };

      let data = new FormData();
      data.append('nombre',this.nombre)
      data.append('celular',this.celular)
      data.append('email',this.email)
      data.append('estado',this.estado)
      data.append('book',this.book)
      data.append('logo',this.logo)

      axios
        .post("/update/liga/"+this.id, data,config)
        .then((response) => {
          if(response.data === 1){
            this.$router.push({path: '/admin/listar-ligas'})
            this.showAlert();
          }
          
        })
        .catch((error) => console.log(error));
    },
    showAlert() {
      Swal.fire("Correcto", "Liga actualizada correctamente", "success");
    },
      buscarLibros(){
          clearTimeout(this.timeBuscador)
          this.timeBuscador = setTimeout(this.traerLibros,360)
      },
    LogoLab(e)
    {
        let file = e.target.files[0];
        this.url = URL.createObjectURL(file);
        this.logo = file
    }
  },
};
</script>

<style scoped>
.dataTable-info {
  display: none;
}

@media (max-width: 768px) {
  .contenido-qr {
    display: flex;
    justify-content: center;
  }
  .qr {
    width: 100px;
    margin: 0 auto;
  }
  .cambiar {
    display: flex;
    flex-direction: column-reverse;
  }
}
@media (max-width: 992px) {
  .contenido-qr {
    display: flex;
    justify-content: center;
  }
  .qr {
    width: 200px;
    margin: 0 auto;
  }
  .cambiar {
    display: flex;
    flex-direction: column-reverse;
  }
}

.contenido-logo{
  display: flex;
  justify-content: center;

}
.contenido-logo .logo{
  width: 300px;
  height: 300px;
}
</style>