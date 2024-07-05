
@extends('backend.layouts.master')

@section('title')
Información Page - Admin Panel
@endsection
@php
$usr = Auth::guard('admin')->user();
@endphp

@section('styles')

@endsection


@section('admin-content')



<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Modo GYM Perfil</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href=" {{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Información</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->
        <div class="container">
            <div class="main-body">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">

                                <div class="d-flex flex-column align-items-center text-center">
                                    <img src="{{ asset($informacionempresa->info_logo ?? 'modo-gym/default_imagen.jpg')}}" alt="Admin" class="p-1 bg-secondary" width="220">
                                    <div class="mt-3">
                                        <h4>{{ $informacionempresa->info_nombre }}</h4>
                                        <p class="text-secondary mb-1">{{ $informacionempresa->info_descripcion ?? 'Sin Descripcion' }}</p>
                                    </div>
                                </div>
                                <hr class="my-4" />
                                <p>Actualizado  en: {{ $informacionempresa->info_updated_at->format('j \d\e F \H\o\r\a\s\: H:i A') }}</p>
                                @if ($usr->can('costo.view'))
                                    @foreach ($costos as $costo)
                                    <form action="{{ route('admin.informaciones.updatec', $costo->costo_id) }}"  method="POST">
                                        @method('PUT')
                                        @csrf
                                        <div class="row mb-3">
                                            <div class="col-sm-4">
                                                <h6 class="mb-0">{{$costo->nombre}}</h6>
                                            </div>
                                            <div class="col-sm-5 text-secondary">
                                                <input type="number" class="form-control" id="monto" name="monto" value="{{$costo->monto}}" />
                                            </div>
                                            @if ($usr->can('costo.edit'))
                                            <div class="col-sm-1 order-actions">
                                                <button type="submit" class="btn btn-primary"><i class='bx bxs-edit'></i></button>

                                            </div>
                                            @endif
                                        </div>
                                    </form>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-body">
                                @include('backend.layouts.partials.messages')

                                <form action="{{ route('admin.informaciones.update', $informacionempresa->informacion_id) }}"  method="POST" enctype="multipart/form-data">
                                    @method('PUT')
                                    @csrf
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Logo</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="file" class="form-control" id="info_logo" name="info_logo"   />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Nombre</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" class="form-control" id="info_nombre" name="info_nombre"  value="{{$informacionempresa->info_nombre}}" readonly/>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Descripción</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <textarea type="text" class="form-control" id="info_descripcion" name="info_descripcion"  placeholder="Introduce la descripción ..." rows="6" value="{{$informacionempresa->info_descripcion}}" />{{$informacionempresa->info_descripcion}}</textarea>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Sobre Nosotros</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <textarea type="text" class="form-control" id="info_sobre_nosotros" name="info_sobre_nosotros"  placeholder="Introduce sobre nosotros ..." rows="6" value="{{$informacionempresa->info_sobre_nosotros}}" />{{$informacionempresa->info_sobre_nosotros}}</textarea>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Video Url Youtube</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" class="form-control" id="info_video_url" name="info_video_url"  value="{{$informacionempresa->info_video_url}}" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Telefono</h6>
                                        </div>
                                        <div class="col-sm-3 text-secondary">
                                            <input type="text" class="form-control" id="info_telefono_1" name="info_telefono_1"  value="{{$informacionempresa->info_telefono_1}}" />
                                        </div>
                                        <div class="col-sm-2">
                                            <h6 class="mb-0">Celular 1</h6>
                                        </div>
                                        <div class="col-sm-4 text-secondary">
                                            <input type="text" class="form-control" id="info_contacto_1" name="info_contacto_1"  value="{{$informacionempresa->info_contacto_1}}" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Celular 2</h6>
                                        </div>
                                        <div class="col-sm-3 text-secondary">
                                            <input type="text" class="form-control" id="info_contacto_2" name="info_contacto_2"  value="{{$informacionempresa->info_contacto_2}}" />
                                        </div>
                                        <div class="col-sm-2">
                                            <h6 class="mb-0">Celular 3</h6>
                                        </div>
                                        <div class="col-sm-4 text-secondary">
                                            <input type="text" class="form-control" id="info_contacto_3" name="info_contacto_3"  value="{{$informacionempresa->info_contacto_3}}" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Atención</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <textarea type="text" class="form-control" id="info_atencion"  name="info_atencion"  rows="3" value="{{$informacionempresa->info_atencion}}" />{{$informacionempresa->info_atencion}}</textarea>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Correo</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" class="form-control" id="info_correo" name="info_correo"  value="{{$informacionempresa->info_correo}}" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Facebook</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" class="form-control" id="info_facebook" name="info_facebook"  value="{{$informacionempresa->info_facebook}}" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Tiktok</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" class="form-control" id="info_tiktok" name="info_tiktok"  value="{{$informacionempresa->info_tiktok}}" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Años de Experiencia</h6>
                                        </div>
                                        <div class="col-sm-3 text-secondary">
                                            <input type="number" class="form-control" id="info_ano_experiencia" name="info_ano_experiencia"  value="{{$informacionempresa->info_ano_experiencia}}" />
                                        </div>
                                        <div class="col-sm-2">
                                            <h6 class="mb-0">WhatsApp</h6>
                                        </div>
                                        <div class="col-sm-4 text-secondary">
                                            <input type="text" class="form-control" id="info_whatsapp" name="info_whatsapp"  value="{{$informacionempresa->info_whatsapp}}" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Url Página</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" class="form-control" id="info_pagina" name="info_pagina"  value="{{$informacionempresa->info_pagina}}" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Mapa Url</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" class="form-control" id="info_mapa" name="info_mapa"  value="{{$informacionempresa->info_mapa}}" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Latitud</h6>
                                        </div>
                                        <div class="col-sm-3 text-secondary">
                                            <input type="text" class="form-control" id="info_latitud" name="info_latitud"  value="{{$informacionempresa->info_latitud}}" />
                                        </div>
                                        <div class="col-sm-2">
                                            <h6 class="mb-0">Longitud</h6>
                                        </div>
                                        <div class="col-sm-4 text-secondary">
                                            <input type="text" class="form-control" id="info_longitud" name="info_longitud" value="{{$informacionempresa->info_longitud}}" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Dirreción</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" class="form-control" id="info_direccion" name="info_direccion" value="{{$informacionempresa->info_direccion}}" />
                                        </div>
                                    </div>
                                    @if ($usr->can('informacion_empresa.edit'))
                                    <div class="row">
                                        <div class="col-sm-3"></div>
                                        <div class="col-sm-9 text-secondary">
                                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">Guardar</button>
                                        </div>
                                    </div>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- <div class="main-content-inner">
    <div class="row">
        <!-- data table start -->
        <div class="col-12 mt-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title float-left">Rutinas Lista</h4>
                    <p class="float-right mb-2">
                        @if (Auth::guard('admin')->user()->can('rutina.create'))
                            <a class="btn btn-primary text-white" href="{{ route('admin.rutinas.create') }}">Create New Rutina</a>
                        @endif
                    </p>
                    <div class="clearfix"></div>
                    <div class="data-tables">
                        @include('backend.layouts.partials.messages')
                        <table id="dataTable" class="text-center">
                            <thead class="bg-light text-capitalize">
                                <tr>
                                    <th width="5%">Sl</th>
                                    <th width="10%">Name</th>
                                    <th width="60%">Permissions</th>
                                    <th width="15%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                               @foreach ($rutinas as $rutina)
                               <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td>{{ $rutina->rut_serie }}</td>
                                    <td>
                                        {{ $rutina->rut_peso }}
                                    </td>
                                    <td>
                                        @if (Auth::guard('admin')->user()->can('admin.edit'))
                                            <a class="btn btn-success text-white" href="{{ route('admin.rutinas.edit', $rutina->rut_id) }}">Edit</a>
                                        @endif

                                        @if (Auth::guard('admin')->user()->can('admin.edit'))
                                            <a class="btn btn-danger text-white" href="{{ route('admin.rutinas.destroy', $rutina->rut_id) }}"
                                            onclick="event.preventDefault(); document.getElementById('delete-form-{{ $rutina->rut_id }}').submit();">
                                                Delete
                                            </a>

                                            <form id="delete-form-{{ $rutina->rut_id }}" action="{{ route('admin.rutinas.destroy', $rutina->rut_id) }}" method="POST" style="display: none;">
                                                @method('DELETE')
                                                @csrf
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                               @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- data table end -->

    </div>
</div> --}}
@endsection


@section('scripts')

@endsection
