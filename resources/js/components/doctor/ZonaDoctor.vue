<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 col-sm-12 pt-3">
                 <h1 class="text-start fw-bold"><img src="/img/doctor.svg" class="img-fluid" alt="Libro" width="40">Bienvenido(a) Dr. 
                    <span class="text-capitalize ">{{ Doctor.nombres }} {{ Doctor.apellidos }}</span></h1>
                 <h3>Mis libros comprados:</h3>
            </div>
        </div> 
        <div class="row row-cols-1 row-cols-md-4 g-4  pb-5">
                    <div class="col" v-for="book in Books" :key="book.id">
                        <div class="card bg-white h-100 p-0">
                            <div class="card-header bg-white" style="max-height:210px;min-height:210px"> 
                                <a :href="`/marketplace/detalle/${book.book.uuid}`">
                                    <img :src="book.book.image" :alt="book.name" class="card-img-top" style="max-height:195px;" >
                                </a>
                            </div>
                            <div class="card-body text-center p-1">
                            <h5 class="card-title text-capitalize color-p fw-bold mt-2" style="font-size:18px"> 
                                <a :href="`/marketplace/detalle/${book.book.uuid}`" class="card-title text-capitalize color-p fw-bold" style="font-size:16px;text-decoration: none;">{{ book.book.name }}</a></h5>
                            <h5 class="card-subtitle text-muted">Contraseña:</h5> 
                            <p class="mb-2 text-muted">{{ book.book.password }}</p> 
                            <hr class="mb-1"> 
                            <div class="dropdown">
                                <button class="btn button-style dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    Acceder a mi libro
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li><button class="dropdown-item" style="cursor: pointer;" @click="sendEmail(book.book.id)">Envíar por email</button></li>
                                    <li><button class="dropdown-item" style="cursor: pointer;" @click="sendPhone(book.book.id)">Envíar por SMS</button></li>
                                    <li><a class="dropdown-item" :href="`/donwload/book/doctor/${book.book.uuid}?purchased_book=${book.id}`">Descargar</a></li>
                                    <li><a class="dropdown-item" :href="`/download/qr/${book.book.uuid}/${book.book.name}`">Descargar QR</a></li>
                                    <li><a class="dropdown-item" :href="`/marketplace/detalle/${book.book.uuid}`">Visualizar</a></li>
                                </ul>
                            </div>  
                            </div>
                        </div> 
                        
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
 
 .button-style{
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
   
</style>