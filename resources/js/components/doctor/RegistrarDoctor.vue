<template>
<div class="container-fluid registro-bg">
    <div class="row pt-3 pb-4">
        <div class="col-md-6 col-sm-12 p-md-5">
          <div class="espacio"></div>
          <h4 class="pt-4">Pensando en la salud y bienestar del paciente.</h4>
          <p>
            Le estamos ofreciendo la descarga de libros digitales editado por médicos especialistas enfocados en dar a
            conocer a sus pacientes:
          </p>
           <div class="content">
              <ul>
                <li>CAUSA</li>
                <li>PREVENCIÓN</li>
                <li>TRATAMIENTO</li>
                <li>BIENESTAR</li>
              </ul>
            </div>
        </div>
        <div class="col-md-1 col-sm-12"></div>
        <div class="col-md-4 col-sm-12">
          <form action="" v-on:submit.prevent="saveDoctor()">
            <div class="row" v-if="!folio">
              <div class="col-md-12 col-sm-12 p-2">
                <h2 class="text-center">Registro del médico.</h2>
              </div>  
              <div class="col-md-12 col-sm-12 p-2">
                <label for="nombre">Nombre</label>
                <input class="form-control" type="text" placeholder="Ingresa tu nombre" id="nombre" v-model="nombre" />
                <div v-if="errors.nombre" class="content-error">
                  <p class="errors">{{ errors.nombre }}</p>
                </div>
              </div>
              <div class="col-md-12 col-sm-12 p-2">
                <label for="apellidoP">Apellidos</label>
                <input type="text"  class="form-control"  placeholder="Ingresa tu Apellido Paterno" id="apellidoP" v-model="apellidos" />
                <div v-if="errors.apellidos" class="content-error">
                  <p class="errors">{{ errors.apellidos }}</p>
                </div>
              </div>
              <div class="col-md-12 col-sm-12 p-2">
                <label for="email">Especialidad</label>
                <select placeholder="Ingresar Especialidad"  class="form-select" v-model="especialidad">
                  <option value="">---Seleccione---</option>
                  <option v-for="especial in especialidades" :key="especial.id" :value="especial.id">
                    {{ especial.nombre }}
                  </option>
                </select>
                <div v-if="errors.especialidad" class="content-error">
                  <p class="errors">{{ errors.especialidad }}</p>
                </div>
              </div>
              <div class="col-md-12 col-sm-12 p-2">
                <label for="">Email</label>
                <input type="text"  class="form-control"  v-model="email" @keyup="validarCorreo" />
                <p class="validacion-correo" v-if="errors.email">{{ errors.email }}</p>
              </div>
              <div class="col-md-6 col-sm-12 p-2">
                <label for="">Cédula</label>
                <input type="text"  class="form-control"  v-model="cedula" maxlength="9" @change="validateCedula" />
                <div v-if="errors.cedula" class="content-error"  >
                  <p class="errors">{{ errors.cedula }}</p>
                </div>
              </div>
              <div class="col-md-6 col-sm-12 p-2">
                <label for="">Código Postal</label>
                <input type="text"  class="form-control"  v-model="postal" maxlength="5" />
                <p class="validacion-correo" v-if="errors.postal">{{ errors.postal }}</p>
              </div>
              <div class="col-md-12 col-sm-12 p-2">
                <label for="">Celular</label>
                <input type="text"  class="form-control"  v-model="celular" @keyup="validarCelular" placeholder="(Sí, actualizaste tu número agregalo aquí)"/>
                <p class="validacion-celular" v-if="errors.celular">{{ errors.celular }}</p>
              </div>
              <div class="col-md-12 col-sm-12 p-2">          
                <p v-html="messFolio"></p>
                <input type="submit" value="Registrarse" class="registrar" />
                <div class="content-panel" v-if="folio">
                  <a :href="url_panel" class="registrar btn-panel">Ir a panel de libros</a>
                </div>
              </div>        
            </div> 
             <div class="row pt-md-5" v-if="folio">
              <div class="col-md-12 col-sm-12 p-2 pt-md-5 mt-2">
                <h2 class="text-center">¡Registro exitoso!</h2>
              </div> 
              <div class="col-md-12 col-sm-12 p-2">  
                <h5 class="text-center pb-2">En su correo recibirá toda la información
                   necesaria para ingresar a la plataforma <br>A continuación podrá ver su folio:
                </h5>        
                <h4  class="text-center" v-html="messFolio"></h4> 
                <p  class="text-center pt-2">Con este folio tendrá acceso a un libro ¡GRATUITO! que podrá
                  descargar dentro de la plataforma.
                </p>
                <div class="content-panel" v-if="folio">
                  <a :href="url_panel" class="registrar btn-panel">Ir a panel de libros</a>
                </div>
              </div>        
            </div>       
          </form>
        </div>
    </div>
</div> 
</template>

