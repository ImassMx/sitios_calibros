<template>
  <div class="container px-4">
    <h1 class="mt-4">Crear Usuario</h1>
    <div class="m-5 col-lg-4 col-md-8">
      <form class="" v-on:submit.prevent="saveUser">
        <div class="form-group mb-3">
          <label for="exampleInputEmail1">Nombre</label>
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
          <label for="exampleInputPassword1">Usuario</label>
          <input type="text" class="form-control" id="exampleInputPassword1" v-model="usuario" />
          <div v-if="errors && errors.usuario">
                  <p class="errors">{{errors.usuario[0]}}</p>
                </div>
        </div>
        <div class="form-group mb-3">
          <label for="exampleInputPassword1">Contraseña</label>
          <input type="text" class="form-control" id="exampleInputPassword1" v-model="contraseña" />
          <div v-if="errors && errors.contraseña">
                  <p class="errors">{{errors.contraseña[0]}}</p>
                </div>
        </div>
        <div class="form-group mb-3">
          <label for="inputState">Rol</label>
          <select id="inputState" class="form-control" v-model="rol">
            <option value="">--- Seleccione ---</option>
            <option value="Admin">Admin</option>
            <option value="Asistente">Asistente</option>
            <option value="Ejecutivo">Ejecutivo</option>
          </select>
          <div v-if="errors && errors.rol">
                  <p class="errors">{{errors.rol[0]}}</p>
                </div>
        </div>
        <button type="submit" class="btn btn-dark mt-3">Agregar</button>
      </form>
    </div>
  </div>
</template>

<script>
export default {

  data()
  {
    return{
      nombre: '',
      usuario:'',
      contraseña:'',
      rol:'',
      errors:{}
    }
  },
  mounted()
  {

  },
  methods:{

    saveUser()
    {
      axios.post('/usuario/create',{nombre:this.nombre,usuario:this.usuario,contraseña:this.contraseña,rol:this.rol})
      .then(response => {
        this.showAlert()
        this.limpiar()
        this.errors={}
      })
      .catch(error => {
        this.errors = error.response.data.errors
      })
    },
    showAlert() {
      Swal.fire("Correcto", "Usuario creado correctamente", "success");
    },
    limpiar()
    {
      this.nombre=''
      this.contraseña=''
      this.usuario=''
      this.rol=''
    }
  }

};
</script>

<style scoped>
.errors{
  color: red;
  font-weight: bold;
}
</style>