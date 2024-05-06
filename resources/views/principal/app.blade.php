@extends('marketplace.app')

@section('content-mkt')
    <div class="container">
        <h1 class="title">{{ $paciente->user->name }}</h1>

        <div class="card-container">
            @forelse ($books as $book)
                <card-book book="{{$book}}" ></card-book>
            @empty
                <p class="title">No tienes libros agreados</p>
            @endforelse
        </div>
    </div>
@endsection
