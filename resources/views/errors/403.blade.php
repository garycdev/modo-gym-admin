@extends('errors.errors_layout')

@section('title')
    403 - Access Denied
@endsection

@section('error-content')
    <div class="error-404 d-flex align-items-center justify-content-center">
        <div class="container">
            <div class="card py-5">
                <div class="row g-0">
                    <div class="col col-xl-5">
                        <div class="card-body p-4">
                            <h1 class="display-1"><span class="text-primary">4</span><span class="text-danger">0</span><span
                                    class="text-success">3</span></h1>
                            <h2 class="font-weight-bold display-4">Perdido en el espacio</h2>
                            <p class="mt-2">
                                {{ $exception->getMessage() }}
                            </p>
                            <p>Has llegado al borde del universo.
                                <br>No se ha podido encontrar la página solicitada.
                                <br>No te preocupes y vuelve a la página anterior.
                            </p>
                            <div class="mt-5">
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-primary btn-lg px-md-5 radius-30">
                                    <i class="bx bx-home"></i> Ir al inicio
                                </a>
                                <a href="{{ route('admin.login') }}"
                                    class="btn btn-outline-dark btn-lg ms-3 px-md-5 radius-30">
                                    Iniciar sesion
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-7">
                        <img src="{{asset('modo-gym/logo.png')}}"
                            class="img-fluid" alt="" width="500">
                    </div>
                </div>
                <!--end row-->
            </div>
        </div>
    </div>
@endsection
