<template>
    <div class="container">
        <h1 class="titulo">DR. {{ Doctor.nombres }} {{ Doctor.apellidos }}</h1>
        <div class="content-btn">
            <a  href="/marketplace" class="btn-custom"> 
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
            Tienda</a>
            <a  :href="`/pacientes/doctor/${uuid}`" class="btn-custom"> 
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
            Pacientes</a>
        </div>
        <h2 class="sub-titulo">Mis Libros :</h2>
        <div class="container-libros">
            <div class="card" v-for="book in Books" :key="book.id">
                <img :src="book.book.image" :alt="book.name" class="img-book">
                <p>{{ book.book.name }}</p>
                <p><b> Contraseña : {{ book.book.password }}</b></p>
                <a :href="`/download/qr/${book.book.uuid}/${book.book.name}`" class="btn-email" >Descargar Qr</a>
                <button class="btn-email" @click="sendEmail(book.book.id)">Enviar por Email</button>
                <button class="btn-celular" @click="sendPhone(book.book.id)">Enviar por Celular</button>
                <a :href="`/donwload/book/doctor/${book.book.uuid}?purchased_book=${book.id}`" class="btn-celular">Descargar</a>
            </div>
        </div>
    </div>

</template>

<script>
import axios from 'axios';

export default {
    props: ["uuid"],
    data() {
        return {
            mensaje: '',
            numero: '',
            nombre: '',
            folio: '',
            Doctor: [],
            Books: []
        }
    },
    created() {
        this.getInformacion()
        this.getBooks()
    },
    methods: {
        async getInformacion() {
            try {
                const { data } = await axios.get('/api/information/doctor/' + this.uuid)
                this.Doctor = data.doctor
            } catch (error) {
                Swal.fire(error.response.data.message);
            }
        },
        async getBooks() {
            try {
                const { data } = await axios.get('/api/books/doctor/' + this.uuid)
                this.Books = data
            } catch (error) {
                Swal.fire(error.response.data.message);
            }
        },
        sendPhone(book_id) {
            Swal.fire({
                title: "Ingrese el número de celular del paciente.",
                input: "text",
                inputAttributes: {
                    autocapitalize: "off"
                },
                showCancelButton: true,
                confirmButtonColor: "#5D025F",
                confirmButtonText: "Enviar",
                cancelButtonText: "Cancelar",
                showLoaderOnConfirm: true,
                preConfirm: async (phone) => {
                    try {
                        const {data} = await axios.get('/api/send/message',{params:{book_id:book_id,doctor:this.uuid,phone:phone}})
                    } catch (error) {
                        Swal.showValidationMessage(`
                        Request failed: ${error}
                        `);
                    }
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "Se envió correctamente el SMS"
                    });
                }
            });
        },
        sendEmail(book_id){
            Swal.fire({
                title: "Ingrese el email del paciente.",
                input: "text",
                inputAttributes: {
                    autocapitalize: "off"
                },
                showCancelButton: true,
                confirmButtonText: "Enviar",
                confirmButtonColor: "#5D025F",
                cancelButtonText: "Cancelar",
                showLoaderOnConfirm: true,
                preConfirm: async (email) => {
                    try {
                    const {data} = await axios.get('/api/send/email',{params:{book_id:book_id,doctor:this.uuid,email:email}})
                    
                    if(data.error){
                        return Swal.fire({ title: data.message });
                    }

                    Swal.fire({
                        title: "Se envió correctamente el email"
                    });
                    } catch (error) {
                        Swal.showValidationMessage(`
                        Request failed: ${error}
                        `);
                    }
                },
                allowOutsideClick: () => !Swal.isLoading()
            });
        }

    }
}
</script>

<style scoped>
h1,
h4 {
    text-align: center;
}

.content-form {
    display: flex;
    justify-content: center;
}

.content-form form {
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

.btn {
    padding: .4rem .5rem;
    background: rgba(0, 0, 0, 0.0);
    border: 2px solid #056743;
    color: #056743;
    cursor: pointer;
    border-radius: 5px;
    transition: all .4s;
}

.btn:hover {
    background: #056743;
    color: white;
}

.numero-cliente {
    padding: .4rem .5rem;
}

.titulo {
    margin-top: 3rem;
    margin-bottom: 3rem;
}

.container {
    width: 1200px !important;
    margin-left: 4rem;
    margin-right: 4rem;
    padding-bottom: 10rem;
}

.container-libros {
    display: flex;
    flex-wrap: wrap;
}

.card {
    flex: 0 0 calc(33.333% - 20px);
    /* Para 3 columnas con margen */
    margin: 10px;
    padding: 20px;
    background-color: #f0f0f0;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    text-align: center;
    /* Centra el contenido */
    justify-content: center;
    align-items: center;
}

.card img {
    max-width: 100%;
    height: auto;
    margin-bottom: 10px;
}

/* Estilos adicionales de la tarjeta según sea necesario */
.card p {
    margin: 0;
    font-size: 16px;
    color: #333;
}

.card button , .card a{
    margin-top: 10px;
    padding: 8px 16px;
    border: none;
    background-color: #5D025F;
    color: #fff;
    font-size: 14px;
    border-radius: 4px;
    cursor: pointer;
    text-decoration: none;
}

.card button:hover , .card a:hover{
    background-color: #0056b3;
}

.img-book {
    width: 100px;
    height: 100px;
}

.btn-custom {
    background-color: #5D025F;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    text-decoration: none;
    margin-bottom: 2rem;

}
.content-btn{
    margin-top: 1rem;
    margin-bottom: 1rem;
}
</style>