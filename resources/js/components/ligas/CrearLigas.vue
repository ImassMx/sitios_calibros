<template>
  <div class="container-fluid px-4">
    <h1 class="mt-4 mb-4">Agregar Nuevo Cliente</h1>
    <div class="container">
      <div class="row cambiar">
        <!-- {{ book }} -->
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
                <div v-if="errors && errors.nombre">
                  <p class="errors">{{errors.nombre[0]}}</p>
                </div>
              </div>
              <div class="form-group mb-3">
                <label for="exampleInputEmail1" class="mb-1">Teléfono de Contacto</label>
                <input
                  type="text"
                  class="form-control"
                  id="exampleInputEmail1"
                  aria-describedby="emailHelp"
                  v-model="celular"
                />
                 <div v-if="errors && errors.celular">
                  <p class="errors">{{errors.celular[0]}}</p>
                </div>
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
                 <div v-if="errors && errors.email">
                  <p class="errors">{{errors.email[0]}}</p>
                </div>
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
                              class="lib"
                              v-if="lib.estado === 1"
                            />
                          </td>
                          <td>{{ lib.nombre }}</td>
                          <div v-if="lib.estado === 1">
                            <td class="text-center">Activo</td>
                          </div>
                          <div v-else>
                            <td class="text-center">Inactivo</td>
                          </div>
                        </tr>
                      </tbody>
                    </table>
                    <div v-if="errors && errors.book">
                  <p class="errors">{{errors.book[0]}}</p>
                </div>
                    <Pagination
                      :data="Libros"
                      @pagination-change-page="traerLibros"
                    />
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
                  accept=".png, .jpg, .jpeg"
                />

              </div>
              </div>
              <button type="submit" class="btn btn-dark mt-3">Agregar</button>
            </form>
          </div>
        </div>
        <div class="col contenido-qr">
          <img :src="url" alt="" class="logo" v-if="url" />
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
      nombre: '',
      celular: '',
      email: '',
      estado: 1,
      errors:{},
      url:'',
      logo:''
    };
  },
  created() {
    this.traerLibros();
  },
  methods: {
    traerLibros(page = 1) {
      axios
        .get("/api/traer/book?page=" + page, { params: { buscador: this.buscador } })
        .then((response) => {
          this.Libros = response.data;
        });
    },
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
        .post("/request/liga", data,config)
        .then((response) => {
          this.showAlert();
          this.limpiar()
          this.errors={}
          
        })
        .catch((error) => {
            if(error.response.status === 422){
              this.errors = error.response.data.errors
            }
        });
    },
    limpiar() {
      (this.nombre = ""),
        (this.celular = ""),
        (this.email = ""),
        (this.estado = ""),
        (this.book = []);
        let logo = document.querySelector('#logoLaboratorio')
        logo.value= ""
    },
    showAlert() {
      Swal.fire("Correcto", "Liga creada correctamente", "success");
    },
    buscarLibros() {
      clearTimeout(this.timeBuscador);
      this.timeBuscador = setTimeout(this.traerLibros, 360);
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
  .logo {
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
  .logo {
    width: 200px;
    margin: 0 auto;
  }
  .cambiar {
    display: flex;
    flex-direction: column-reverse;
  }
}

.errors{
  color: red;
  font-weight: bold;
}
.contenido-qr{
  display: flex;
  justify-content: center;
}
.logo{
  width: 300px !important;
  height: 300px !important;
}

</style>