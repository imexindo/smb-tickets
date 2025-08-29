<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
  <div class="app-brand demo">
    <a href="/admin/dashboard" class="app-brand-link">
      <span class="app-brand-logo demo">
        <img src="{{ asset('assets/logo.png') }}" alt="" srcset="" width="40px">
      </span>
      {{-- <span class="app-brand-text demo menu-text fw-bolder ms-2">SMB TICKET</span> --}}
    </a>

    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
      <i class="bx bx-chevron-left bx-sm align-middle"></i>
    </a>
  </div>

  <div class="menu-inner-shadow"></div>

  <ul class="menu-inner py-1">
    <!-- Dashboard -->
    <li class="menu-item active">
      <a href="{{ route('dashboard') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-home-circle"></i>
        <div data-i18n="Analytics">Dashboard</div>
      </a>
    </li>

    <!-- Layouts -->
    <li class="menu-item">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-layout"></i>
        <div data-i18n="Layouts">Layouts</div>
      </a>

      <ul class="menu-sub">
        <li class="menu-item">
          <a href="layouts-without-menu.html" class="menu-link">
            <div data-i18n="Without menu">Without menu</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="layouts-without-navbar.html" class="menu-link">
            <div data-i18n="Without navbar">Without navbar</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="layouts-container.html" class="menu-link">
            <div data-i18n="Container">Container</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="layouts-fluid.html" class="menu-link">
            <div data-i18n="Fluid">Fluid</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="layouts-blank.html" class="menu-link">
            <div data-i18n="Blank">Blank</div>
          </a>
        </li>
      </ul>
    </li>

    <li class="menu-header small text-uppercase">
      <span class="menu-header-text">Pages</span>
    </li>
    <li class="menu-item">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-lock-open-alt"></i>
        <div data-i18n="Authentications">Authentication</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item">
          <a href="{{ route('users.index') }}" class="menu-link">
            <div data-i18n="Basic">Users</div>
          </a>
        </li>
      </ul>
    </li>


    <li class="menu-header small text-uppercase"><span class="menu-header-text">Misc</span></li>
    <li class="menu-item">
      <a
        href="https://SMB TICKET.com/demo/sneat-bootstrap-html-admin-template/documentation/"
        target="_blank"
        class="menu-link"
      >
        <i class="menu-icon tf-icons bx bx-file"></i>
        <div data-i18n="Documentation">Documentation</div>
      </a>
    </li>
  </ul>
</aside>