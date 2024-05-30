<template>
    <div class="container-fluid px-4">
        <h1 class="mt-4 mb-3">Listado de Libros</h1>
        <div>
            <router-link :to="{ name: 'sale.create.book' }" class="btn btn-outline-success mb-3">Nuevo Libro</router-link>
            <div class="card mb-4">
                <div class="card-body">
                    <div class="form-group col-md-4 mb-3">
                        <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                            placeholder="Buscar" v-model="buscador" @keyup="buscarLibros" />
                    </div>

                    <table class="table">
                        <thead>
                            <tr>

                                <th class="text-center" scope="col">NOMBRE</th>
                                <th class="text-center" scope="col">IMAGEN</th>
                                <th class="text-center" scope="col">LÍNE TERAPÉUTICA</th>
                                <th class="text-center" scope="col">PRECIO</th>
                                <th class="text-center" scope="col">PUNTOS</th>
                                <th class="text-center" scope="col">DESCARGAS</th>
                                <th class="text-center" scope="col">CONTRASEÑA LIBRO</th>
                                <th class="text-center" scope="col">ACCIÓN</th>
                            </tr>
                        </thead>
                        <tbody v-for="lib in Book.data" :key="lib.id">
                            <tr>
                                <td>{{ lib.name }}</td>
                                <td>
                                    <img :src="`${lib.image}`" alt="" class="img" />
                                </td>
                                <th class="text-center">{{ lib.category.name }}</th>
                                <th class="text-center">$ {{ lib.price }}</th>
                                <th class="text-center">{{ lib.points }}</th>
                                <th class="text-center">{{ lib.downloads }}</th>
                                <th class="text-center">{{ lib.password }}</th>
                                <th class="d-flex justify-content-center gap-2">
                                    <router-link :to="{name: 'sale.edit.book',params:{id: lib.uuid}}"
                                        class="btn btn-outline-primary">Editar</router-link>
                                    <!--                                     <a @click="desactivar(lib.id)" class="btn btn-outline-secondary"
                                        v-if="lib.estado === 1">
                                        Desactivar
                                    </a>
                                    <a @click="activar(lib.id)" class="btn btn-outline-success"
                                        v-if="lib.estado === 2">Activar</a> -->
                                    <a @click="destroBook(lib.id)" class="btn btn-outline-danger">
                                        Eliminar
                                    </a>
                                </th>
                            </tr>
                        </tbody>
                    </table>
                    <Pagination :data="Book" @pagination-change-page="getBooks" class="d-flex justify-content-center" />

                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            Book: [],
            buscador:"",
            timeBuscador:""
        }
    }, created() {
        this.getBooks()
    }, methods: {
        async getBooks(page=1) {
            try {
                const { data } = await axios.get('/api/catalog/sale/books?page='+page,{params:{buscador:this.buscador}})
                this.Book = data
            } catch (error) {
                console.log(error)
            }
        }, destroBook(id) {
            Swal.fire({
                title: "¿Estas seguro que deseas eliminar?",
                text: "Esto ya no se puede revertir",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si",
                cancelButtonText: "No"
            }).then((result) => {
                if (result.isConfirmed) {
                    this.deleteBook(id)
                    this.getBooks(1)
                }
            });
        },buscarLibros(){
            clearTimeout(this.timeBuscador);
            this.timeBuscador = setTimeout(this.getBooks, 360);
        },
        async deleteBook(id){
            try {
                await axios.post('/api/delete/book',{book:id})
            } catch (error) {
                console.log(error)
            }
        }
    }
}
</script>

<style scoped>
.img {
    width: 80px;
}
</style>