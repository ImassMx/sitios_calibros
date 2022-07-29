require('./bootstrap');
import axios from 'axios';
import VueAxios from 'vue-axios';
import {createApp} from 'vue'
import {router} from './router/router'

import CrearLibros from './components/libros/CrearLibros.vue'
import ListarLibros from './components/libros/ListarLibros.vue'
import CrearLigas from './components/ligas/CrearLigas.vue'
import ListarLigas from './components/ligas/ListarLigas.vue'
import EditarLibros from './components/libros/EditarLibros.vue'
import ListaReporte from './components/reporte/ListaReporte.vue'
import ZonaDescarga from './components/principal/ZonaDescarga.vue'
import CrearUsuario from './components/usuarios/CrearUsuario.vue'
import EditarLigas from './components/ligas/EditarLigas.vue'
import ListarUsuarios from './components/usuarios/ListarUsuario.vue'
import RegistrarDoctor from './components/doctor/RegistrarDoctor.vue'
import CrearClasificacion from './components/clasificacion/CrearClasificacion.vue'
import ListarClasificacion from './components/clasificacion/ListarClasificacion.vue'
import EditarClasificacion from './components/clasificacion/EditarClasificacion.vue'
import RegistrarCliente from './components/cliente/RegistrarCliente.vue'
import ReporteClientes from './components/reporte/ListaReporte.vue'
import ReporteDoctores from './components/reporte/ListaDoctores.vue'
import ZonaDoctor from './components/doctor/ZonaDoctor.vue'
import LaravelVuePagination from 'laravel-vue-pagination';

const app = createApp({})


app.use(router)
app.use(VueAxios,axios)
app.component('CrearLibros', CrearLibros)
app.component('ListarLibros', ListarLibros)
app.component('CrearLigas', CrearLigas)
app.component('ListarLigas', ListarLigas)
app.component('EditarLibros', EditarLibros)
app.component('ListaReporte', ListaReporte)
app.component('ZonaDescarga', ZonaDescarga)
app.component('CrearUsuario', CrearUsuario)
app.component('EditarLigas', EditarLigas)
app.component('ListarUsuarios', ListarUsuarios)
app.component('CrearClasificacion', CrearClasificacion)
app.component('ListarClasificacion', ListarClasificacion)
app.component('EditarClasificacion', EditarClasificacion)
app.component('Pagination', LaravelVuePagination)
app.component('RegistrarDoctor', RegistrarDoctor)
app.component('RegistrarCliente', RegistrarCliente)
app.component('ReporteClientes', ReporteClientes)
app.component('ReporteDoctores', ReporteDoctores)
app.component('ZonaDoctor', ZonaDoctor)

app.mount('#app')