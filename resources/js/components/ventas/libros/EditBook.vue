<template>
    <div class="container px-4">
        <h1 class="mt-4 mb-4">Editar Libro</h1>
        <div class="ml-2 col-lg-12 col-md-8 my-3">
            <form class="" method="POST" v-on:submit.prevent="updateBook()" enctype="multipart/form-data">
                <div class="row">
                    <div class="form-group mb-3 col-md-4">
                        <label for="exampleInputEmail1" class="mb-1">Nombre</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" v-model="name"
                            aria-describedby="emailHelp" validate />
                        <div v-if="errors && errors.nombre">
                            <p class="errors">{{ errors.nombre[0] }}</p>
                        </div>
                    </div>
                    <div class="form-group mb-3 col-md-4">
                        <label for="exampleInputEmail1" class="mb-1">Autor</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" v-model="author"
                            aria-describedby="emailHelp" validate />
                        <div v-if="errors && errors.nombre">
                            <p class="errors">{{ errors.nombre[0] }}</p>
                        </div>
                    </div>
                    <div class="form-group mb-3 col-md-4">
                        <label for="exampleInputEmail1" class="mb-1">Precio</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" v-model="price"
                            aria-describedby="emailHelp" validate />
                        <div v-if="errors && errors.nombre">
                            <p class="errors">{{ errors.nombre[0] }}</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group mb-3 col-md-4">
                        <label for="exampleInputEmail1" class="mb-1">Puntos</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" v-model="points"
                            aria-describedby="emailHelp" validate />
                        <div v-if="errors && errors.nombre">
                            <p class="errors">{{ errors.nombre[0] }}</p>
                        </div>
                    </div>
                    <div class="form-group mb-3 col-md-4">
                        <label for="inputState" class="mb-1">Categoria</label>
                        <select id="inputState" class="form-select" v-model="category">
                            <option value="">---Selecionar---</option>
                            <option v-for="cla in Categories" :value="cla.id" :key="cla.id">{{ cla.name }}</option>
                        </select>
                        <div v-if="errors && errors.clasificacion">
                            <p class="errors">{{ errors.clasificacion[0] }}</p>
                        </div>
                    </div>

                    <div class="form-group mb-3 col-md-4">
                        <label for="inputState" class="mb-1">Estado</label>
                        <select id="inputState" class="form-select" v-model="active">
                            <option value="1" selected>Activo</option>
                            <option value="2">Inactivo</option>
                        </select>
                    </div>

                </div>
                <div class="row">
                    <div class="form-group mb-3 col-md-4">
                        <label for="exampleFormControlTextarea1" class="mb-1">Descripción</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" v-model="description"
                            rows="3"></textarea>
                        <div v-if="errors && errors.descripcion">
                            <p class="errors">{{ errors.descripcion[0] }}</p>
                        </div>
                    </div>
                    <div class="form-group mb-3 col-md-4">
                        <label for="exampleFormControlFile2" class="mb-1 d-flex flex-column">Agregar Portada</label>
                        <input type="file" class="form-control" id="exampleFormControlFile2" @change="subirImage" />
                        <div v-if="errors && errors.portada">
                            <p class="errors">{{ errors.portada[0] }}</p>
                        </div>
                    </div>
                    <div class="form-group mb-3 col-md-4">
                        <label for="exampleFormControlFile1" class="mb-1 d-flex flex-column">Agregar PDF</label>
                        <input type="file" class="form-control" id="exampleFormControlFile1" @change="subirPdf" />
                        <div v-if="errors && errors.pdf">
                            <p class="errors">{{ errors.pdf[0] }}</p>
                        </div>
                    </div>

                </div>


                <button type="submit" class="btn btn-dark mt-3">
                    <span v-if="showText">Guardar</span>
                    <div v-if="showSpinner" class="spinner-border text-light spinner-border-sm" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </button>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            name: '',
            image: '',
            category: '',
            author: '',
            description: '',
            price: '',
            points: 0,
            active: 1,
            Categories: [],
            showText: true,
            showSpinner: false,
            uuid:this.$route.params.id
        }
    }, created() {
        this.getBook()
        this.getCategory()
    }, methods: {
        async getBook(){
            try {
                const {data} = await axios.get('/api/get/book/'+this.uuid)
                if(!data.error){
                    this.name = data.data.name
                    this.author = data.data.author
                    this.price = data.data.price
                    this.points = data.data.points
                    this.category = data.data.category_id
                    this.active = data.data.active
                    this.description = data.data.description
                }
            } catch (error) {
                console.log(error)
            }
        },
        async updateBook() {
            try {
                this.showText = false
                this.showSpinner = true
                const config = { headers: { "content-type": "multipart/form-data" } };
                let data = new FormData();
                data.append("name", this.name);
                data.append("image", this.image);
                data.append("category_id", this.category);
                data.append("author", this.author);
                data.append("description", this.description);
                data.append("price", this.price);
                data.append("points", this.points);
                data.append("active", this.active);
                data.append("pdf", this.pdf)

                await axios
                    .post("/api/update/book/"+this.uuid, data, config)
                this.showSpinner = false
                this.showText = true
                this.success()
                setTimeout(() => {
                    this.$router.push('/admin/sale/list/book');
                }, 1000);
            } catch (error) {
                this.showSpinner = false
                this.showText = true
                console.log(error)
            }
        }, subirImage(e) {
            this.image = e.target.files[0]
        }, subirPdf(e) {
            this.pdf = e.target.files[0]
        },
        success() {
            Swal.fire("Correcto", "Libro creado correctamente", "success");
        },
        async getCategory() {
            try {
                const { data } = await axios.get('/api/catalog/category/books')
                console.log(data)
                this.Categories = data
            } catch (error) {
                console.log(error)
            }
        }
    }
}
</script>

<style></style>