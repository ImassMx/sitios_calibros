<template>
  <div class="container-fluid px-4">
    <h1 class="mt-4">Editar Libro</h1>
  
    <div class="ml-2 col-lg-4 col-md-8">
      <form
        class=""
        method="POST"
        v-on:submit.prevent="updatebook()"
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
          />
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
        </div>

        <div class="form-group mb-3">
          <label for="inputState" class="mb-1">Clasificacion</label>
          <select id="inputState" class="form-select" v-model="clasificacion">
            <option value="">--- Seleccione ---</option>
            <option v-for="cla in clasificaciones" :value="cla.id" :key="cla.id">{{cla.nombre}}</option>

          </select>
        </div>

        <div class="form-group mb-3">
          <label for="inputState" class="mb-1">Estado</label>
          <select id="inputState" class="form-select" v-model="estado">
            <option value="" >--- Seleccione ---</option>
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
        </div>
        <button type="submit" class="btn btn-dark mt-3">Actualizar</button>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      nombre: null,
      portada: '',
      descripcion: null,
      clasificacion: "",
      estado: '',
      pdf:null,
      id:this.$route.params.id,
      Libros:[],
      clasificaciones:{}
    };
  },
   created() {
    axios
      .get('/book/'+ this.id +'/edit')
      .then(response => {
        this.nombre = response.data.nombre
        this.descripcion = response.data.descripcion
        this.clasificacion = response.data.clasificacion_id
        this.estado = response.data.estado
      })
    this.traerclasificacion()
  },
  methods: {
    subirImage(e) {
      let file = e.target.files[0];
      this.portada = file;
    },
    subirPdf(e){
        let pdf = e.target.files[0]
        this.pdf = pdf
    },
    updatebook() {
      const config = { headers: { "content-type": "multipart/form-data" } };
      let data = new FormData();
      data.append("nombre", this.nombre);
      data.append("portada", this.portada);
      data.append("descripcion", this.descripcion);
      data.append("clasificacion", this.clasificacion);
      data.append("pdf",this.pdf)
      data.append("estado", this.estado);

      
      axios.post('/book/'+this.id, data, config)
        .then((response) => {
          this.showAlert();
          this.$router.push({path: '/admin/listar-libros'})
        })
        .catch((error) => {
          console.log(error);
        });

      this.limpiar();
    },
    limpiar() {
      
      (this.nombre = ""),
        (this.descripcion = ""),
        (this.clasificacion = ""),
        (this.estado = "");
         let port = document.querySelector('#exampleFormControlFile2')
       port.value='';
       let pdflibro = document.querySelector('#exampleFormControlFile1')
       pdflibro.value='';
    },

    showAlert() {
      Swal.fire("Correcto", "Editado correctamente", "success");
    },
     traerclasificacion(){
      axios.get('/api/clasificacion-book')
      .then(response => {
          this.clasificaciones = response.data
      })
      .catch(error => console.log(error))
    }
  },
};
</script>

<style>
</style>