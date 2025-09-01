
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="/admin/dashboard" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img src="{{ asset('assets/logo.png') }}" alt="" srcset="" width="150px">
            </span>
            {{-- <span class="app-brand-text demo menu-text fw-bolder ms-2">SMB TICKET</span> --}}
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Pages</span>
        </li>

        <li class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <a href="{{ route('dashboard') }}" class="menu-link">
                <div data-i18n="Analytics">
                  <i class="fa fa-home" style="padding-right: 10px"></i> 
                  Dashboard
                </div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('karyawan.*', 'departements.*') ? 'open active' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-layout"></i>
                <div data-i18n="Layouts">Master</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('karyawan.*') ? 'active' : '' }}">
                    <a href="{{ route('karyawan.index') }}" class="menu-link">
                        <div data-i18n="Without menu">Employees</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('departements.*') ? 'active' : '' }}">
                    <a href="{{ route('departements.index') }}" class="menu-link">
                        <div data-i18n="Basic">Departments</div>
                    </a>
                </li>
            </ul>
        </li>

        <li class="menu-item {{ request()->routeIs('users.*', 'roles.*', 'permissions.*') ? 'open active' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-lock-open-alt"></i>
                <div data-i18n="Authentications">Authentication</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
                    <a href="{{ route('users.index') }}" class="menu-link">
                        <div data-i18n="Basic">Users</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('roles.*') ? 'active' : '' }}">
                    <a href="{{ route('roles.index') }}" class="menu-link">
                        <div data-i18n="Basic">Roles</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('permissions.*') ? 'active' : '' }}">
                    <a href="{{ route('permissions.index') }}" class="menu-link">
                        <div data-i18n="Basic">Permissions</div>
                    </a>
                </li>

            </ul>
        </li>



        <li class="menu-header small text-uppercase"><span class="menu-header-text">DOC</span></li>
        <li class="menu-item">
            <a href="#" target="_blank" class="menu-link">
                <i class="menu-icon tf-icons bx bx-file"></i>
                <div data-i18n="Documentation">Documentation</div>
            </a>
        </li>
    </ul>
</aside>
