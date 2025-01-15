@extends('errors.errors_layout')

@section('title')
    404 - Pagina no encontrada
@endsection

@section('error-content')
    <div class="error-404 d-flex align-items-center justify-content-center">
        <div class="container">
            <div class="card py-5">
                <div class="row g-0">
                    <div class="col col-xl-5">
                        <div class="card-body p-4">
                            <h1 class="display-1"><span class="text-primary">4</span><span class="text-danger">0</span><span
                                    class="text-success">4</span></h1>
                            <h2 class="font-weight-bold display-4">Perdido en el espacio</h2>
                            @if (session('message'))
                                <p>{{ session('message') }}</p>
                            @else
                                <p>Estas en el borde del universo.
                                    <br>La pagina que buscas no existe
                                    <br>No te preocupes y vuelve a la pagina principal
                                </p>
                            @endif
                            <div class="mt-5"> <a href="{{ route('admin.dashboard') }}"
                                    class="btn btn-primary btn-lg px-md-5 radius-30">Ir a inicio</a>
                                <a href="{{ route('admin.login') }}"
                                    class="btn btn-outline-dark btn-lg ms-3 px-md-5 radius-30">Iniciar sesión</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-7">
                        <img src="../../../../cdn.searchenginejournal.com/wp-content/uploads/2019/03/shutterstock_1338315902.html"
                            class="img-fluid" alt="">
                    </div>
                </div>
                <!--end row-->
            </div>
        </div>
    </div>
@endsection
