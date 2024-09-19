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
                            <a href="{{ route('admin.rutinas.create') }}" class="btn btn-primary">Nueva rutina</a>
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
@endsection


@section('scripts')
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
                // fnDrawCallback: () => {

                //     $table = $(this);

                //     // only apply this to specific tables
                //     if ($table.closest(".datatable-multi-row").length) {

                //         // for each row in the table body...
                //         $table.find("tbody>tr").each(function() {
                //             var $tr = $(this);

                //             // get the "extra row" content from the <script> tag.
                //             // note, this could be any DOM object in the row.
                //             var extra_row = $tr.find(".extra-row-content").html();

                //             // in case draw() fires multiple times, 
                //             // we only want to add new rows once.
                //             if (!$tr.next().hasClass('dt-added')) {
                //                 $tr.after(extra_row);
                //                 $tr.find("td").each(function() {

                //                     // for each cell in the top row,
                //                     // set the "rowspan" according to the data value.
                //                     var $td = $(this);
                //                     var rowspan = parseInt($td.data(
                //                         "datatable-multi-row-rowspan"), 10);
                //                     if (rowspan) {
                //                         $td.attr('rowspan', rowspan);
                //                     }
                //                 });
                //             }

                //         });

                //     } // end if the table has the proper class
                // }
            });

            // table.buttons().container().appendTo('#tabla_pagos_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection
