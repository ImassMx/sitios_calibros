require('./bootstrap');
import axios from 'axios';
import VueAxios from 'vue-axios';
import {createApp} from 'vue'
import {router} from './router/router'
import store from './store'

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
//VENTAS
import CreateBook from './components/ventas/libros/CreateBook.vue'
import ListBook from './components/ventas/libros/ListBook.vue'
import EditBook from './components/ventas/libros/EditBook.vue'

//MARKETPLACE
import CatalogoLibros from './components/marketplace/CatalogoLibros.vue'
import ShowCarrito from './components/marketplace/ShowCarrito.vue'
import ResumenCarrito from './components/marketplace/ResumenCarrito.vue'
import ShowPago from './components/marketplace/ShowPago.vue'
import ShowComprar from './components/marketplace/ShowComprar.vue'

//PACIENTE CARD
import CardBook from './components/cliente/CardBook.vue'
//DOCTOR
import ListPaciente from './components/doctor/ListPaciente.vue'
//REPORTES
import LibrosDoctores from './components/reporte/LibrosDoctores.vue'
import LibrosPacientes from './components/reporte/LibrosPacientes.vue'
import Conamege from './components/reporte/Conamege.vue'

import ShowAviso from './components/ShowAviso.vue'


const app = createApp({})


app.use(router)
app.use(VueAxios,axios)
app.use(store)
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
//VENTAS
app.component('CreateBook', CreateBook)
app.component('ListBook', ListBook)
app.component('EditBook', EditBook)
//MARKETPLACE
app.component('CatalogoLibros', CatalogoLibros)
app.component('ShowCarrito', ShowCarrito)
app.component('ResumenCarrito', ResumenCarrito)
app.component('ShowPago', ShowPago)
app.component('ShowComprar', ShowComprar)
//PACIENTE CLIENTE
app.component('CardBook', CardBook)
app.component('ListPaciente', ListPaciente)
//REPORTE
app.component('LibrosDoctores', LibrosDoctores)
app.component('LibrosPacientes', LibrosPacientes)
app.component('Conamege', Conamege)

app.component('ShowAviso', ShowAviso)

app.mount('#app')