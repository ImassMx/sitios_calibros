@extends('marketplace.app')
@section('styles')

<style>
.img-landing {
    display: block;
    margin-left: auto;
    margin-right: auto;
}
</style>
@endsection
@section('content-mkt')
<div class="row justify-content-center mt-2 bg-light">
    <div class="col-md-10 col-sm-12 text-center mb-0">
        <img class="img-fluid" src="{{asset('bienvenida/img1.jpg')}}" alt="Landing a Medicos_Abril24">
    </div>
    <div class="col-md-10 col-sm-12 text-center mb-0">
        <img class="img-fluid" src="{{asset('bienvenida/img2.jpg')}}" alt="Landing a Medicos_Abril24">
    </div>
    <div class="col-md-10 col-sm-12 text-center mb-0">
        <img class="img-fluid" src="{{asset('bienvenida/img3.jpg')}}" alt="Landing a Medicos_Abril24">
    </div>
    <div class="col-md-10 col-sm-12 text-center mb-0">
        <img class="img-fluid" src="{{asset('bienvenida/img4.jpg')}}" alt="Landing a Medicos_Abril24">
    </div>
     <nueva-campania></nueva-campania>
</div>

@endsection