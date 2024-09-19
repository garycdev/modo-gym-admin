@extends('backend.layouts.master')

@section('title')
    Rutinas - Admin Panel
@endsection

@section('styles')
    <style>
        table {
            /* transform: rotate(90deg); */
            /* transform-origin: top left; */
        }

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

        .card-dia {
            padding: 30px;
            border: 1px solid #007bff;
            border-radius: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: background-color 0.3s ease, color 0.3s ease;
            font-weight: bold
        }

        .card-dia:hover {
            background: linear-gradient(90deg, #007bff, #0056b3);
            color: #fff;
            border-color: #0056b3;
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
                    <div class="row p-2 d-flex justify-content-center align-items-center">
                        <div class="col-10">
                            <b>CI:</b> {{ $usuario->usu_ci }} <br>
                            <b>Usuario:</b> {{ $usuario->usu_nombre }} {{ $usuario->usu_apellidos }} <br>
                            <b>Plan: </b> {{ $usuario->costo[0]->nombre }}
                        </div>
                        <p class="col-2">
                            @if ($usr->can('rutina.create'))
                                <a href="{{ route('admin.rutinas.create') }}" class="btn btn-primary float-end">Nueva
                                    rutina</a>
                            @endif
                        </p>
                    </div>
                    <br>
                    @include('backend.layouts.partials.messages')

                    <div class="container-fluid">
                        <div class="row justify-content-between mb-4">
                            <div class="col-md-3">
                                <a href="{{ route('admin.usuario.rutinas.dia', [$usuario->usu_id, 1]) }}" class="card-dia">
                                    {{ strtoupper(dias(1)) }}
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="{{ route('admin.usuario.rutinas.dia', [$usuario->usu_id, 2]) }}" class="card-dia">
                                    {{ strtoupper(dias(2)) }}
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="{{ route('admin.usuario.rutinas.dia', [$usuario->usu_id, 3]) }}" class="card-dia">
                                    {{ strtoupper(dias(3)) }}
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="{{ route('admin.usuario.rutinas.dia', [$usuario->usu_id, 4]) }}" class="card-dia">
                                    {{ strtoupper(dias(4)) }}
                                </a>
                            </div>
                        </div>

                        <div class="row justify-content-center">
                            <div class="col-md-3">
                                <a href="{{ route('admin.usuario.rutinas.dia', [$usuario->usu_id, 5]) }}" class="card-dia">
                                    {{ strtoupper(dias(5)) }}
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="{{ route('admin.usuario.rutinas.dia', [$usuario->usu_id, 6]) }}" class="card-dia">
                                    {{ strtoupper(dias(6)) }}
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="{{ route('admin.usuario.rutinas.dia', [$usuario->usu_id, 7]) }}" class="card-dia">
                                    {{ strtoupper(dias(7)) }}
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script>
        $(document).ready(function() {
            var table = $("#tabla_pago").DataTable({
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
