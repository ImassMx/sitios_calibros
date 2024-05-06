<template>
    <div class="container">
       
        <h1 class="title">Pacientes</h1>
        <div class="content-btn">
            <a  :href="`/zona/doctor/${uuid}`" class="btn-custom"> 
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
            Perfil</a>
        </div>
        <input type="text" class="search" placeholder="Buscar..."  @keyup="buscarCliente" v-model="buscardor" >
        <table class="table">
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Libro</th>
                    <th>Descargas</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="book in Books" :key="book.id">
                    <td>{{ book.client.user.name }}</td>
                    <td>{{ book.book.name }}</td>
                    <td>{{ book.donwloads }}</td>
                    <td><button class="delete-button" @click="deleteBook(book.id)">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                fill="none" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-trash-2">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path
                                    d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                </path>
                                <line x1="10" y1="11" x2="10" y2="17"></line>
                                <line x1="14" y1="11" x2="14" y2="17"></line>
                            </svg>
                        </button></td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    props: ["uuid"],
    data() {
        return {
            Books: [],
            buscador:"",
            timeBuscador: "",
        }
    },
    created() {
        this.getPacientesDoctor()
    },
    methods: {
        async getPacientesDoctor() {
            try {
                const { data } = await axios.get('/api/show/pacientes/' + this.uuid,{params:{buscador:this.buscador}})
                if (!data.error) {
                    this.Books = data.data
                }
            } catch (error) {
                console.log(error)
            }
        },
        deleteBook(id) {
            Swal.fire({
                title: "¿estas seguro que deseas eliminar?",
                text: "Despues de eliminar ya no se puede revertir",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si",
                cancelButtonText: "Cancelar"
            }).then(async (result) => {
                if (result.isConfirmed) {
                    try {
                        const { data } = await axios.delete('/api/delete/book/'+id)
                        if (!data.error) {
                            this.getPacientesDoctor()
                            Swal.fire({
                                title: "Eliminado",
                                text: data.message,
                                icon: "success"
                            });
                        }
                    } catch (error) {

                    }
                }
            });
        },
        buscarCliente(){
            clearTimeout(this.timeBuscador);
            this.timeBuscador = setTimeout(this.getPacientesDoctor, 360);
        }
    }
}
</script>

<style scoped>
.container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
}

.title {
    text-align: center;
}

.search {
    width: 100%;
    padding: 10px;
    margin-top: 10px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.table {
    width: 100%;
    border-collapse: collapse;
}

.table th,
.table td {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: left;
}

.table th {
    background-color: #f2f2f2;
}

.delete-button {
    background-color: red;
    color: white;
    border: none;
    padding: 8px 10px;
    border-radius: 5px;
    cursor: pointer;
    display: flex;
    justify-content: center;
    align-items: center;
}

.delete-button:hover {
    background-color: #cc4b39;
}

.content-btn{
    margin: 2rem 0;
}

.btn-custom {
    background-color: #5D025F;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    text-decoration: none;
}
</style>