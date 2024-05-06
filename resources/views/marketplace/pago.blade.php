@extends('marketplace.app')

@section('content-mkt')
    <show-pago user="{{auth()->user()->id}}" ></show-pago>  
@endsection