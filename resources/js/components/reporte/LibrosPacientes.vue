<template>
    <div class="container-fluid px-4">
        <h1 class="mt-4 mb-3">Libros Paciente</h1>

        <a href="/export/books/paciente" class="btn btn-outline-success mb-3" download="Doctores.xlsx">Exportar Reporte</a>
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
                                <th scope="col">CÓDIGO</th>
                                <th scope="col">NOMBRES Y APELLIDOS</th>
                                <th scope="col">CÓDIGO POSTAL</th>
                                <th scope="col">ALCALDIA</th>
                                <th scope="col">CIUDAD</th>
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
                                <td>{{ doc.client.sepomex?.d_mnpio }}</td>
                                <td>{{ doc.client.sepomex?.d_ciudad }}</td>
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
        }
    },
    mounted() {
        this.getBookPaciente()
    },
    methods: {
        async getBookPaciente(page = 1) {
            try {
                const { data } = await axios.get('/api/report/books/paciente?page=' + page, { params: { buscador: this.buscador } })
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
    }

};
</script>

<style></style>