<template>
       
            <li class="nav-item">
                <a class="nav-link menu-style" aria-current="page" :href="`/zona/doctor/${uuid}`">Mis libros</a>
            </li>
            <li class="nav-item">
                <a class="nav-link menu-style" aria-current="page" href="/marketplace">Marketplace</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle menu-style" data-bs-toggle="dropdown" href="#" role="button"
                    aria-expanded="false">Mi Cuenta</a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item fw-bold"
                             :href="`/editar/doctor/${uuid}`">Editar perfil</a></li>
                    <li><a class="dropdown-item fw-bold" :href="`/pacientes/doctor/${uuid}`">Mis pacientes</a></li>  
                </ul>
            </li>  
</template>

<script>
import axios from 'axios';
export default {
    props: ["user"],
    data() {
        return {
            uuid:''
        }
    },    
    created() {
        this.getUuid()
    },
    methods: { 
         async getUuid() {
            try {
                const { data } = await axios.get('/api/show/uuid/' + this.user)
                this.uuid = data
            } catch (error) {
                Swal.fire(error.response.data.message);
            }
        },
    }, 
        
}
</script>