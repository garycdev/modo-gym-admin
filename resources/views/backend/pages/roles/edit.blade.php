
@extends('backend.layouts.master')

@section('title')
Role Edit - Admin Panel
@endsection

@section('styles')
<style>
    .form-check-label {
        text-transform: capitalize;
    }
</style>
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
                        <li class="breadcrumb-item"><a href="{{ route('admin.roles.index') }}"><i class="bx bx-category">Roles</i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Editar Roles</li>
                    </ol>
                </nav>
            </div>

        </div>
        <div class="col-xl-8 mx-auto">
        <div class="card">
            <div class="card-body p-4">
                <h4 class="page-title pull-left">Editar Rol - {{ $role->name }}</h4>
                @include('backend.layouts.partials.messages')

                <form action="{{ route('admin.roles.update', $role->id) }}" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label for="name">Role Nombre</label>
                        <input type="text" class="form-control mb-3" id="name" value="{{ $role->name }}" name="name" placeholder="Enter a Role Name">
                    </div>

                    <div class="form-group">
                        <label for="name">Permissions</label>

                        <div class="form-check form-switch form-check-success">
                            <input type="checkbox" class="form-check-input" id="checkPermissionAll" value="1" {{ App\User::roleHasPermissions($role, $all_permissions) ? 'checked' : '' }}>
                            <label class="form-check-label" for="checkPermissionAll">All</label>
                        </div>
                        <hr>
                        @php $i = 1; @endphp
                        @foreach ($permission_groups as $group)
                            <div class="row">
                                @php
                                    $permissions = App\User::getpermissionsByGroupName($group->name);
                                    $j = 1;
                                @endphp

                                <div class="col-3">
                                    <div class="form-check form-check-info">
                                        <input type="checkbox" class="form-check-input" id="{{ $i }}Management" value="{{ $group->name }}" onclick="checkPermissionByGroup('role-{{ $i }}-management-checkbox', this)" {{ App\User::roleHasPermissions($role, $permissions) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="checkPermission">{{ $group->name }}</label>
                                    </div>
                                </div>

                                <div class="col-9 role-{{ $i }}-management-checkbox">

                                    @foreach ($permissions as $permission)
                                        <div class="form-check form-check-info">
                                            <input type="checkbox" class="form-check-input" onclick="checkSinglePermission('role-{{ $i }}-management-checkbox', '{{ $i }}Management', {{ count($permissions) }})" name="permissions[]" {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }} id="checkPermission{{ $permission->id }}" value="{{ $permission->name }}">
                                            <label class="form-check-label" for="checkPermission{{ $permission->id }}">{{ $permission->name }}</label>
                                        </div>
                                        @php  $j++; @endphp
                                    @endforeach
                                    <br>
                                </div>

                            </div>
                            @php  $i++; @endphp
                        @endforeach
                    </div>
                    <button type="submit" class="btn btn-primary px-5 radius-30">Actualizar Rol</button>
                </form>
            </div>
        </div>
        </div>
    </div>
</div>
<!-- page title area end -->



@endsection


@section('scripts')
     @include('backend.pages.roles.partials.scripts')
@endsection
