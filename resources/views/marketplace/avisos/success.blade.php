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

.btn-custom-nuevo:hover {
    color: white;
}
</style>
@section('content-mkt')
<div class="row justify-content-center">
    <div class="col-md-9 col-sm-12 text-center pt-5">
        <img src="{{asset('img/success.png')}}" alt="" style="width: 150px;">
        <h3 class="pt-2">Su compra se ha realizado correctamente,</h3>
        <p>a continuación validaremos su pago y en breve le llegará un correo de confirmación.</p>
    </div>
    <show-aviso />
</div>
@endsection