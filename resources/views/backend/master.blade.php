<!doctype html>
<html lang="en">
  <!--begin::Head-->
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>AdminLTE v4 | Dashboard</title>
   @include('backend.include.style')
  </head>
  <!--end::Head-->
  <!--begin::Body-->
  <body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <!--begin::App Wrapper-->
    <div class="app-wrapper">
      <!--begin::Header-->
     @include('backend.include.navber')
      <!--end::Header-->
      <!--begin::Sidebar-->
     @include('backend.include.sidebar')
      <!--end::Sidebar-->
      <!--begin::App Main-->
      <main class="app-main">
       @yield('content')
      </main>
      <!--end::App Main-->
      <!--begin::Footer-->
     @include('backend.include.footer')
      <!--end::Footer-->
    </div>
    <!--end::App Wrapper-->
    <!--begin::Script-->
    @include('backend.include.script')
    <!--end::Script-->
  </body>
  <!--end::Body-->
</html>
