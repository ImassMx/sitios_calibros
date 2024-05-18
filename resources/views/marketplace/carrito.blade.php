@extends('marketplace.app')

@section('content-mkt')
<div class="container bg-white mt-3">
    <div class="row pt-3 justify-content-center">
        <div class="col-md-12 col-sm-12">
            <h1><img src="{{asset('/img/shop.svg')}}" alt="buscar" width="50"> Mi carrito</h1>
        </div>
        @auth
        <resumen-carrito user="{{auth()->user()->id}}"></resumen-carrito>
        @endauth
        @guest
            <h3 style="margin-top: 3rem;text-align:center">Debe Iniciar Sesión para poder ver todos los productos del carrito.</h3>
        @endguest
    </div>
</div>
@endsection