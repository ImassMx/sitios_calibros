<template>
  <div class="registro">
    <h1>Registro de Doctor</h1>
    <form action="" v-on:submit.prevent="saveDoctor()">
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
          @keyup="nombre"
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
          type="email"
          placeholder="Ingresar Especialidad"
          id="estado"
          v-model="especialidad"
        >
          <option value="">---Seleccione---</option>
          <option
            v-for="especial in especialidades"
            :key="especial.id"
            :value="especial.id">
            {{ especial.nombre }}
          </option>
        </select>
        <div v-if="errors && errors.especialidad" class="content-error">
          <p class="errors">{{ errors.especialidad[0] }}</p>
        </div>
      </div>
        <p id="especialidad"></p>
      <input type="hidden"  id="slug" v-model="id_slug" />
      <input type="submit" value="Registrarse" class="registrar" />
    </form>
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
    };
  },
  mounted() {
    this.obtenerSlug();
    this.obtenerEspecialidad();
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
      this.axios
        .post("/registrar-doctor", {
          nombre: this.nombre,
          apellidos: this.apellidos,
          especialidad: this.especialidad,
          id_slug: this.id_slug,
        })
        .then((response) => {
           var folio =  document.querySelector('#especialidad')
           var num = response.data
           folio.innerHTML= `Su número de folio es: <b>${num}</b>`
           this.limpiar()
           this.showAlert(num)
        })
        .catch((error) => {
          if (error.response.status === 422) {
            this.errors = error.response.data.errors;
          }

          if(error.response.status === 500){
            this.errorAlert()
            this.limpiar()
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
    limpiar()
    {
      this.nombre =""
      this.apellidos=""
      this.especialidad=""
      this.id_slug =""
    },
    showAlert(num) {
      Swal.fire("Registro Exitoso !!", `El código para sus descargas es el <b style="color:black;font-weight:bold;">${num}</b> el cual deberá proporcionar a sus pacientes para que puedan realizar la descarga desde este sitio <a href="${this.dominio}" style="text-decoration:none;font-weight:bold;color:black; ">www.google.com</a>`, "success");
      var btn_confirm = document.querySelector('.swal2-confirm')
      btn_confirm.addEventListener('click',()=>{
        window.location =this.dominio
      })
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
}
.invalida {
  background-color: #f8d7da;
  border-color: #f5c6cb;
  font-weight: bold;
  text-align: center;
  padding: .2rem;
  border-radius: 5px;
  font-size: 1.1rem;
  display: flex;
  align-items: center;
}
.invalida .errors{
  color: #721c24;
}
#especialidad{
  color: #155724;
}

#especialidad span{
  font-weight: 700;
}
.registro{
  height: 100vh;
}


</style>