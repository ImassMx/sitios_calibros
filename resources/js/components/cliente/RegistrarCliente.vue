<template>
  <div class="registro">
    <h1>Registrate para poder descargar los libros</h1>

    <form v-on:submit.prevent="saveClient()">
      <div>
        <label for="nombre">Nombre Doctor</label>
        <input
          type="text"
          placeholder="Ingresa el nombre de su doctor"
          id="nombre"
          v-model="nombre_doctor"
        />
      </div>
      <div>
        <label for="apellidoP">Nombre Paciente </label>
        <input
          type="text"
          placeholder="Ingrese su nombre"
          id="apellidoP"
          v-model="nombre_paciente"
        />
      </div>
      <div>
        <label for="apellidoM">Folio</label>
        <input
          type="text"
          placeholder="Ingrese el N° de folio"
          id="apellidoM"
          v-model="folio"
        />
      </div>
      <div>
        <label for="email">Email</label>
        <input
          type="email"
          placeholder="Ingresa tu email"
          id="email"
          v-model="email"
        />
      </div>
      <div>
        <label for="celular">Celular</label>
        <input
          type="text"
          placeholder="Ingresa tu numero de celular"
          id="celular"
          v-model="celular"
        />
      </div>
      <div>
        <label for="celular">Código Postal</label>
        <input
          type="text"
          placeholder="Ingrese el código postal"
          id="celular"
          v-model="codigo"
          @keyup="buscarCodigo"
        />
      </div>
      <div>
        <label for="celular">Alcaldia/Municipio</label>
        <input
          type="text"
          placeholder="Ingrese el código postal"
          id="celular"
          v-model="alcaldia"
        />
      </div>
      <div>
        <label for="celular">Ciudad</label>
        <input
          type="text"
          placeholder="Ingrese el código postal"
          id="celular"
          v-model="ciudad"
        />
      </div>
      <div>
        <label for="celular">Estado</label>
        <input
          type="text"
          placeholder="Ingrese el código postal"
          id="celular"
          v-model="estado"
        />
      </div>

      <input type="submit" value="Registrarse" class="registrar" />
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      nombre_doctor: "",
      nombre_paciente: "",
      folio: "",
      email: "",
      celular: "",
      codigo: "",
      alcaldia: "",
      ciudad: "",
      estado: "",
      timeBuscador: "",
    };
  },
  mounted() {
    this.traerCodigo();
  },
  methods: {
    traerCodigo() {
      this.axios
        .get("/api/codigo/postal",{params:{codigo:this.codigo}})
        .then((response) => {
            this.alcaldia = response.data.d_mnpio
            this.ciudad = response.data.d_ciudad
            this.estado = response.data.d_estado
        })
        .catch((error) => console.log(error));
    },
    buscarCodigo() {
      clearTimeout(this.timeBuscador);
      this.timeBuscador = setTimeout(this.traerCodigo, 360);
    },
    saveClient()
    {
      this.axios.post('/registrar-cliente',
      {nombre_doctor:this.nombre_doctor,
      nombre_paciente:this.nombre_paciente,
      folio:this.folio,
      email:this.email,
      celular:this.celular,
      password:this.celular,
      codigo:this.codigo,
      alcaldia:this.alcaldia,
      ciudad:this.ciudad,
      estado: this.estado
      }).then(res => {
        this.limpiar()
      }).catch(error =>{
        if (error.response.status === 500) {
                this.errorAlert();
              }
      })
    }, errorAlert() {
      Swal.fire({
        icon: "error",
        title: "Hubo un error",
        text: "El número de folio es inválido",
      });
    },
    limpiar(){
      this.nombre_doctor=''
      this.nombre_paciente=''
      this.folio=''
      this.email=''
      this.celular=''
      this.password=''
      this.codigo=''
      this.alcaldia=''
      this.ciudad=''
      this.estado=''
    }
  },
};
</script>

<style>
</style>