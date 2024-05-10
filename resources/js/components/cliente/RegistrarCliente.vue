<template>
  <div class="registro">
    <h1>Registrate para poder descargar los libros</h1>

    <form v-on:submit.prevent="saveClient()">
      <div>
        <label for="apellidoM">Folio</label>
        <input type="text" placeholder="Ingrese el N° de folio" id="apellidoM" v-model="folio" @keyup="buscarCodigo" maxlength="5" />
      </div>
      <div>
        <label for="nombre">Nombre Doctor</label>
        <input type="text" placeholder="Nombre Doctor" id="nombre" v-model="nombre_doctor" disabled/>
      </div>
      <div>
        <label for="apellidoP">Nombre Paciente </label>
        <input type="text" placeholder="Ingrese su nombre" id="apellidoP" v-model="nombre_paciente" />
      </div>
      <div>
        <label for="email">Email</label>
        <input type="email" placeholder="Ingresa tu email" id="email" v-model="email" @keyup="buscarEmail" />
        <label for="" class="message-error" v-if="messageEmail">{{ messageEmail }}</label>
      </div>
      <div>
        <label for="celular">Celular</label>
        <input type="text" placeholder="Ingresa tu número de celular" id="celular" v-model="celular"
          @input="buscarPhone" />
        <label for="" class="message-error" v-if="messagePhone">{{ messagePhone }}</label>

      </div>
      <div>
        <label for="celular">Código Postal</label>
        <input type="text" placeholder="Ingrese el código postal" id="celular" v-model="codigo" />
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
      messageEmail: null,
      messagePhone: null
    };
  },
  methods: {
    async getCodeDoctor() {
      try {
        if (this.folio.length === 5) {
          const { data } = await axios.get("/api/infor/doctor/" + this.folio)
          if (!data.error) {
            this.nombre_doctor = data.data.nombres + ' ' + data.data.apellidos
          } else {
            this.nombre_doctor = ''
            this.errorAlert()
          }
        }
      } catch (error) {
        console.log(error)
      }
    },
    buscarCodigo() {
      clearTimeout(this.timeBuscador);
      this.timeBuscador = setTimeout(this.getCodeDoctor, 360);
    },
    saveClient() {
      this.axios.post('/registro/paciente',
        {
          nombre_doctor: this.nombre_doctor,
          nombre_paciente: this.nombre_paciente,
          folio: this.folio,
          email: this.email,
          celular: this.celular,
          password: this.celular,
          codigo: this.codigo,
          alcaldia: this.alcaldia,
          ciudad: this.ciudad,
          estado: this.estado
        }).then(res => {
          if (!res.data.error) {
            window.location.href = '/perfil/' + res.data.client_id
          }
        }).catch(error => {
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
    async buscarEmail() {
      try {
        this.messageEmail = null
        const { data } = await axios.get('/api/validate/email', { params: { email: this.email } })
        if (data) {
          this.messageEmail = 'El email ya se encuentra registrado.'
        }
      } catch (error) {
        console.log(error)
      }
    },
    async buscarPhone() {
      try {
        this.messagePhone = null
        const { data } = await axios.get('/api/validate/phone', { params: { celular: this.celular } })
        if (data) {
          this.messagePhone = 'El N° de celular ya se encuentra registrado.'
        }
      } catch (error) {
        console.log(error)
      }
    }
  },
};
</script>

<style scoped>
.message-error {
  color: red;
  font-size: 11px;
}
</style>