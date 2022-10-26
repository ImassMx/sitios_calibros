<template>
  <div class="container-fluid px-4">
    <h1 class="mt-4 mb-3">Listar Usuarios</h1>
    <div>
      <div class="card mb-4">
        <div class="card-body">
          <div class="form-group col-md-4 mb-3">
            <input
              type="text"
              class="form-control"
              id="exampleInputEmail1"
              aria-describedby="emailHelp"
              placeholder="Buscar"
              v-model="buscador"
              @keyup="buscarUsuario"
            />
          </div>
          <table class="table">
            <thead>
              <tr>
                <th class="text-center" scope="col">ID</th>
                <th class="text-center" scope="col">NOMBRE</th>
                <th class="text-center" scope="col">USUARIO</th>
                <th class="text-center" scope="col">ROL</th>
                <th class="text-center" scope="col">ACCION</th>
              </tr>
            </thead>
            <tbody v-for="user in usuarios.data" :key="user.id">
              <tr>
                <th scope="row">{{ user.id }}</th>
                <td>{{ user.name }}</td>
                <td>{{ user.email }}</td>
                <td>{{ user.roles[0].name }}</td>
                <td class="d-flex justify-content-center gap-2">
                  <router-link
                    :to="`/admin/editar-usuario/${user.id}`"
                    class="btn btn-outline-primary"
                    >Editar</router-link
                  >

                  <a @click="eliminar(user.id)" class="btn btn-outline-danger">
                    Eliminar
                  </a>
                </td>
              </tr>
            </tbody>
          </table>
          <Pagination
            :data="usuarios"
            @pagination-change-page="buscarUser"
            class="d-flex justify-content-center"
          />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      usuarios: {},
      buscador: "",
      timeBuscador: "",
    };
  },
  mounted() {
    this.buscarUser();
  },
  methods: {
    buscarUser(page = 1) {
      axios
        .get("/api/usuarios?page=" + page, {
          params: { buscador: this.buscador },
        })
        .then((response) => {
          this.usuarios = response.data;
          console.log(response.data);
        });
    },
    buscarUsuario() {
      clearTimeout(this.timeBuscador);
      this.timeBuscador = setTimeout(this.buscarUser, 360);
    },
    eliminar(id) {
      Swal.fire({
        title: "¿Estas seguro que deseas eliminar?",
        text: "Después de eliminar ya no podrá revertirse.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si",
        cancelButtonText: 'Cancelar',
      }).then((result) => {
        if (result.isConfirmed) {
          this.axios
        .delete("/delete-user/" + id)
        .then((response) => this.buscarUser())
        .catch((error) => console.log(error));
          Swal.fire("Eliminado", "Se elimino correctamente el usuario", "success");
        }
      });
      
    },
  },
};
</script>

<style>
</style>