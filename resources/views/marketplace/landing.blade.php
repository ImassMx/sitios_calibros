@extends('marketplace.app')
@section('styles')

    <style>
        .img-landing {display: block; margin-left: auto; margin-right: auto;}

    </style>
@endsection
@section('content-mkt')
    <a href="/login/doctor">
        <img class="img-landing" src="{{asset('bienvenida/landing_medicos.jpg')}}" alt="Landing a Medicos_Abril24" style="max-width:100%;">
    </a>
@endsection