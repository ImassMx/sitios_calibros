<template>
  <div class="registro">
    <div class="content-presentacio">
      <div class="content-logo">
        <img :src="url" alt="" class="img" />
      </div>
      <h2>{{ titulo }}</h2>
      <h4>Pensando en la salud y bienestar del paciente.</h4>
      <p>
        Le estamos ofreciendo la descarga del libro digital
        {{ tituloLibro }} editado por médicos especialistas enfocados en dar a
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
        <h1>Registro del doctor para descargar el libro.</h1>
        <div v-if="errors && errors.id_slug" class="invalida">
          <p class="errors">{{ errors.id_slug[0] }}</p>
        </div>
        <div>
          <label for="nombre">Nombre</label>
          <input
            type="text"
            placeholder="Ingresa tu nombre"
            id="nombre"
            v-model="nombre"
          />
          <div v-if="errors && errors.nombre" class="content-error">
            <p class="errors">{{ errors.nombre[0] }}</p>
          </div>
        </div>
        <div>
          <label for="apellidoP">Apellidos</label>
          <input
            type="text"
            placeholder="Ingresa tu Apellido Paterno"
            id="apellidoP"
            v-model="apellidos"
          />
          <div v-if="errors && errors.apellidos" class="content-error">
            <p class="errors">{{ errors.apellidos[0] }}</p>
          </div>
        </div>
        <div>
          <label for="email">Especialidad</label>
          <select
            placeholder="Ingresar Especialidad"
            id="estado"
            v-model="especialidad"
          >
            <option value="">---Seleccione---</option>
            <option
              v-for="especial in especialidades"
              :key="especial.id"
              :value="especial.id"
            >
              {{ especial.nombre }}
            </option>
          </select>
          <div v-if="errors && errors.especialidad" class="content-error">
            <p class="errors">{{ errors.especialidad[0] }}</p>
          </div>
        </div>
        <div>
          <label for="">Email</label>
          <input type="text" v-model="email" @keyup="validarCorreo" />
          <p class="validacion-correo"></p>
        </div>
        <div>
          <label for="">Código Postal</label>
          <input type="text" v-model="postal" />
        </div>
        <div>
          <label for="">Celular</label>
          <input type="text" v-model="celular" @keyup="validarCelular" />
          <p class="validacion-celular"></p>
        </div>
        <p id="especialidad"></p>
        <input type="hidden" id="slug" v-model="id_slug" />

        <input type="submit" value="Registrarse" class="registrar" />
        <div class="btn_ingresar" v-if="boton">
          <input type="hidden" v-model="contraseña" />
          <input
            @click="redireccionar"
            type="button"
            value="Descargar"
            class="registrar"
          />
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
    };
  },
  mounted() {
    this.obtenerSlug();
    this.obtenerEspecialidad();
    this.mostrarDatosSlug();
    this.getLogo();
  },
  methods: {
    obtenerSlug() {
      const valores = window.location.search;
      const urlParams = new URLSearchParams(valores);
      var producto = urlParams.get("slug_id");
      this.id_slug = producto;
    },
    obtenerEspecialidad() {
      axios.get("/api/especialidades").then((response) => {
        this.especialidades = response.data;
      });
    },
    saveDoctor() {
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
        })
        .then((response) => {
          var folio = document.querySelector("#especialidad");
          var num = response.data;
          folio.innerHTML = `Su número de folio es: <b>${num}</b>`;
          this.limpiar();
          this.showAlert(num);
          this.boton = true;
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
      this.id_slug = "";
      this.postal = "";
      this.email = "";
      this.celular = "";
    },
    showAlert(num) {
      Swal.fire(
        "Registro Exitoso !!",
        `El código para sus descargas es el <b style="color:black;font-weight:bold;">${num}</b> el cual deberá proporcionar a sus pacientes para que puedan realizar la descarga desde este sitio <a href="${this.dominio}" style="text-decoration:none;font-weight:bold;color:black; ">${this.dominio}</a>`,
        "success"
      );
      /* var btn_confirm = document.querySelector('.swal2-confirm')
      btn_confirm.addEventListener('click',()=>{
        window.location =`https://${this.dominio}`
      }) */
    },
    validarCorreo() {
      clearTimeout(this.timeBuscador);
      this.timeBuscador = setTimeout(this.validarEmail, 360);
    },
    validarEmail() {
      axios
        .get("/validar/email/doctor", { params: { correo: this.email } })
        .then((res) => {
          var validacion = document.querySelector(".validacion-correo");
          if (res.data.email) {
            validacion.innerHTML = "El email ya esta registrado";
          } else {
            validacion.innerHTML = "";
          }

        });
    },
    validarCelular() {
      clearTimeout(this.timeBuscador);
      this.timeBuscador = setTimeout(this.validarPhone, 360);
    },
    validarPhone() {
      axios
        .get("/validar/phone/doctor", { params: { celular: this.celular } })
        .then((res) => {
          var validacion = document.querySelector(".validacion-celular");
          if (this.celular === res.data.celular) {
            validacion.innerHTML = "El número de celular ya esta registrado";
          } else {
            validacion.innerHTML = "";
          }
        });
    },
    mostrarDatosSlug() {
      axios
        .get("/api/mostrar/datos/slug", { params: { id: this.id_slug } })
        .then((res) => {
          this.titulo = res.data[0].nombre;
          this.tituloLibro = res.data[1].nombre;
          this.url = `/storage/logo/${res.data[0].img_lab}`;
          this.slug = res.data[0].slug;
        });
    },
    redireccionar() {
      window.location.href = `/descargas/${this.slug}`;
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
    background-size:cover !important;
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
  .registro form  {
  width: 80%;
  margin-top: 1rem;
}
  .registro form h1 {
  font-size: 1.5rem;
}
}
</style>