<template>
    <div class="container-fluid ">
      <div class="row">
        <h1 class="mt-4 mb-3">Reporte Conamege</h1>
        <div class="col-md-12 col-sm-12 ">
          <div class="card mb-4">
            <div class="card-body w-100">
                <div class="form-group col-md-4 mb-3">
                  <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                    placeholder="Buscar" v-model="buscador" @keyup="buscarCliente" />
                </div>
                <div class="table-responsive">
                    <table class="table table-sm w-100">
                      <thead>
                        <tr class="text-left" style="font-size:14px!important">
                          <th scope="col">Contraseña del libro</th>
                          <th scope="col" colspan="2">Nombre del médico</th>
                          <th scope="col">Especialidad</th>
                          <th scope="col">Folio del médico</th>
                          <th scope="col">Fecha de descarga</th>
                          <th scope="col">Código postal</th>
                          <th scope="col">Alcaldia</th>
                          <th scope="col">Ciudad</th>
                          <th scope="col" colspan="2">Nombre paciente</th>
                          <th scope="col">Código postal</th>
                          <th scope="col">Alcaldia</th>
                          <th scope="col">Ciudad</th>
                          <th scope="col">Descargas mes</th>
                          <th scope="col">Descargas acumuladas</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="client in books.data" :key="client.id">
                          <td>{{ client.book.password }}</td>
                          <td colspan="2">{{ client.doctor.nombres }} {{ client.doctor.apellidos }}</td>
                          <td>{{ client.doctor.especialidad.nombre }}</td>
                          <td>{{ client.doctor.folio }}</td>
                          <td>{{ formatDate(client.created_at) }}</td>
                          <td>{{ client.doctor.cp}}</td>
                          <td>{{ client.doctor.sepomex?.d_mnpio}}</td>
                          <td>{{ client.doctor.sepomex?.d_ciudad}}</td>
                          <td colspan="2">{{ client.client.nombre_doctor}}</td>
                          <td>{{ client.client.codigo_postal}}</td>
                          <td>{{ client.client.sepomex?.d_mnpio}}</td>
                          <td>{{ client.client.sepomex?.d_ciudad}}</td>
                          <td>{{ client.total_books_month}}</td>
                          <td>{{ client.total_books_total}}</td>
                        </tr>
                      </tbody>
                    </table>
                </div>
                <Pagination :data="books" @pagination-change-page="traerReporte" class="d-flex justify-content-center" />
            </div>

          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        books: {},
        buscador: "",
        timeBuscador: "",
      };
    },
    mounted() {
      this.traerReporte();
    },
    methods: {
      traerReporte(page = 1) {
        axios
          .get("/api/show/reporte/conamege?page=" + page, {
            params: { buscador: this.buscador },
          })
          .then((res) => {
            this.books = res.data;
          });
      },
      buscarCliente() {
        clearTimeout(this.timeBuscador);
        this.timeBuscador = setTimeout(this.traerReporte, 360);
      },formatDate(date){
            const createdAtDate = new Date(date);

            // Opciones de formateo
            const options = {
                year: 'numeric',
                month: 'numeric',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            };

        
            return new Intl.DateTimeFormat('en-EN', options).format(createdAtDate);
        }
    },
  };
  </script>
  
  <style></style>