
@extends('backend.layouts.master')

@section('title')
Musculo Editar - Admin Panel
@endsection

@section('styles')
<style>

</style>
@endsection


@section('admin-content')


<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Editar Musculo</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.musculos.index') }}"><i class="bx bx-dumbbell">Musculos</i></a>

                        <li class="breadcrumb-item active" aria-current="page">Editar</li>
                    </ol>
                </nav>
            </div>

        </div>
        <!--end breadcrumb-->
        <div class="row">
            <div class="col-xl-6 mx-auto">
                <div class="card">
                    <div class="card-header px-4 py-3">
                        <h5 class="mb-0">Editar musculo</h5>
                        @include('backend.layouts.partials.messages')
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('admin.musculos.update', $musculo->mus_id) }}" method="POST" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="col-md-12">
                                <label for="bsValidation3" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="mus_nombre" name="mus_nombre" value="{{$musculo->mus_nombre}}" placeholder="Agregar nombre" required>
                            </div>
                            <div class="col-md-12">
                                <label for="mus_estado" class="form-label">Estado</label>
                                <select id="mus_estado" name="mus_estado" class="form-select">
                                    <option value="ACTIVO" {{ $musculo->mus_estado == 'ACTIVO' ? 'selected' : '' }}>ACTIVO</option>
                                    <option value="INACTIVO" {{ $musculo->mus_estado == 'INACTIVO' ? 'selected' : '' }}>INACTIVO</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label for="bsValidation4" class="form-label">Imagen</label>
                                <input type="file" class="form-control" id="mus_imagen" name="mus_imagen" >
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
     {{-- @include('backend.pages.musculos.partials.scripts') --}}
@endsection
