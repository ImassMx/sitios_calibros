import {
    createRouter,
    createWebHistory
} from "vue-router";

const routes = [{
        path: '/admin/create-libros',
        component: () => import('../components/libros/CrearLibros.vue')
    },
    {
        path: '/admin/listar-libros',
        component: () => import('../components/libros/ListarLibros.vue')
    },
    {
        path: '/admin/ligas',
        component: () => import('../components/ligas/CrearLigas.vue')
    },
    {
        path: '/admin/listar-ligas',
        component: () => import('../components/ligas/ListarLigas.vue')
    },
    {
        path: '/admin/editar/:id',
        component: () => import('../components/libros/EditarLibros.vue')
    },
    {
        path: '/admin/reporte',
        component: () => import('../components/reporte/ListaReporte.vue')
    },
    {
        path: '/admin/crear-usuario',
        component: () => import('../components/usuarios/CrearUsuario.vue')
    },
    {
        path: '/admin/editar-liga/:id',
        component: () => import('../components/ligas/EditarLigas.vue')
    },
    {
        path: '/admin/listar-usuarios',
        component: () => import('../components/usuarios/ListarUsuario.vue')
    },
    {
        path: '/admin/editar-usuario/:id',
        component: () => import('../components/usuarios/EditarUsuario.vue')
    },
    {
        path: '/admin/crear-clasificacion',
        component: () => import('../components/clasificacion/CrearClasificacion.vue')
    },
    {
        path: '/admin/reporte/pacientes',
        component: () => import('../components/reporte/ListaReporte.vue')
    }, {
        path: '/admin/reporte/doctores',
        component: () => import('../components/reporte/ListaDoctores.vue')
    },
    {
        path: '/admin/sale/list/book',
        component: () => import('../components/ventas/libros/ListBook.vue')
    },
    {
        path: '/admin/sale/create/book',
        name:'sale.create.book',
        component: () => import('../components/ventas/libros/CreateBook.vue')
    },
    {
        path: '/admin/sale/edit/book/:id',
        name:'sale.edit.book',
        component: () => import('../components/ventas/libros/EditBook.vue')
    },
    {
        path: '/admin/show/categories',
        name:'show.categories',
        component: () => import('../components/clasificacion/ListarClasificacion.vue')
    },
    {
        path: '/admin/edit/categories/:id',
        name:'edit.categories',
        component: () => import('../components/clasificacion/EditarClasificacion.vue')
    },
    {
        path: '/admin/reporte/libros/doctores',
        component: () => import('../components/reporte/LibrosDoctores.vue')
    },
    {
        path: '/admin/reporte/libros/pacientes',
        component: () => import('../components/reporte/LibrosPacientes.vue')
    },
    {
        path: '/admin/reporte/libros/conamege',
        component: () => import('../components/reporte/Conamege.vue')
    }

]

export const router = createRouter({
    history: createWebHistory(),
    routes
})
