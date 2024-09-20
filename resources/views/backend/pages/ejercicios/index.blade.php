@extends('backend.layouts.master')

@section('title')
    Ejercicio Page - Admin Panel
@endsection

@section('styles')
@endsection


@section('admin-content')
    @php
        if (Auth::guard('admin')->check()) {
            $usr = Auth::guard('admin')->user();
        } else {
            $usr = Auth::guard('user')->user();
        }
    @endphp
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Tabla</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i
                                        class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Tabla Ejercicios</li>
                        </ol>
                    </nav>
                </div>

            </div>
            <!--end breadcrumb-->
            <h6 class="mb-0 text-uppercase">Tabla de Ejercicios </h6>
            <hr />
            <div class="card">
                <div class="card-body">
                    <p class="float-right mb-2">
                        @if ($usr->can('ejercicio.create'))
                            <a class="btn btn-primary px-5 radius-30" href="{{ route('admin.ejercicios.create') }}">Crear
                                Nuevo</a>
                        @endif
                    </p>
                    <br>
                    @include('backend.layouts.partials.messages')
                    <div class="table-responsive w-100">
                        <table id="example2" class="table table-striped table-bordered w-100">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Imagen</th>
                                    <th>Nombre Equipo</th>
                                    <th>Equipo</th>
                                    <th>Nombre Musculo</th>
                                    <th>Musculo</th>
                                    <th>Descripcion</th>
                                    <th>Estado</th>
                                    {{-- <th>Fecha Actualizado</th> --}}
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($ejercicios as $ejercicio)
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $ejercicio->ejer_nombre }}</td>
                                        <td>
                                            <div class="d-flex flex-column align-items-center text-center">
                                                <img src="{{ asset($ejercicio->ejer_imagen) }}" class="product-img-2"
                                                    alt="product img" width="120">
                                            </div>
                                        </td>
                                        <td>{{ $ejercicio->equi_nombre }}</td>
                                        <td>
                                            @if ($ejercicio->equi_imagen)
                                                <div class="d-flex flex-column align-items-center text-center">
                                                    <img src="{{ asset($ejercicio->equi_imagen) }}" class="product-img-2"
                                                        alt="product img" width="120">
                                                </div>
                                            @else
                                                <div class="d-flex flex-column align-items-center text-center">
                                                    <img src="{{ asset('modo-gym/blank.png') }}" class="product-img-2"
                                                        alt="product img" width="120">
                                                </div>
                                            @endif
                                        </td>
                                        <td>{{ $ejercicio->mus_nombre }}</td>
                                        <td>
                                            @if ($ejercicio->mus_imagen)
                                                <div class="d-flex flex-column align-items-center text-center">
                                                    <img src="{{ asset($ejercicio->mus_imagen) }}" class="product-img-2"
                                                        alt="product img" width="120">
                                                </div>
                                            @else
                                                <div class="d-flex flex-column align-items-center text-center">
                                                    <img src="{{ asset('modo-gym/blank.png') }}" class="product-img-2"
                                                        alt="product img" width="120">
                                                </div>
                                            @endif
                                        </td>
                                        <td>{{ $ejercicio->ejer_descripcion }}</td>
                                        <td>
                                            <span
                                                class="badge bg-{{ $ejercicio->ejer_estado == 'ACTIVO' ? 'success' : 'danger' }}">
                                                {{ $ejercicio->ejer_estado }}
                                            </span>
                                        </td>
                                        {{-- <td>{{ $ejercicio->updated_at->format('d \d\e M \H\o\r\a\s: H:i A') }}</td> --}}
                                        <td>
                                            @if ($usr->can('ejercicio.edit'))
                                                <a class="btn btn-warning"
                                                    href="{{ route('admin.ejercicios.edit', $ejercicio->ejer_id) }}">
                                                    <i class='bx bxs-edit'></i>
                                                </a>
                                            @endif

                                            @if ($usr->can('ejercicio.delete'))
                                                <a class="btn btn-danger"
                                                    href="{{ route('admin.ejercicios.destroy', $ejercicio->ejer_id) }}"
                                                    onclick="event.preventDefault(); document.getElementById('delete-form-{{ $ejercicio->ejer_id }}').submit();">
                                                    <i class='bx bxs-trash'></i>
                                                </a>
                                                <form id="delete-form-{{ $ejercicio->ejer_id }}"
                                                    action="{{ route('admin.ejercicios.destroy', $ejercicio->ejer_id) }}"
                                                    method="POST" style="display: none;">
                                                    @method('DELETE')
                                                    @csrf
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                    @php
                                        $i++;
                                    @endphp
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Imagen</th>
                                    <th>Nombre Equipo</th>
                                    <th>Equipo</th>
                                    <th>Nombre Musculo</th>
                                    <th>Musculo</th>
                                    <th>Descripcion</th>
                                    <th>Estado</th>
                                    {{-- <th>Fecha Actualizado</th> --}}
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
        $(document).ready(function() {
            var table = $("#example2").DataTable({
                language: {
                    "decimal": "",
                    "emptyTable": "No hay información",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                    "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                    "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrar _MENU_ Entradas",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "zeroRecords": "Sin resultados encontrados",
                    "paginate": {
                        "first": "Primero",
                        "last": "Ultimo",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                },
                lengthChange: false,
                pageLength: 15,
                dom: 'Bfrtip',
                buttons: ['copy', 'excel', 'pdf', 'print']
            });
        });
    </script>
@endsection
