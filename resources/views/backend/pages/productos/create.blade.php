
@extends('backend.layouts.master')

@section('title')
Crear Producto - Admin Panel
@endsection

@section('styles')

@endsection


@section('admin-content')



<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Crear Productos</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Crear</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->
        <div class="row">
            <div class="col-xl-6 mx-auto">
                <div class="card">
                    <div class="card-header px-4 py-3">
                        <h5 class="mb-0">Agregar Productos</h5>
                        @include('backend.layouts.partials.messages')

                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('admin.productos.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="col-md-12">
                                <label for="producto_nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="producto_nombre" name="producto_nombre" placeholder="Agregar nombre del producto" required>
                            </div>
                            <br>
                            <div class="col-md-12">
                                <label for="producto_imagen" class="form-label">Imagen</label>
                                <input type="file" class="form-control" id="producto_imagen" name="producto_imagen" required>
                            </div>
                            <br>
                            <div class="col-md-12">
                                <label for="producto_descripcion" class="form-label">Descripción</label>
                                <textarea type="text" class="form-control" id="producto_descripcion" name="producto_descripcion" placeholder="Introduzca la descripción" rows="5"></textarea>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="producto_precio" class="form-label">Precio</label>
                                    <input type="number" class="form-control" id="producto_precio" name="producto_precio" placeholder="..." required>
                                </div>
                                <div class="col-md-4">
                                    <label for="producto_cantidad" class="form-label">Cantidad</label>
                                    <input type="number" class="form-control" id="producto_cantidad" name="producto_cantidad" placeholder="..." required>
                                </div>
                            </div>
                            <br>
                            <br>
                            <div class="col-md-12">
                                <div class="d-md-flex d-grid align-items-center gap-3">
                                    <button type="submit" class="btn btn-primary px-4">Agregar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
@endsection
