
@extends('backend.layouts.master')

@section('title')
Editar Blogs - Admin Panel
@endsection

@section('styles')

@endsection


@section('admin-content')



<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Editar Blogs</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.ejercicios.index') }}"><i class="bx bx-dumbbell">Blogs</i></a>
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
                        <h5 class="mb-0">Editar Blog</h5>
                        @include('backend.layouts.partials.messages')
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('admin.blogs.update', $blog->blog_id) }}" method="POST" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="col-md-12">
                                <label for="blog_titulo" class="form-label">Titulo</label>
                                <input type="text" class="form-control" id="blog_titulo" name="blog_titulo" value="{{$blog->blog_titulo}}" placeholder="Ingrese el titulo" required>
                            </div>
                            <br>
                            <div class="col-md-12">
                                <label for="blog_imagen" class="form-label">Imagen</label>
                                <input type="file" class="form-control" id="blog_imagen" name="blog_imagen">
                            </div>
                            <br>
                            <div class="col-md-12">
                                <label for="blog_descripcion" class="form-label">Descripcion</label>
                                <textarea class="form-control" id="blog_descripcion" name="blog_descripcion" rows="6" value="{{$blog->blog_descripcion}}">{{$blog->blog_descripcion}}</textarea>
                            </div>

                            <div class="col-md-12">
                                <label for="blog_estado" class="form-label">Estado</label>
                                <select id="blog_estado" name="blog_estado" class="form-select">
                                    <option value="ACTIVO" {{ $blog->blog_estado == 'ACTIVO' ? 'selected' : '' }}>ACTIVO</option>
                                    <option value="INACTIVO" {{ $blog->blog_estado == 'INACTIVO' ? 'selected' : '' }}>INACTIVO</option>
                                </select>

                            </div>
                            <br>
                            <div class="col-md-12">
                                <div class="d-md-flex d-grid align-items-center gap-3">
                                    <button type="submit" class="btn btn-primary px-4">Guardar</button>
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
        var quill = new Quill('#editor', {
        theme: 'snow'
        });
    </script>
@endsection
