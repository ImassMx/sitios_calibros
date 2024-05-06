<template>
    <div class="card">
        <div class="card-header">
            <h2>{{ Book.book.name }}</h2>
        </div>
        <div class="card-body">
            <img :src="`${Book.book.image}`" alt="Imagen de ejemplo" class="image-card">
            <p>Contraseña: <b>{{ Book.book.password }}</b></p>
        </div>
        <div class="card-footer">
            <a :href="`/donwload/book/paciente/${Book.book.uuid}?client_books=${Book.id}`" class="btn-email">Descargar</a>
        </div>
    </div>
</template>

<script>
export default {
    props: ["book"],
    data(){
        return{
            Book:{}
        }
    },
    created(){
        this.Book = JSON.parse(this.book);
    }
}
</script>

<style scoped>
.card {
    width: calc(33.33% - 20px);
    margin-bottom: 20px;
    border: 1px solid #ddd;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    background-color: #fff;
}
.card-header{
    text-align: center;
}
.card-body{
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}
.image-card{
    width: 200px !important;
    height: 200px !important;
}
.btn-email{
    color: white;
    text-decoration: none;
}

.card-footer{
    display: flex;
    justify-content: center;
}
</style>