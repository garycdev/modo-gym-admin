@extends('backend.layouts.master')

@section('title')
    Rutinas - Admin Panel
@endsection

@section('styles')
    <style>
        td,
        th {
            vertical-align: top;
            border: 1px solid #ddd;
        }

        ul,
        li {
            padding-left: 5px;
            margin-left: 5px;
        }
    </style>
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
                <div class="breadcrumb-title pe-3">Rutinas</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Rutinas</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->
            <h6 class="mb-0 text-uppercase">Lista de rutinas</h6>
            <hr />
            <div class="card">
                <div class="card-body">
                    <p class="float-right mb-2">
                        @if ($usr->can('rutina.create'))
                            {{-- <a href="{{ route('admin.rutinas.create') }}" class="btn btn-primary">Nuevo rutina cliente</a> --}}
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#modalNuevo">
                                Nuevo rutina cliente
                            </button>
                        @endif
                    </p>
                    <br>
                    @include('backend.layouts.partials.messages')
                    <div class="table-responsive">
                        <table id="tabla_pagos" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>CI</th>
                                    <th>Nombres</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i = 1; @endphp
                                @foreach ($usuarios as $usu)
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $usu->usuario->usu_ci }}</td>
                                        <td>{{ $usu->usuario->usu_nombre }} {{ $usu->usuario->usu_apellidos }}</td>
                                        <td>
                                            <a class="btn btn-sm btn-primary"
                                                href="{{ route('admin.usuario.rutinas', $usu->usu_id) }}">
                                                Rutinas
                                            </a>
                                        </td>
                                    </tr>
                                    @php $i++; @endphp
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>CI</th>
                                    <th>Nombres</th>
                                    <th>Acciones</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalNuevo" tabindex="-1" aria-labelledby="modalNuevoLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('admin.rutinas.store') }}">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalNuevoLabel">Modal title</h1>
                        <button type="reset" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <input type="hidden" name="ejer_id" value="{{ $ejer->ejer_id }}">
                        @csrf
                    </div>
                    <div class="modal-body row">
                        <div class="col-md-12">
                            <label for="bsValidation9" class="form-label required_value">Usuario </label>
                            <select id="usu_id" name="usu_id" class="form-select usu_id" onchange="selectUser()">
                                <option selected disabled value>[USUARIO]</option>
                                @foreach ($clientes as $cliente)
                                    <option value="{{ $cliente->usu_id }}" data-fecha="{{ $cliente->pago_fecha }}"
                                        data-mes="{{ $cliente->mes }}" data-ci="{{ $cliente->usu_ci }}"
                                        data-nombres="{{ $cliente->usu_nombres }}"
                                        data-usuario="{{ json_encode($cliente) }}"
                                        data-formulario="{{ json_encode($cliente->formulario) }}">
                                        {{ $cliente->usu_nombre }}
                                        {{ $cliente->usu_apellidos }}</option>
                                @endforeach
                            </select>
                            @error('usu_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-12 mt-3" style="display:none;" id="defecto">
                            <label for="bsValidation9" class="form-label">Rutinas predeterminadas <span
                                    class="text-muted">(Opcional)</span></label>
                            <select id="def_id" name="def_id" class="form-select def_id" onchange="selectUser()">
                                <option selected disabled value>[RUTINAS]</option>
                                @foreach ($rutinas as $def)
                                    <option value="{{ $def->def_id }}">{{ $def->def_nombre }}</option>
                                @endforeach
                            </select>
                            @error('def_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary" disabled id="btn_rutina_cliente">Agregar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            var table = $("#tabla_pagos").DataTable({
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
                lengthChange: false,
                dom: 'Bfrtip',
                buttons: ["copy", "excel", "pdf", "print"],
            });

            $('.usu_id').select2({
                dropdownParent: $('#modalNuevo'),
                width: '100%',
            })
        });

        function selectUser() {
            $('#btn_rutina_cliente').removeAttr('disabled');
            $('#defecto').attr('style', 'display: block');
        }
    </script>
@endsection
