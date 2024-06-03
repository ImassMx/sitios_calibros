<template>
    <div class="container-fluid px-4">
        <h1 class="mt-4 mb-3">Libros Paciente</h1>

        <div class="row mb-3">
            <div class="col-2 col-md-3 d-flex justify-content-start align-items-end">
                <a :href="`/export/books/paciente?starDate=${startDate}&endDate=${endDate}`"
                    class="btn btn-outline-success ">Exportar Reporte</a>
            </div>
            <div class="col-2 col-md-3">
                <label for="startDate" class="form-label">Fecha de Inicio</label>
                <input type="date" class="form-control" id="startDate" name="startDate" v-model="startDate"
                    @change="updateStartDate">
            </div>
            <div class="col-2 col-md-3">
                <label for="endDate" class="form-label">Fecha de Fin</label>
                <input type="date" class="form-control" id="endDate" name="endDate" v-model="endDate"
                    @change="updateEndDate">
            </div>
            <div class="col-2 col-md-3 d-flex justify-content-start align-items-end">
                <a @click="clearFields" class="btn btn-outline-success ">Limpiar</a>
            </div>
        </div>
        <div>
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex gap-4 col-md-4 mb-3">
                        <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                            placeholder="Buscar" v-model="buscador" @keyup="buscarDoctor" />
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">CONTRASEÑA LIBRO</th>
                                <th scope="col">NOMBRE LIBRO</th>
                                <th scope="col">FOLIO MÉDICO</th>
                                <th scope="col">NOMBRES Y APELLIDOS</th>
                                <th scope="col">CÓDIGO POSTAL</th>
                                <th scope="col">FECHA DESCARGA</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="doc in Books.data" :key="doc.id">
                                <th scope="row">{{ doc.book.password }}</th>
                                <th scope="row">{{ doc.book.name }}</th>
                                <td>{{ doc.doctor.folio }}</td>
                                <td>{{ doc.client.user.name }}</td>
                                <td>{{ doc.client.codigo_postal }}</td>
                                <td>{{ formatDate(doc.created_at) }}</td>
                            </tr>
                        </tbody>
                    </table>
                    </div>
                    <Pagination :data="Books" @pagination-change-page="getBookPaciente"
                        class="d-flex justify-content-center" />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {

    data() {
        return {
            Books: [],
            buscador: "",
            timeBuscador: "",
            startDate: "",
            endDate: ""
        }
    },
    mounted() {
        this.getBookPaciente()
    },
    methods: {
        async getBookPaciente(page = 1) {
            try {
                const { data } = await axios.get('/api/report/books/paciente?page=' + page, { params: { buscador: this.buscador, startDate : this.startDate,endDate: this.endDate } })
                this.Books = data
            } catch (error) {
                console.log(error)
            }
        },
        buscarDoctor() {
            clearTimeout(this.timeBuscador);
            this.timeBuscador = setTimeout(this.getBookPaciente, 360);
        },formatDate(date){
            const createdAtDate = new Date(date);

            const options = {
                year: 'numeric',
                month: 'numeric',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            };

            return new Intl.DateTimeFormat('en-ES', options).format(createdAtDate);
        }, updateStartDate(){
      this.getBookPaciente();
    },
    updateEndDate(){
      this.getBookPaciente();
    },clearFields(){
      this.endDate = ''
      this.startDate = ''
      this.getBookPaciente()
    }
    }

};
</script>

<style></style>