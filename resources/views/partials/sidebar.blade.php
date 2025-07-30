   <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
        <!--begin::Sidebar Brand-->
        <div class="sidebar-brand">
          <!--begin::Brand Link-->
          <a href="./index.html" class="brand-link">
            <!--begin::Brand Image-->
            <img
              src="{{asset('./assets/img/AdminLTELogo.png')}}"
              alt="AdminLTE Logo"
              class="brand-image opacity-75 shadow"
            />
            <!--end::Brand Image-->
            <!--begin::Brand Text-->
            <span class="brand-text fw-light">WebDevelopment </span>
            <!--end::Brand Text-->
          </a>
          <!--end::Brand Link-->
        </div>
        <!--end::Sidebar Brand-->
        <!--begin::Sidebar Wrapper-->
        <div class="sidebar-wrapper">
          <nav class="mt-2">
            <!--begin::Sidebar Menu-->
            <ul
              class="nav sidebar-menu flex-column"
              data-lte-toggle="treeview"
              role="navigation"
              aria-label="Main navigation"
              data-accordion="false"
              id="navigation"
            >
             <li class="nav-item  @yield('dashboard')">
                <a href="{{url('/')}}" class="nav-link">
                  <i class="nav-icon bi bi-palette"></i>
                  <p>Dashboard </p>
                </a>
              </li>
              <li class="nav-item @yield('menu-open')">
                <a href="#" class="nav-link ">
                  <i class="nav-icon bi bi-speedometer"></i>
                  <p>
                    Item
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item ">
                    <a href="{{url('/unit')}}" class="nav-link @yield('unit')">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Unit</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Item Type</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Item</p>
                    </a>
                  </li>
                </ul>
              </li>
     
            </ul>
            <!--end::Sidebar Menu-->
          </nav>
        </div>
        <!--end::Sidebar Wrapper-->
      </aside>