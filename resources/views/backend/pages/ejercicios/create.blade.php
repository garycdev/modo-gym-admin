
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
                        <form action="{{ route('admin.ejercicios.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="col-md-12">
                                <label for="ejer_nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="ejer_nombre" name="ejer_nombre" placeholder="Agregar nombre" required>
                            </div>
                            <div class="col-md-12">
                                <label for="ejer_imagen" class="form-label">Imagen</label>
                                <input type="file" class="form-control" id="ejer_imagen" name="ejer_imagen" required>
                            </div>
                            <div class="col-md-12">
                                <label for="ejer_descripcion" class="form-label">Descripción</label>
                                <textarea class="form-control" id="ejer_descripcion" name="ejer_descripcion" placeholder="Descripción ..." rows="4"></textarea>
                            </div>
                            <div class="col-md-12">
                                <label for="ejer_nivel" class="form-label">Nivel de Dificultad ( 0 - 5 )</label>
                                <input type="number" class="form-control" id="ejer_nivel" name="ejer_nivel" placeholder="Agregar nivel de dificultad" required>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="mus_id" class="form-label">Musculo</label>
                                    <select id="mus_id" name="mus_id" class="form-select" required>
                                        <option selected disabled value>Elegir...</option>
                                        @foreach ($musculos as $musculo)
                                            <option value='{{ $musculo->mus_id }}' id='{{ $musculo->mus_id }}'>{{ $musculo->mus_nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="equi_id" class="form-label">Equipo</label>
                                    <select id="equi_id" name="equi_id" class="form-select" required>
                                        <option selected disabled value>Elegir...</option>
                                        @foreach ($equipos as $equipo)
                                            <option value='{{ $equipo->equi_id }}' id='{{ $equipo->equi_id }}'>{{ $equipo->equi_nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <br>
                            <div class="col-md-12">
                                <div class="d-md-flex d-grid align-items-center gap-3">
                                    <button type="submit" class="btn btn-primary px-4">Submit</button>
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
