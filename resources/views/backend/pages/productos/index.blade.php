
@extends('backend.layouts.master')

@section('title')
Productos Page - Admin Panel
@endsection

@section('styles')

@endsection


@section('admin-content')




<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Tables</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Tabla de Productos</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->
        <h6 class="mb-0 text-uppercase">Tabla de Productos</h6>
        <br>
        <div class="col-lg-3 col-xl-2">
            <a href="{{ route('admin.productos.create') }}" class="btn btn-primary mb-3 mb-lg-0"><i class='bx bxs-plus-square'></i>Nuevo Producto</a>
        </div>
        <hr/>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4 row-cols-xxl-5 product-grid">
            @foreach ( $productos as $producto )
                <div class="col">
                    <div class="card">
                        <img src="{{asset( $producto->producto_imagen )}}" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h6 class="card-title cursor-pointer">{{ $producto->producto_nombre }}</h6>
                            <p class="card-title cursor-pointer">{{ $producto->producto_descripcion }}</p>
                            <div class="clearfix">
                                <p class="mb-0 float-start"><strong>{{ $producto->producto_cantidad }}</strong> Cantidad</p>
                                <p class="mb-0 float-end fw-bold"><span>{{ $producto->producto_precio }} Bs.</span></p>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                @if (Auth::guard('admin')->user()->can('producto.edit'))
                                    <a href="{{ route('admin.productos.edit', $producto->producto_id) }}" class="btn btn-primary"><i class='bx bx-edit-alt'></i>Editar</a>
                                @endif
                                @if (Auth::guard('admin')->user()->can('producto.delete'))
                                    <a href="{{ route('admin.productos.destroy', $producto->producto_id) }}"
                                        onclick="event.preventDefault(); document.getElementById('delete-form-{{ $producto->producto_id  }}').submit();" class="btn btn-danger"><i class='bx bx-trash-alt' ></i>Delete</a>
                                    <form id="delete-form-{{ $producto->producto_id }}" action="{{ route('admin.productos.destroy', $producto->producto_id ) }}" method="POST" style="display: none;">
                                        @method('DELETE')
                                        @csrf
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div><!--end row-->
    </div>
</div>


@endsection


@section('scripts')

@endsection
