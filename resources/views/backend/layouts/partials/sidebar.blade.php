 <!-- sidebar menu area start -->
 @php
     $usr = Auth::guard('admin')->user();
 @endphp

<!--sidebar wrapper -->
<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div>
            <img src="{{asset('modo-gym/logo_2.png')}}" class="logo-icon" alt="logo icon">
        </div>
        <div>
            <h5 class="logo-text">Modo Gym</h5>
        </div>
        <div class="toggle-icon ms-auto"><i class='bx bx-arrow-back'></i>
        </div>
     </div>
    <!--navigation-->
    <ul class="metismenu" id="menu">
        @if ($usr->can('dashboard.view'))
        <li class="{{ Route::is('admin.dashboard') ? 'mm-active' : '' }}">
            <a href="{{ route('admin.dashboard') }}">
                <div class="parent-icon"><i class='bx bx-home-alt'></i>
                </div>
                <div class="menu-title">Dashboard</div>
            </a>
        </li>
        @endif
        <li class="menu-label">Administrador</li>
        @if ($usr->can('role.create') || $usr->can('role.view') ||  $usr->can('role.edit') ||  $usr->can('role.delete'))
            <li class="{{ Route::is('admin.roles.create') || Route::is('admin.roles.index') || Route::is('admin.roles.edit') || Route::is('admin.roles.show') ? 'mm-active' : '' }}">
                @if ($usr->can('role.view'))
                    <a href="{{ route('admin.roles.index') }}">
                        <div class="parent-icon"><i class="bx bx-category"></i>
                        </div>
                        <div class="menu-title">Roles & Permisos</div>
                    </a>
                @endif
            </li>
        @endif
        @if ($usr->can('admin.create') || $usr->can('admin.view') ||  $usr->can('admin.edit') ||  $usr->can('admin.delete'))
        <li class="{{ Route::is('admin.admins.index')  || Route::is('admin.admins.edit') ? 'mm-active' : '' }}">
            <a href="{{ route('admin.admins.index') }}">
                <div class="parent-icon"><i class='bx bx-user-circle'></i>
                </div>
                <div class="menu-title">Usuarios Admin</div>
            </a>
        </li>
        @endif
        <li class="menu-label">MODO GYM</li>
        <li>
            <a href="widgets.html">
                <div class="parent-icon"><i class='lni lni-emoji-happy'></i>
                </div>
                <div class="menu-title">Informacion</div>
            </a>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-dumbbell'></i>
                </div>
                <div class="menu-title">Ejercicios</div>
            </a>
            <ul>
                <li> <a href="ecommerce-products.html"><i class='bx bx-radio-circle'></i>Ejercicios</a>
                </li>
                <li> <a href="ecommerce-products-details.html"><i class='bx bx-radio-circle'></i>Equipos</a>
                </li>
                <li> <a href="ecommerce-products-details.html"><i class='bx bx-radio-circle'></i>Musculos</a>
                </li>
            </ul>
        </li>
        <li class="menu-label">Publicidad</li>
        <li>
            <a href="javascript:;">
                <div class="parent-icon"><i class='bx bx-book-alt'></i>
                </div>
                <div class="menu-title">Blog</div>
            </a>
        </li>
        <li>
            <a href="javascript:;">
                <div class="parent-icon"><i class='bx bx-shopping-bag'></i>
                </div>
                <div class="menu-title">Productos</div>
            </a>
        </li>
        <li>
            <a href="javascript:;">
                <div class="parent-icon"><i class='bx bx-camera'></i>
                </div>
                <div class="menu-title">Galerias</div>
            </a>
        </li>
        <li>
            <a href="javascript:;">
                <div class="parent-icon"><i class='bx bx-video-recording'></i>
                </div>
                <div class="menu-title">Videos</div>
            </a>
        </li>
        <li class="menu-label">Clientes</li>
        <li>
            <a href="javascript:;">
                <div class="parent-icon"><i class="lni lni-users"></i>
                </div>
                <div class="menu-title">Usuario</div>
            </a>
        </li>
        <li class="menu-label">Citas & Horarios</li>
        <li>
            <a href="javascript:;">
                <div class="parent-icon"><i class='bx bx-calendar-heart'></i>
                </div>
                <div class="menu-title">Citas</div>
            </a>
        </li>
        <li>
            <a href="javascript:;">
                <div class="parent-icon"><i class='bx bx-stopwatch'></i>
                </div>
                <div class="menu-title">Horarios</div>
            </a>
        </li>
        <li>
            <a href="javascript:;">
                <div class="parent-icon"><i class="bx bx-phone"></i>
                </div>
                <div class="menu-title">Contactos</div>
            </a>
        </li>
    </ul>
    <!--end navigation-->
</div>
<!--end sidebar wrapper -->
