
@extends('backend.layouts.master')

@section('title')
Rol Page - Admin Panel
@endsection




@section('admin-content')


<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Administrador </div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Roles & Administrador</li>
                    </ol>
                </nav>
            </div>

        </div>
        <!--end breadcrumb-->

        <div class="card">
            <div class="card-body">
                <div class="d-lg-flex align-items-center mb-4 gap-3">

                  <div class="ms-auto">
                    @if (Auth::guard('admin')->user()->can('role.create'))
                    <a href="{{ route('admin.roles.create') }}" class="btn btn-primary radius-30 mt-2 mt-lg-0">
                        <i class="bx bxs-plus-square"></i>Agregar
                    </a>
                    @endif
                </div>
                </div>
                <div class="table-responsive">
                    @include('backend.layouts.partials.messages')
                    <table class="table mb-0" >
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Permisos</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $role)
                            <tr>
                                <td>{{ $loop->index+1 }}</td>
                                <td>{{ $role->name }}</td>
                                <td class="col-10">
                                    <div class="d-flex flex-wrap">
                                        @foreach ($role->permissions as $perm)
                                        <div class="badge rounded-pill text-info bg-light-info p-2  px-2 me-1 mb-1">
                                            {{ $perm->name }}
                                        </div>
                                        @endforeach
                                    </div>

                                </td>
                                <td>
                                    <div class="d-flex order-actions">
                                        @if (Auth::guard('admin')->user()->can('admin.edit'))
                                            <a href="{{ route('admin.roles.edit', $role->id) }}" class="">
                                                <i class='bx bxs-edit'></i>
                                            </a>
                                        @endif
                                        @if (Auth::guard('admin')->user()->can('admin.delete'))
                                            <a href="{{ route('admin.roles.destroy', $role->id) }}" class="ms-3"  onclick="event.preventDefault(); document.getElementById('delete-form-{{ $role->id }}').submit();">
                                                <i class='bx bxs-trash'></i>
                                            </a>
                                            <form id="delete-form-{{ $role->id }}" action="{{ route('admin.roles.destroy', $role->id) }}" method="POST" style="display: none;">
                                                @method('DELETE')
                                                @csrf
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


    </div>
</div>

@endsection

