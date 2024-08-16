@extends('marketplace.app')

@section('content-mkt')
<div class="container-fluid bg-white mt-3">
    <div class="row pt-3 justify-content-center">
        <div class="col-md-8 col-sm-12">
            <div class="card mb-3 border-0">
                <div class="row g-0">
                    <div class="col-md-4 col-sm-12">
                        <img src="{{ $book->image }}" class="img-fluid rounded" alt="Libro" style="min-height:440px">
                    </div>
                    <div class="col-md-8 col-sm-12">
                        <div class="card-body">
                            <h2 class="card-title color-p fw-bold">{{ $book->name }}</h2>
                            <h5 class="color-s">Autor: {{ $book->author }}</h5>
                            {{--  <img src="{{asset('/img/5-estrellas.png')}}" class="img-fluid" alt="ranking"
                            width="100px"> --}}
                            <p class="text-muted mt-2 m-0 p-0">Categoria: {{ $book->category->name }}</p>
                            {{-- <p class="text-muted m-0 p-0">Número páginas: 00</p> --}}
                            <hr>
                            <p class="fw-bold">Sipnosis</p>
                            <p class="card-text" style="text-align:justify">{{ $book->description }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-12">
            <show-comprar name="{{ $book->name }}" uuid="{{ $book->uuid }}" user="{{ auth()->user() ?? null }}" />
        </div>
    </div>
    {{--         <div class="row pt-3">
        <div class="col-md-12 col-sm-12 pb-3">
            <hr width="87%">
            <h4>Libros mejores catalogados</h4>
        </div>
        <div class="col-md-1 col-sm-12 ">
            <div class="card border-light " style="width: 140px;">
                <img src="{{asset('/libros/caratulas/libro1.jpg')}}" class="img-fluid mx-auto d-block" alt="Libro"
    width="140" heigth="266">
    <div class="card-body text-center p-0">
        <a href="/marketplace/detalle" class="text-decoration-none">
            <p class="color-p fw-bold p-0 m-0">Psicología médica y comunicación</p>
        </a>
        <a href="" class=" btn btn-outline-success btn-sm text-center">
            <img src="{{asset('/img/shop.svg')}}" alt="buscar" width="20"> Añadir</a>
    </div>
</div>
</div>
</div> --}}
@endsection