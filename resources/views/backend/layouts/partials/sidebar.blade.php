 <!-- sidebar menu area start -->
 @php
     $usr = Auth::guard('admin')->user();
 @endphp

 <!--sidebar wrapper -->
 <div class="sidebar-wrapper" data-simplebar="true">
     <div class="sidebar-header">
         <div>
             <img src="{{ asset('modo-gym/logo_2.png') }}" class="logo-icon" alt="logo icon">
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
         @if ($usr->can('role.create') || $usr->can('role.view') || $usr->can('role.edit') || $usr->can('role.delete'))
             <li
                 class="{{ Route::is('admin.roles.create') || Route::is('admin.roles.index') || Route::is('admin.roles.edit') || Route::is('admin.roles.show') ? 'mm-active' : '' }}">
                 @if ($usr->can('role.view'))
                     <a href="{{ route('admin.roles.index') }}">
                         <div class="parent-icon"><i class="bx bx-category"></i>
                         </div>
                         <div class="menu-title">Roles & Permisos</div>
                     </a>
                 @endif
             </li>
         @endif
         @if ($usr->can('admin.create') || $usr->can('admin.view') || $usr->can('admin.edit') || $usr->can('admin.delete'))
             <li
                 class="{{ Route::is('admin.admins.index') || Route::is('admin.admins.edit') || Route::is('admin.admins.create') ? 'mm-active' : '' }}">
                 <a href="{{ route('admin.admins.index') }}">
                     <div class="parent-icon"><i class='bx bx-user-circle'></i>
                     </div>
                     <div class="menu-title">Usuarios Admin</div>
                 </a>
             </li>
         @endif
         @if (
             $usr->can('informacion_empresa.view') ||
                 $usr->can('equipo.view') ||
                 $usr->can('ejercicio.view') ||
                 $usr->can('musculo.view'))
             <li class="menu-label">MODO GYM</li>
         @endif

         @if ($usr->can('informacion_empresa.view'))
             <li class="{{ Route::is('admin.informaciones.index') ? 'mm-active' : '' }}">
                 <a href="{{ route('admin.informaciones.index') }}">
                     <div class="parent-icon"><i class='lni lni-emoji-happy'></i>
                     </div>
                     <div class="menu-title">Informacion</div>
                 </a>
             </li>
         @endif
         @if ($usr->can('equipo.view') || $usr->can('ejercicio.view') || $usr->can('musculo.view'))

             <li>
                 <a href="javascript:;" class="has-arrow">
                     <div class="parent-icon"><i class='bx bx-dumbbell'></i>
                     </div>
                     <div class="menu-title">Ejercicios</div>
                 </a>
                 <ul>
                     @if ($usr->can('ejercicio.view'))
                         <li class="{{ Route::is('admin.ejercicios.index') ? 'mm-active' : '' }}">
                             <a href="{{ route('admin.ejercicios.index') }}"><i
                                     class='bx bx-radio-circle'></i>Ejercicios</a>
                         </li>
                     @endif
                     @if ($usr->can('equipo.view'))
                         <li class="{{ Route::is('admin.equipos.index') ? 'mm-active' : '' }}">
                             <a href="{{ route('admin.equipos.index') }}"><i class='bx bx-radio-circle'></i>Equipos</a>
                         </li>
                     @endif
                     @if ($usr->can('musculo.view'))
                         <li class="{{ Route::is('admin.musculos.index') ? 'mm-active' : '' }}">
                             <a href="{{ route('admin.musculos.index') }}"><i
                                     class='bx bx-radio-circle'></i>Musculos</a>
                         </li>
                     @endif

                 </ul>
             </li>
         @endif
         @if ($usr->can('blog.view') || $usr->can('producto.view') || $usr->can('galeria.view') || $usr->can('video.view'))
             <li class="menu-label">Publicidad</li>
         @endif
         @if ($usr->can('blog.view'))
             <li class="{{ Route::is('admin.blogs.index') ? 'mm-active' : '' }}">
                 <a href="{{ route('admin.blogs.index') }}">
                     <div class="parent-icon"><i class='bx bx-book-alt'></i>
                     </div>
                     <div class="menu-title">Blog</div>
                 </a>
             </li>
         @endif
         @if ($usr->can('producto.view'))
             <li class="{{ Route::is('admin.productos.index') ? 'mm-active' : '' }}">
                 <a href="{{ route('admin.productos.index') }}">
                     <div class="parent-icon"><i class='bx bx-shopping-bag'></i>
                     </div>
                     <div class="menu-title">Productos</div>
                 </a>
             </li>
         @endif
         @if ($usr->can('galeria.view'))
             <li class="{{ Route::is('admin.galerias.index') ? 'mm-active' : '' }}">
                 <a href="{{ route('admin.galerias.index') }}">
                     <div class="parent-icon"><i class='bx bx-camera'></i>
                     </div>
                     <div class="menu-title">Galerias</div>
                 </a>
             </li>
         @endif
         @if ($usr->can('video.view'))
             <li class="{{ Route::is('admin.videos.index') ? 'mm-active' : '' }}">
                 <a href="{{ route('admin.videos.index') }}">
                     <div class="parent-icon"><i class='bx bx-video-recording'></i>
                     </div>
                     <div class="menu-title">Videos</div>
                 </a>
             </li>
         @endif
         @if ($usr->can('cliente.view') || $usr->can('costo.view'))
             <li class="menu-label">Clientes</li>
         @endif
         @if ($usr->can('cliente.view'))
             <li class="{{ Route::is('admin.clientes.index') ? 'mm-active' : '' }}">
                 <a href="{{ route('admin.clientes.index') }}">
                     <div class="parent-icon"><i class="lni lni-users"></i>
                     </div>
                     <div class="menu-title">Usuario</div>
                 </a>
             </li>
         @endif
         @if ($usr->can('costo.view'))
             <li class="{{ Route::is('admin.costos.index') ? 'mm-active' : '' }}">
                 <a href="{{ route('admin.costos.index') }}">
                     <div class="parent-icon"><i class="lni lni-coin"></i>
                     </div>
                     <div class="menu-title">Costos</div>
                 </a>
             </li>
         @endif

         @if ($usr->can('cita.view') || $usr->can('horario.view'))
             <li class="menu-label">Citas & Horarios</li>
         @endif
         @if ($usr->can('cita.view'))
             <li class="{{ Route::is('admin.citas.index') ? 'mm-active' : '' }}">
                 <a href="{{ route('admin.citas.index') }}">
                     <div class="parent-icon"><i class='bx bx-calendar-heart'></i>
                     </div>
                     <div class="menu-title">Citas</div>
                 </a>
             </li>
         @endif
         @if ($usr->can('horario.view'))
             <li class="{{ Route::is('admin.horarios.index') ? 'mm-active' : '' }}">
                 <a href="{{ route('admin.horarios.index') }}">
                     <div class="parent-icon"><i class='bx bx-stopwatch'></i>
                     </div>
                     <div class="menu-title">Horarios</div>
                 </a>
             </li>
         @endif
         @if ($usr->can('contactar.view'))
             <li class="{{ Route::is('admin.contactos.index') ? 'mm-active' : '' }}">
                 <a href="{{ route('admin.contactos.index') }}">
                     <div class="parent-icon"><i class="bx bx-phone"></i>
                     </div>
                     <div class="menu-title">Contactos</div>
                 </a>
             </li>
         @endif
     </ul>
     <!--end navigation-->
 </div>
 <!--end sidebar wrapper -->
