<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/estilos.css') }}" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>

</head>

<body class="sb-nav-fixed">
    <div id="app">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3 text-center" href="#"><img
                    src="{{ asset('img/logo.jpg') }}" class="logo" alt=""></a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i
                    class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <div class="input-group">

                </div>
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-4 me-lg-4">
                <li class="nav-item dropdown me-5">
                    <a class="nav-link dropdown-toggle"  id="dropdownMenu2" role="button" data-toggle="dropdown" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenu2" >
                      {{--   <li><a class="dropdown-item" href="#!">{{auth()->user()->name}}</a></li> --}}
                        <li>
                        <form method="POST" action="{{route('logout')}}">
                        @csrf
                            <input class="dropdown-item" type="submit" value="Cerrar Sesion">
                        </form>
                        
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">

                            <div class="sb-sidenav-menu-heading"></div>
                            @can('usuarios')
                            <a class="nav-link collapsed text-white" href="#" data-bs-toggle="collapse"
                                data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-users text-white"></i></div>
                                USUARIOS
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            
                                <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne"
                                data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <router-link class="nav-link text-white" to="/admin/crear-usuario">Crear Usuarios</router-link>
                                    <router-link class="nav-link text-white" to="/admin/listar-usuarios">Ver Usuarios</router-link>
                                </nav>
                            </div>
                            @endcan
                           @can('libros')
                                <a class="nav-link collapsed text-white" href="#" data-bs-toggle="collapse"
                                data-bs-target="#collapsebook" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-book text-white"></i></div>
                                LIBROS
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapsebook" aria-labelledby="headingOne"
                                data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <router-link to="/admin/sale/create/book" class="nav-link text-white">Crear Libro</router-link>
                                    <router-link to="/admin/sale/list/book" class="nav-link text-white">Lista de Libros</router-link>
                                    <router-link to="/admin/crear-clasificacion" class="nav-link text-white">Crear Categoria</router-link>
                                    <router-link to="/admin/show/categories" class="nav-link text-white">Lista de Categorias</router-link>
                                </nav>
                            </div>
                           @endcan
{{--                             @can('ligas')
                                <a class="nav-link collapsed text-white" href="#" data-bs-toggle="collapse"
                                data-bs-target="#collapseligas" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-link text-white"></i></div>
                                CLIENTES
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseligas" aria-labelledby="headingOne"
                                data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <router-link to="/admin/ligas" class="nav-link text-white">Crear Cliente</router-link>
                                    <router-link to="/admin/listar-ligas" class="nav-link text-white">Lista de Clientes</router-link>
                                </nav>
                            </div>
                            @endcan --}}
                            <a class="nav-link collapsed text-white" href="#" data-bs-toggle="collapse"
                                data-bs-target="#collapsereporte" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-table text-white"></i></div>
                                REPORTES
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapsereporte" aria-labelledby="headingOne"
                                data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <router-link to="/admin/reporte/doctores" class="nav-link text-white">Doctores</router-link>
                                    <router-link to="/admin/reporte/pacientes" class="nav-link text-white">Pacientes</router-link>
                                    <router-link to="/admin/reporte/libros/doctores" class="nav-link text-white">Libros Doctores</router-link>
                                    <router-link to="/admin/reporte/libros/pacientes" class="nav-link text-white">Libros Pacientes</router-link>
                                </nav>
                            </div>
{{-- 
                            <a class="nav-link collapsed text-white" href="#" data-bs-toggle="collapse"
                                data-bs-target="#collapseVentas" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-table text-white"></i></div>
                                VENTAS
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseVentas" aria-labelledby="headingOne"
                                data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <router-link to="/admin/sale/list/book" class="nav-link text-white">Libros</router-link>
                                    <router-link to="/admin/reporte/doctores" class="nav-link text-white">Categorias</router-link>
                                    <router-link to="/admin/reporte/pacientes" class="nav-link text-white">Reporte de Ventas</router-link>
                                </nav>
                            </div> --}}
                        </div>
            
                    </div>

                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <router-view></router-view>
                </main>
            </div>

            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        {{-- <div class="text-muted">Copyright &copy; Your Website 2022</div> --}}

                    </div>
                </div>
            </footer>
        </div>
    </div>
    </div>
    <style>
        .dataTable-info {
            display: none;
        }

        .logo {
            width: 70px
        }

    </style>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/chart-area-demo.js') }}"></script>
    <script src="{{ asset('js/chart-bar-demo.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
    <script src="{{ asset('js/datatables-simple-demo.js') }}"></script>
    <script src="{{ asset('js/datatables-demo.js') }}"></script>
    <script src="{{ asset('js/index.js') }}"></script>
    <script src="{{ asset('js/chart-pie-demo.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script>
       $('.dropdown-toggle').dropdown()
    </script>
</body>

</html>
