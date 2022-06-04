<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4"
    style="z-index: 1040 !important;     border-radius: 0px 20px 20px 0px;">
    <!-- Brand Logo -->
    <div>
        <a @can('admin-access') @if (Auth::user()->status == 1)
           target="_block" @endif
        href="{{ route('admin.index') }}" @endcan
        @can('employee-access') href="{{ route('employee.index') }}" @endcan class="brand-link text-center">
        {{-- <img
            src="/dist/img/AdminLTELogo.png"
            alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3"
            style="opacity: 0.8;"
        /> --}}
        <p class="p-logo"><strong>
                <img class="img-fluid" style="    width: 180px;
                    height: 100px;" src="{{ asset('images/logo1.png') }}" alt="">
            </strong></p>
    </a>
</div>

<!-- Sidebar -->
<div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            @php
            @endphp
            @if (Auth::user()->photo)
                <img src="/images/{{ Auth::user()->photo }}" class="img-circle elevation-2" alt="User Image" style="    height: 45px;
                    width: 45px;" />
            @else
                <img src="https://zrsgaming.eu/zrs.png" class="img-circle elevation-2" alt="User Image" />
            @endif

        </div>
        <div class="info">
            <p class="d-block">{{ Auth::user()->name }}</p>
        </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            @can('admin-access')
                <li class="nav-item">
                    <a @can('admin-access') href="{{ route('admin.index') }}" @endcan
                        @can('employee-access') href="{{ route('employee.index') }}" @endcan class="nav-link">
                        <i class="fas fa-chalkboard-teacher color-white m-r-10"></i>
                        <p class="color-white">
                            Admin Dashboard

                        </p>
                    </a>
                </li>
                @include('includes.admin.sidebar_items')
            @endcan
            @can('employee-access')
                <li class="nav-item">
                    <a @if (Auth::user()->status == 1) target="_block" @endif href="{{ route('employee.index') }}"
                        class="nav-link">
                        <i class="fas fa-chalkboard-teacher color-white m-r-10"></i>
                        <p class="color-white">
                            Employee Dashboard

                        </p>
                    </a>
                </li>
                @include('includes.employee.sidebar_items')
            @endcan
        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->
</aside>
