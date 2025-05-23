<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <!--begin::Sidebar Brand-->
    <div class="sidebar-brand">
        <!--begin::Brand Link-->
        <a href="{{ route('home') }}" class="brand-link">
            <!--begin::Brand Text-->
            <span class="brand-text fw-bold">SISTEMA</span>
            <!--end::Brand Text-->
        </a>
        <!--end::Brand Link-->
    </div>
    <!--end::Sidebar Brand-->

    <!--begin::Sidebar Wrapper-->
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <!--begin::Sidebar Menu-->
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">

              <li class="nav-item">
                    <a href="{{route('home')}}" class="nav-link">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Inicio</p>
                    </a>
                </li>
               
                <li class="nav-item">
                    <a href="{{route('departamentos.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-building"></i>
                        <p>Departamentos</p>
                    </a>
                </li>
               
               
                <li class="nav-item">
                    <a href="{{route('personal.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Personal</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{route('asistencias.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-calendar-check"></i>
                        <p>Asistencias</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{route('inasistencias.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-user-times"></i>
                        <p>Inasistencias</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{route('horarios.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-clock"></i>
                        <p>Horario Laboral</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{route('users.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-user-cog"></i>
                        <p>Usuarios</p>
                    </a>
                </li>

            </ul>
            <!--end::Sidebar Menu-->
        </nav>
    </div>
    <!--end::Sidebar Wrapper-->
</aside>