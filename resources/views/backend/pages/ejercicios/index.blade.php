
@extends('backend.layouts.master')

@section('title')
Ejercicio Page - Admin Panel

@php
$usr = Auth::guard('admin')->user();
@endphp


@endsection

@section('styles')

@endsection


@section('admin-content')




<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Tabla</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Tabla Ejercicios</li>
                    </ol>
                </nav>
            </div>

        </div>
        <!--end breadcrumb-->
        <h6 class="mb-0 text-uppercase">Tabla de Ejercicios </h6>
        <hr/>
        <div class="card">
            <div class="card-body">
                <p class="float-right mb-2">
                    @if (Auth::guard('admin')->user()->can('ejercicio.create'))
                        <a class="btn btn-primary px-5 radius-30" href="{{ route('admin.ejercicios.create') }}">Crear Nuevo</a>
                    @endif
                </p>
                <br>
                <div class="table-responsive">
                    @include('backend.layouts.partials.messages')
                    <table id="example2" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Imagen</th>
                                <th>Nombre del Equipo</th>
                                <th>Nombre del Musculo</th>
                                <th>Estado</th>
                                <th>Fecha Actualizado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ejercicios as $ejercicio)
                            <tr>
                                <td>{{$ejercicio->ejer_nombre}}</td>
                                <td>
                                    <div class="d-flex flex-column align-items-center text-center">
                                        <img src="{{ asset($ejercicio->ejer_imagen )}}" class="product-img-2" alt="product img"  width="120">
                                    </div>
                                </td>
                                <td>{{$ejercicio->equi_nombre}}</td>
                                <td>{{$ejercicio->mus_nombre}}</td>
                                <td>{{$ejercicio->ejer_estado}}</td>
                                <td>{{$ejercicio->updated_at->format('d \d\e M \H\o\r\a\s: H:i A')}}</td>
                                <td>
                                    @if (Auth::guard('admin')->user()->can('ejercicio.edit'))
                                        <a class="btn btn-success text-white" href="{{ route('admin.ejercicios.edit', $ejercicio->ejer_id) }}">
                                            <i class='bx bxs-edit'></i>
                                        </a>
                                    @endif

                                    @if (Auth::guard('admin')->user()->can('ejercicio.delete'))
                                        <a class="btn btn-danger text-white" href="{{ route('admin.ejercicios.destroy', $ejercicio->ejer_id ) }}"
                                        onclick="event.preventDefault(); document.getElementById('delete-form-{{ $ejercicio->ejer_id  }}').submit();">
                                            <i class='bx bxs-trash'></i>
                                        </a>
                                        <form id="delete-form-{{ $ejercicio->ejer_id }}" action="{{ route('admin.ejercicios.destroy', $ejercicio->ejer_id ) }}" method="POST" style="display: none;">
                                            @method('DELETE')
                                            @csrf
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Nombre</th>
                                <th>Imagen</th>
                                <th>Nombre del Equipo</th>
                                <th>Nombre del Musculo</th>
                                <th>Estado</th>
                                <th>Fecha Actualizado</th>
                                <th>Acciones</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('scripts')
    <script>
        $(document).ready(function () {
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