<script>
export default {
  data() {
    return {
      nombre: "",
      apellidos: "",
      especialidad: "",
      id_slug: "",
      especialidades: {},
      errors: {},
      dominio: document.domain,
      email: "",
      postal: "",
      celular: "",
      contraseña: 12345,
      boton: false,
      timeBuscador: "",
      titulo: "",
      tituloLibro: "",
      url: "",
      slug: "",
      cedula: "",
      messFolio: "",
      messageCel: false,
      messageEmail: false,
      folio:"",
      url_panel:"",
      errors:[]
    };
  },
  mounted() {
    this.obtenerEspecialidad();
  },
  methods: {
    obtenerEspecialidad() {
      axios.get("/api/especialidades").then((response) => {
        this.especialidades = response.data;
      });
    },
    saveDoctor() {
      this.validated()
      if(Object.keys(this.errors).length > 0){
        return true;
      }

      this.AlertProcess()
      this.axios
        .post("/request/registrar/doctor", {
          nombre: this.nombre,
          apellidos: this.apellidos,
          especialidad: this.especialidad,
          id_slug: this.id_slug,
          email: this.email,
          postal: this.postal,
          password: this.contraseña,
          celular: this.celular,
          cedula: this.cedula
        })
        .then((response) => {
          if (!response.data.error) {
            this.folio = response.data.folio;
            this.messFolio = `Se le envió un email con su número de folio y link para que pueda acceder`;
            this.url_panel = `/zona/doctor/${response.data.uuid}`
            this.limpiar()
            swal.close()
          }
        })
        .catch((error) => {
          if (error.response.status === 422) {
            this.errors = error.response.data.errors;
            swal.close()
          }

          if (error.response.status === 500) {
            this.errorAlert();
            this.limpiar();
            swal.close()
          }
        });
    },
    errorAlert() {
      Swal.fire({
        icon: "error",
        title: "Hubo un error!",
        text: "La liga no existe!",
      });
    },
    limpiar() {
      this.nombre = "";
      this.apellidos = "";
      this.especialidad = "";
      this.postal = "";
      this.email = "";
      this.celular = "";
      this.cedula = ""
    },
    validarCorreo() {
      clearTimeout(this.timeBuscador);
      this.timeBuscador = setTimeout(this.validarEmail, 360);
    },
    validarEmail() {
      delete this.errors.email
      axios
        .get("/validar/email/doctor", { params: { correo: this.email } })
        .then((res) => {
          if (res.data.email) {
            this.errors.email = "El email ya esta registrado";
          }
        });
    },
    validarCelular() {
      clearTimeout(this.timeBuscador);
      this.timeBuscador = setTimeout(this.validarPhone, 360);
    },
    validarPhone() {
      delete this.errors.celular
      axios
        .get("/validar/phone/doctor", { params: { celular: this.celular } })
        .then((res) => {
          
          if (this.celular === res.data.celular) {
            this.errors.celular = "El número de celular ya esta registrado";
          }
        });
    },
    async validateCedula(){
      try {
        delete this.errors.cedula
        const {data} = await axios.get('/api/validate/cedula',{params:{cedula:this.cedula}})
        if(data){
          this.errors.cedula = 'El número de cedula ya se encuentra registrado'
        }
      } catch (error) {
        console.log(error)
      }
    },
    AlertProcess() {
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
    },
    validated(){
          this.errors = []
          if(this.nombre === "") this.errors.nombre = 'Debe ingresar su nombre.'
          if(this.apellidos === "") this.errors.apellidos = 'Debe ingresar su apellido.'
          if(this.especialidad === "") this.errors.especialidad = 'Debe seleccionar su especialidad.'
          if(this.cedula === "") this.errors.cedula = 'Debe ingresar su cédula.'
          if(this.email === "") this.errors.email = 'Debe ingresar su email.'
          if(this.postal === "") this.errors.postal = 'Debe ingresar el código postal.'
          if(this.celular === "") this.errors.celular = 'Debe ingresar su número de celular.'

    }
  },
};
</script>

<style scoped>
.content-error {
  margin: 0;
}

.espacio{
  padding-top: 130px; 
  padding-left: 60px;
}
.content-error p {
  margin: 0;
  font-size: 0.8rem;
} 

#especialidad {
  color: #155724;
}

#especialidad span {
  font-weight: 700;
}  
.validacion-correo,
.validacion-celular {
  margin: 0;
  color: red;
  font-weight: bold;
  font-size: 0.8rem;
} 
 
.registro-bg { 
  background-image: url("/img/template.jpg") !important;
  background-position: center center; 
  background: rgba(0, 0, 0, 0); 
}  
 
.content ul {
  display: flex;
  gap: 2rem;
}

@media (max-width: 768px) {
  .registro { 
    background-position: center center;
  } 

  .content ul {
    display: flex;
    gap: 1rem;
    flex-direction: column;
  }  
}
 
.content-panel{
  margin-top: 1rem;
  display: flex;
  justify-content: center;
}

.content-panel .btn-panel{
  text-align: center;
  text-decoration: none;
  cursor: pointer !important;
}
</style>