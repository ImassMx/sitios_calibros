<template>
    <div class="container-fluid px-4">
        <h1 class="mt-4 mb-3">Libros Doctores</h1>

        <a href="/export/books/doctor" class="btn btn-outline-success mb-3" download="Libros Doctores.xlsx">Exportar Reporte</a>
        <div>
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex gap-4 col-md-4 mb-3">
                        <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                            placeholder="Buscar" v-model="buscador" @keyup="buscarDoctor" />
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">DOCTOR</th>
                                <th scope="col">LIBRO</th>
                                <th scope="col">DESCARGAS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="doc in Books.data" :key="doc.id">
                                <th scope="row">{{ doc.id }}</th>
                                <td>{{ doc.user.name }}</td>
                                <td>{{ doc.book.name }}</td>
                                <td>{{ doc.donwloads }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <Pagination :data="Books" @pagination-change-page="getBooksDoctors"
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
        this.getBooksDoctors()
    },
    methods: {
        async getBooksDoctors(page = 1) {
            try {
                const { data } = await axios.get('/api/report/books/doctor?page=' + page, { params: { buscador: this.buscador } })
                this.Books = data
            } catch (error) {
                console.log(error)
            }
        },
        buscarDoctor() {
            clearTimeout(this.timeBuscador);
            this.timeBuscador = setTimeout(this.getBooksDoctors, 360);
        }
    }

};
</script>

<style></style>