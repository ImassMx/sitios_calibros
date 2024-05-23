<template>
  <div class="registro">
    <div class="content-presentacio">
      <h4>Pensando en la salud y bienestar del paciente.</h4>
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
    <div class="contenido-formulario">
      <form action="" v-on:submit.prevent="saveDoctor()">
        <h2 class="text-center">Registro del doctor para descargar el libro.</h2>
        <div>
          <label for="nombre">Nombre</label>
          <input type="text" placeholder="Ingresa tu nombre" id="nombre" v-model="nombre" />
          <div v-if="errors.nombre" class="content-error">
            <p class="errors">{{ errors.nombre }}</p>
          </div>
        </div>
        <div>
          <label for="apellidoP">Apellidos</label>
          <input type="text" placeholder="Ingresa tu Apellido Paterno" id="apellidoP" v-model="apellidos" />
          <div v-if="errors.apellidos" class="content-error">
            <p class="errors">{{ errors.apellidos }}</p>
          </div>
        </div>
        <div>
          <label for="email">Especialidad</label>
          <select placeholder="Ingresar Especialidad" id="estado" v-model="especialidad">
            <option value="">---Seleccione---</option>
            <option v-for="especial in especialidades" :key="especial.id" :value="especial.id">
              {{ especial.nombre }}
            </option>
          </select>
          <div v-if="errors.especialidad" class="content-error">
            <p class="errors">{{ errors.especialidad }}</p>
          </div>
        </div>
        <div>
          <label for="">Cédula</label>
          <input type="text" v-model="cedula" maxlength="9" @change="validateCedula" />
          <div v-if="errors.cedula" class="content-error"  >
            <p class="errors">{{ errors.cedula }}</p>
          </div>
        </div>
        <div>
          <label for="">Email</label>
          <input type="text" v-model="email" @keyup="validarCorreo" />
          <p class="validacion-correo" v-if="errors.email">{{ errors.email }}</p>
        </div>
        <div>
          <label for="">Código Postal</label>
          <input type="text" v-model="postal" maxlength="5" />
          <p class="validacion-correo" v-if="errors.postal">{{ errors.postal }}</p>
        </div>
        <div>
          <label for="">Celular</label>
          <input type="text" v-model="celular" @keyup="validarCelular" />
          <p class="validacion-celular" v-if="errors.celular">{{ errors.celular }}</p>
        </div>
        <p v-html="messFolio"></p>

        <input type="submit" value="Registrarse" class="registrar" />
        <div class="content-panel" v-if="folio">
          <a :href="url_panel" class="registrar btn-panel">Ir a Panel</a>
        </div>
      </form>
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
            this.messFolio = `Su número de folio es: <b>${this.folio}</b>`;
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

.content-error p {
  margin: 0;
  font-size: 0.8rem;
}

.invalida {
  background-color: #f8d7da;
  border-color: #f5c6cb;
  font-weight: bold;
  text-align: center;
  padding: 0.2rem;
  border-radius: 5px;
  display: flex;
  align-items: center;
}

.invalida .errors {
  color: #721c24;
  font-size: 0.8rem;
}

#especialidad {
  color: #155724;
}

#especialidad span {
  font-weight: 700;
}

.registro {
  height: 100vh;
}

.btn_ingresar {
  margin-top: 1rem;
}

.validacion-correo,
.validacion-celular {
  margin: 0;
  color: red;
  font-weight: bold;
  font-size: 0.8rem;
}

.content-logo img {
  width: 100px;
  border-radius: 10px;
}

.content-presentacio {
  margin-bottom: 10;
  width: 40%;
}

.registro {
  height: 100%;
  min-height: 100vh;
  color: black;
  background-image: url("/img/template.jpg") !important;
  background-size: cover !important;
  background: rgba(0, 0, 0, 0);
  display: flex !important;
  flex-direction: row;
}

.registro form h1 {
  color: black;
  background: none;
  text-align: center;
}

.registro form {
  width: 50%;
  margin: 0 auto;
  background: none;
  margin-top: 5rem;
}

.registro .content-presentacio {
  widows: 50%;
}

.content ul {
  display: flex;
  gap: 2rem;
}

@media (max-width: 768px) {
  .registro {
    flex-direction: column;
    background-size: cover !important;
    background-position: center center;
  }

  .content-presentacio {
    width: 90%;
    margin: 0 auto;
  }

  .content ul {
    display: flex;
    gap: 1rem;
    flex-direction: column;
  }

  .registro form {
    width: 80%;
    margin-top: 1rem;
  }

  .registro form h1 {
    font-size: 1.5rem;
  }
}
.text-center{
  text-align: center;
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