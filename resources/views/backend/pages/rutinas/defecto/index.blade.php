@extends('backend.layouts.master')

@section('title')
    Rutinas predeterminadas - Admin Panel
@endsection

@section('styles')
    <style>
        #tabla_defecto.dataTable td.child ul.dtr-details {
            margin-left: 50px;
        }
    </style>
@endsection

@section('admin-content')
    @php
        $usr = Auth::guard('admin')->check() ? Auth::guard('admin')->user() : Auth::guard('user')->user();
    @endphp
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Rutinas predeterminadas</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Rutinas predeterminadas</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->
            <h6 class="mb-0 text-uppercase">Lista de rutinas por defecto</h6>
            <hr />
            <div class="card">
                <div class="card-body">
                    <div class="row p-2 d-flex justify-content-end align-items-center">
                        <p class="col-lg-2 col-md-2 col-12">
                            @if ($usr->can('rutina.create'))
                                <a href="{{ route('admin.defecto.create') }}" class="btn btn-primary float-end">
                                    Nueva rutina predeterminada
                                </a>
                            @endif
                        </p>
                    </div>

                    @include('backend.layouts.partials.messages')

                    <br>
                    <div class="table-responsive w-100">
                        <table id="tabla_defecto" class="table table-bordered table-hover w-100">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i = 1; @endphp
                                @foreach ($defecto as $def)
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $def->def_nombre }}</td>
                                        <td>
                                            <span
                                                class="badge bg-{{ $def->def_estado == 'ACTIVO' ? 'success' : 'danger' }}">
                                                {{ $def->def_estado }}
                                            </span>
                                        </td>
                                        <td>
                                            @if ($usr->can('rutina.edit'))
                                                <a class="btn btn-sm btn-primary"
                                                    href="{{ route('admin.defecto.show', $def->def_id) }}">
                                                    Ver rutinas
                                                </a>
                                            @endif
                                            @if ($usr->can('rutina.edit'))
                                                <a class="btn btn-sm btn-warning"
                                                    href="{{ route('admin.defecto.edit', $def->def_id) }}">
                                                    <i class="bx bxs-edit"></i>
                                                </a>
                                            @endif
                                            @if ($usr->can('rutina.delete'))
                                                <a class="btn btn-sm btn-danger text-white"
                                                    href="{{ route('admin.defecto.destroy', $def->def_id) }}"
                                                    onclick="event.preventDefault(); document.getElementById('delete-form-{{ $def->def_id }}').submit();">
                                                    <i class='bx bxs-trash'></i>
                                                </a>
                                                <form id="delete-form-{{ $def->def_id }}"
                                                    action="{{ route('admin.defecto.destroy', $def->def_id) }}"
                                                    method="POST" style="display: none;">
                                                    @method('DELETE')
                                                    @csrf
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                    @php $i++; @endphp
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Estado</th>
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
            var table = $("#tabla_defecto").DataTable({
                language: {
                    "decimal": "",
                    "emptyTable": "No hay información",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                    "infoEmpty": "Mostrando 0 a 0 de 0 Entradas",
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
            });
        });
    </script>
@endsection
