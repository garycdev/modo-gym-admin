
@extends('backend.layouts.master')

@section('title')
Crear Ejercicio - Admin Panel
@endsection

@section('styles')

@endsection


@section('admin-content')



<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Create Ejercicio</div>
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
                        <h5 class="mb-0">Crear Ejercicio</h5>
                        @include('backend.layouts.partials.messages')

                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('admin.galerias.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="galeria_id" class="form-label">Titulo Galeria</label>
                                    <select id="galeria_id" name="galeria_id" class="form-select" required>
                                        <option selected disabled value>Elegir...</option>
                                        @foreach ($galerias as $galeria)
                                            <option value='{{ $galeria->galeria_id }}' id='{{ $galeria->galeria_id }}'>{{ $galeria->galeria_nombre }}</option>
                                        @endforeach
                                        <option value="-1">Agregar Nuevo...</option>
                                    </select>
                                    <input type="text" class="form-control" id="galeria_nombre" name="galeria_nombre" placeholder="Agregar nombre" style="display: none;" >
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label for="imagen_url" class="form-label">Imagen</label>
                                <input type="file" class="form-control" id="imagen_url" name="imagen_url" required>
                            </div>

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
<script>
    $(document).ready(function() {
        $('#galeria_id').change(function() {
            if ($(this).val() == "-1") {
                $('#galeria_nombre').show();
            } else {
                $('#galeria_nombre').hide();
            }
        });
    });
</script>
@endsection
