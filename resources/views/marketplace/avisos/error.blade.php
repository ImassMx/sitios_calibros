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

}
.btn-custom-nuevo:hover{
    color: white;
}
</style>
@section('content-mkt')
    <div style="width: 100%;display:flex;justify-content:center;align-items:center;flex-direction:column;">
        <img src="{{ asset('img/cerrar.png') }}" alt="" style="width: 300px">
        <a  href="/marketplace" class="btn-custom-nuevo"> 
            Regresar a tienda </a>
    </div>
@endsection
