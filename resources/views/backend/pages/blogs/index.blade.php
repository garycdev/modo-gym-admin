
@extends('backend.layouts.master')

@section('title')
Blogs Page - Admin Panel
@endsection

@section('styles')

@endsection


@section('admin-content')


<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Blogs</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Blogs</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->
        <h6 class="mb-0 text-uppercase">Lista Blogs</h6>
        <hr/>
        <p class="float-right mb-2">
            @if (Auth::guard('admin')->user()->can('blog.create'))
            <a class="btn btn-primary px-5 radius-30" href="{{ route('admin.blogs.create') }}">Crear Nuevo</a>
            @endif
        </p>
        <br/>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 row-cols-xl-4">
            @foreach ($blogs as $blog)
            <div class="col">
                <div class="card border-primary border-bottom border-3 border-0">
                    <img src="{{asset( $blog->blog_imagen )}}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title text-primary">{{ $blog->blog_titulo }}</h5>
                        <p class="card-text">{{ $blog->blog_descripcion }}</p>
                        <hr>
                        <div class="d-flex align-items-center gap-2">
                            @if (Auth::guard('admin')->user()->can('blog.edit'))
                                <a href="{{ route('admin.blogs.edit', $blog->blog_id) }}" class="btn btn-primary"><i class='bx bx-edit-alt'></i>Editar</a>
                            @endif
                            @if (Auth::guard('admin')->user()->can('blog.delete'))
                                <a href="{{ route('admin.blogs.destroy', $blog->blog_id) }}"
                                    onclick="event.preventDefault(); document.getElementById('delete-form-{{ $blog->blog_id  }}').submit();" class="btn btn-danger"><i class='bx bx-trash-alt' ></i>Delete</a>
                                <form id="delete-form-{{ $blog->blog_id }}" action="{{ route('admin.blogs.destroy', $blog->blog_id ) }}" method="POST" style="display: none;">
                                    @method('DELETE')
                                    @csrf
                                </form>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

@endsection


@section('scripts')

@endsection
