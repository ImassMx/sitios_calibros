@extends('marketplace.app')
<style>
    .btn-custom-nuevo {
background-color: #5D025F;
color: white;
padding: 10px 20px;
border: none;
border-radius: 5px;
cursor: pointer;
text-decoration: none;
margin-bottom: 2rem;
margin-top: 4rem;
}
.btn-custom-nuevo:hover{
    color: white;
}
</style>
@section('content-mkt')
        <div style="width: 100%;display:flex;justify-content:center;align-items:center;flex-direction:column;">
            <img src="{{asset('img/success.png')}}" alt="" style="width: 200px;margin-top:3rem;">
            <h2  style="text-align: center; margin-top:1rem">Vamos a validar tu pago, en breve te llegará un correo.</h2>
            <show-aviso/>
        </div>
@endsection