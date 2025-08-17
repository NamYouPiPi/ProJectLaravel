 @include ("Backend.partials.header")
 <meta name="csrf-token" content="{{ csrf_token() }}">
  </head>
  <body class="layout-fixed sidebar-expand-lg sidebar-open bg-body-tertiary">
    <!--begin::App Wrapper-->
    <div class="app-wrapper">
      <!--begin::Header-->
      <nav class="app-header navbar navbar-expand bg-body">
        <!--begin::Container-->
   @include("Backend.partials.navbar")
        <!--end::Container-->
      </nav>
      <!--end::Header-->
      <!--begin::Sidebar-->
      @include("Backend.partials.sidebar")
      <!--end::Sidebar-->
      <!--begin::App Main-->
      <main class="app-main">
        <!--begin::App Content Header-->
   @yield("content")
        <!--end::App Content-->
      </main>


    </div>
    <!--end::App Wrapper-->
    <!--begin::Script-->
 @include("Backend.partials.footer")

    <!--end::Script-->
  </body>
  <!--end::Body-->
</html>
