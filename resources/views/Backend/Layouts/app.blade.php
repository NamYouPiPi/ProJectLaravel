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
      <!--end::App Main-->
      <!--begin::Footer-->
      <footer class="app-footer">
        <!--begin::To the end-->
        <div class="float-end d-none d-sm-inline">Anything you want</div>
{{--        <!--end::To the end-->--}}
{{--        <!--begin::Copyright-->--}}
{{--        <strong>--}}
{{--          Copyright &copy; 2014-2025&nbsp;--}}
{{--          <a href="https://adminlte.io" class="text-decoration-none">AdminLTE.io</a>.--}}
{{--        </strong>--}}
{{--        All rights reserved.--}}
        <!--end::Copyright-->
      </footer>
      <!--end::Footer-->
    </div>
    <!--end::App Wrapper-->
    <!--begin::Script-->
 @include("Backend.partials.footer")

    <!--end::Script-->
  </body>
  <!--end::Body-->
</html>
