<template>
  <div class="container-fluid px-4">
    <h1 class="mt-4 mb-4">Agregar Libro</h1>
    <div class="ml-2 col-lg-4 col-md-8 my-3">
      <form
        class=""
        method="POST"
        v-on:submit.prevent="savebook()"
        enctype="multipart/form-data"
      >
        <div class="form-group mb-3">
          <label for="exampleInputEmail1" class="mb-1">Nombre</label>
          <input
            type="text"
            class="form-control"
            id="exampleInputEmail1"
            v-model="nombre"
            aria-describedby="emailHelp"
            validate
          />
          <div v-if="errors && errors.nombre">
            <p class="errors">{{ errors.nombre[0] }}</p>
          </div>
        </div>
        <div class="form-group mb-3">
          <label for="exampleFormControlTextarea1" class="mb-1"
            >Descripción</label
          >
          <textarea
            class="form-control"
            id="exampleFormControlTextarea1"
            v-model="descripcion"
            rows="3"
          ></textarea>
          <div v-if="errors && errors.descripcion">
            <p class="errors">{{ errors.descripcion[0] }}</p>
          </div>
        </div>

        <div class="form-group mb-3">
          <label for="inputState" class="mb-1">Clasificación</label>
          <select id="inputState" class="form-select" v-model="clasificacion">
            <option value="">---Selecionar---</option>
            <option v-for="cla in clasificaciones" :value="cla.id" :key="cla.id">{{cla.nombre}}</option>
          </select>
          <div v-if="errors && errors.clasificacion">
            <p class="errors">{{ errors.clasificacion[0] }}</p>
          </div>
        </div>

        <div class="form-group mb-3">
          <label for="inputState" class="mb-1">Estado</label>
          <select id="inputState" class="form-select" v-model="estado">
            <option value="1" selected>Activo</option>
            <option value="2">Inactivo</option>
          </select>
        </div>
        <div class="form-group mb-3">
          <label for="exampleFormControlFile2" class="mb-1 d-flex flex-column"
            >Agregar Portada</label
          >
          <input
            type="file"
             class="form-control" 
            id="exampleFormControlFile2"
            @change="subirImage"
          />
          <div v-if="errors && errors.portada">
            <p class="errors">{{ errors.portada[0] }}</p>
          </div>
        </div>
        <div class="form-group mb-3">
          <label for="exampleFormControlFile1" class="mb-1 d-flex flex-column"
            >Agregar PDF</label
          >
          <input
            type="file"
            class="form-control"
            id="exampleFormControlFile1"
            @change="subirPdf"
          />
          <div v-if="errors && errors.pdf">
            <p class="errors">{{ errors.pdf[0] }}</p>
          </div>
        </div>
        <button type="submit" class="btn btn-dark mt-3">Agregar</button>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      nombre: null,
      portada: null,
      descripcion: null,
      clasificacion: "",
      estado: 1,
      pdf:null,
      clasificaciones:[],
      errors:{}
    };
  },
  mounted(){
    this.traerclasificacion()
  }
  ,
  methods: {
    subirImage(e) {
      let file = e.target.files[0];
      this.portada = file;
    },
    subirPdf(e){
        let pdf = e.target.files[0]
        this.pdf = pdf
    },
    savebook(file) {

      this.AlertProcess()
      
      const config = { headers: { "content-type": "multipart/form-data" } };
      let data = new FormData();
      data.append("nombre", this.nombre);
      data.append("portada", this.portada);
      data.append("descripcion", this.descripcion);
      data.append("clasificacion", this.clasificacion);
      data.append("pdf",this.pdf)
      data.append("estado", this.estado);
      axios
        .post("/create/book", data, config)
        .then((response) => {
          this.showAlert();
          this.limpiar();
          this.errors = {}
        })
        .catch(error => {
          if(error.response.status === 422){
              this.errors = error.response.data.errors
              swal.close()
            }
        })
    },
    limpiar() {
      (this.nombre = ""),
        (this.descripcion = ""),
        (this.clasificacion = ""),
        (this.estado = 1);
         let port = document.querySelector('#exampleFormControlFile2')
       port.value='';
       let pdflibro = document.querySelector('#exampleFormControlFile1')
       pdflibro.value='';
    },
    showAlert() {
      Swal.fire("Correcto", "Libro creado correctamente", "success");
    },
    traerclasificacion(){
      axios.get('/api/clasificacion-book')
      .then(response => {
          this.clasificaciones = response.data
      })
      .catch(error => console.log(error))
    },
    AlertProcess()
    {
      swal.fire({
            title: 'Procesando....',
            text: 'Un momento por favor se estan enviando los datos',
            allowOutsideClick: false,
            allowEscapeKey: false,
            allowEnterKey: false,
            showConfirmButton: false,
            onBeforeOpen: () => {
                swal.showLoading();
            }
        });
    }
  }
};
</script>

<style>
</style>