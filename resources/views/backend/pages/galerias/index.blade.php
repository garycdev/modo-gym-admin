@extends('backend.layouts.master')

@section('title')
    Equipos Page - Admin Panel

    @php
        $usr = Auth::guard('admin')->user();
    @endphp
@endsection

@section('styles')
@endsection


@section('admin-content')
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Galerias</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i
                                        class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Galerias</li>
                        </ol>
                    </nav>
                </div>

            </div>
            <!--end breadcrumb-->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-lg-3 col-xl-2">
                                    @if (Auth::guard('admin')->user()->can('galeria.create'))
                                        <a href="{{ route('admin.galerias.create') }}"
                                            class="btn btn-primary mb-3 mb-lg-0"><i class='bx bxs-plus-square'></i>Nuevo
                                            Galeria</a>
                                    @endif
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @foreach ($galerias as $galeria)
                <div class="row">
                    <div class="col">
                        <h6 class="mb-0 text-uppercase">{{ $galeria->galeria_nombre }}</h6>
                    </div>
                    @if (Auth::guard('admin')->user()->can('galeria.edit'))
                        <div class="col-lg-3 col-xl-2">
                            <a href="ecommerce-add-new-products.html" class="btn bg-light-success mb-3 mb-lg-0"><i
                                    class='bx bxs-edit'></i>Editar Titulo</a>
                        </div>
                    @endif
                </div>

                <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4 row-cols-xxl-5 product-grid">
                    @foreach ($galeria->imagenes as $imagen)
                        <div class="col">
                            <div class="card">
                                <img src="{{ asset($imagen->imagen_url) }}" class="card-img-top" alt="..."
                                    style="height:100px!important;width:auto!important;display:block!important;visibility:visible!important;">
                                <a href="javascript:;" class="position-relative top-0 m-1">
                                    <i class="bx bxs-trash btn btn-danger"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
                <!--end row-->
                <hr>
            @endforeach


        </div>
    </div>
    <!--end page wrapper -->
@endsection


@section('scripts')
    <script>
        $(document).ready(function() {
            var table = $("#example2").DataTable({
                lengthChange: false,
                buttons: ["copy", "excel", "pdf", "print"],
            });

            table
                .buttons()
                .container()
                .appendTo("#example2_wrapper .col-md-6:eq(0)");
        });
    </script>
@endsection
