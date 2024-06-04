<template>
    <div class="container-fluid bg-white mt-3">
        <div class="row pt-3">
            <div class="col-md-2 col-sm-12 pt-1">
                <label class="fw-bold color-p">Líneas Terapéuticas</label> 
                <div class="form-check" v-for="cat in Categories" :key="cat.id">
                    <input class="form-check-input" type="checkbox" :value="cat.id" v-model="categories"
                        @change="selectCategories">
                    <label class="form-check-label categoria" for="flexCheckDefault">
                        {{ cat.name }}
                    </label>
                </div>
            </div>
            <div class="col-md-10 col-sm-12 pb-3">
                <div class="row">
                    <div class="col-md-9 col-sm-12 pb-0">
                        <h1><img src="/img/book.svg" class="img-fluid" alt="Libro" width="40">
                            Libros disponibles</h1>
                        <div class="input-group mb-2">
                            <button class="input-group-text backg-s"><img src="/img/search.svg" alt="buscar"
                                    width="20"></button>
                            <input type="text" class="form-control" aria-label="Busar" placeholder="Buscar"
                                v-model="buscador" @keyup="buscarLibros">
                        </div>
                    </div> 
                </div>
                <div class="row row-cols-1 row-cols-md-4 g-4">
                    <div class="col" v-for="book in Books.data" :key="book.id">
                        <div class="card h-100 ">
                            <div class="card-header bg-white" style="max-height:270px;min-height:270px">
                                <a :href="`/marketplace/detalle/${book.uuid}`" class="btn btn-sm p-1"
                                style="cursor: pointer;">
                                    <img :src="book.image" class="card-img-top" alt="Portada" style="max-height:254px;">
                                </a>
                            </div>
                            <div class="card-body bg-white">
                            <h5 class="card-title text-lowercase color-p fw-bold" style="font-size:18px">{{ book.name }}</h5>
                            <h6 class="card-subtitle mb-2 text-muted"> $ {{ book.price }}</h6>
                            <a :href="`/marketplace/detalle/${book.uuid}`" class="btn btn-sm p-1"
                                style="cursor: pointer;">
                                <img src="/img/shopping.svg" alt="buscar" width="20"> Comprar
                            </a>
                            <a @click="addToBook(book.uuid)" class="btn btn-outline-success btn-sm"
                                style="cursor: pointer;">
                                <img src="/img/shop.svg" alt="buscar" width="20"> Añadir a carrito
                            </a>
                            </div>
                        </div> 
                        
                    </div>

                </div>
            </div>
        </div> 
        <Pagination :data="Books" @pagination-change-page="getBooks" class="d-flex justify-content-center" />
    </div>
</template>

<script>

export default {
    props: ["user"],
    data() {
        return {
            Categories: [],
            Books: [],
            buscador: "",
            timeBuscador: "",
            categories: [],
            pagination: 1
        }
    }, created() {
        this.getCategories()
        this.getBooks()
    }, methods: {
        async getCategories() {
            try {
                const { data } = await axios.get('/api/catalog/categories/marketplace')
                this.Categories = data
            } catch (error) {
                console.log(error)
            }
        }, async getBooks(page = 1) {
            try {
                const { data } = await axios.get('/api/catalog/books/marketplace?page=' + page, { params: { search: this.buscador, categoria: this.categories } })
                this.Books = data
            } catch (error) {
                console.log(error)
            }
        }, addToBook(uuid) {
            this.$store.dispatch('addToCart', { uuid: uuid, user: this.user })
        },
        buscarLibros() {
            clearTimeout(this.timeBuscador);
            this.timeBuscador = setTimeout(this.getBooks, 360);
        },
        async selectCategories() {
            await this.getBooks()
        }
    },
    computed: {
        isCart() {
            return this.$store.state.cart
        }
    }
}
</script>

<style>
.contenido-informacion{
    text-align: start;
    font-size: 12px;
}
</style>