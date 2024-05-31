<template>
    <div class="container-fluid px-4">
        <h1 class="mt-4 mb-3">Ventas</h1>

        <a href="/export/books/ventas" class="btn btn-outline-success mb-3" download="Libros Doctores.xlsx">Exportar Reporte</a>
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
                                <th scope="col">CANTIDAD COMPRADA</th>
                                <th scope="col">COSTO UNITARIO</th>
                                <th scope="col">IMPORTE PAGADO</th>
                                <th scope="col">FECHA COMPRA</th>
                                <th scope="col">FÓLIO MEDICO</th>
                                <th scope="col">NOMBRES APELLIDOS</th>
                                <th scope="col">CÓDIGO POSTAL</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="doc in Books.data" :key="doc.id">
                                <th scope="row">{{ doc.book.password }}</th>
                                <td>1</td>
                                <td>{{ doc.book.price }}</td>
                                <td>{{ doc.book.price }}</td>
                                <td>{{ formatDate(doc.created_at)}}</td>
                                <td>{{ doc.doctor.folio }}</td>
                                <td>{{ doc.doctor.nombres }} {{ doc.doctor.apellidos }}</td>
                                <td>{{ doc.doctor.cp }}</td>
                            </tr>
                        </tbody>
                    </table>
                    </div>
                    <Pagination :data="Books" @pagination-change-page="getBooksVentas"
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
        this.getBooksVentas()
    },
    methods: {
        async getBooksVentas(page = 1) {
            try {
                const { data } = await axios.get('/api/show/reporte/ventas?page=' + page, { params: { buscador: this.buscador } })
                this.Books = data
            } catch (error) {
                console.log(error)
            }
        },
        buscarDoctor() {
            clearTimeout(this.timeBuscador);
            this.timeBuscador = setTimeout(this.getBooksVentas, 360);
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