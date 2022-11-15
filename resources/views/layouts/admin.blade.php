<!DOCTYPE html>
<html>
   <head>
      <meta charset="UTF-8">
      <meta name="viewport"
         content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <link rel="shortcut icon" href="{{ asset('media/logos/favicon.ico') }}" />
      <title>{{ config('app.name', 'Laravel') }}</title>
      @include('assets.css.style')
      @yield('styles')
   </head>
   <body id="kt_app_body" data-kt-app-layout="dark-sidebar" data-kt-app-header-fixed="true" data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true" data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true" class="app-default">
    <script>var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-theme-mode")) { themeMode = document.documentElement.getAttribute("data-theme-mode"); } else { if ( localStorage.getItem("data-theme") !== null ) { themeMode = localStorage.getItem("data-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-theme", themeMode); }</script>
      <!--begin::Root-->
      <div class="app-page flex-column flex-column-fluid" id="kt_app_page">

      {{-- Main content --}}
      @include('partials.header')
      <!--begin::Wrapper-->
      <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">

        @include('partials.menu')
         <section class="content" style="padding-top: 0px;">
            @if (session('message'))
            <div class="row mb-2">
            <div class="col-lg-12">
                <div class="alert {{ session('alertClass') ?? 'alert-success' }}" role="alert">
                    {{ session('message') }}
                </div>
            </div>
            </div>
            @endif
            @include('components.validation-errors', ['errors' => $errors])
        </section>
         @yield('content')
         @include('partials.footer')

         <form id="logoutform" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
         </form>
      </div>
      </div>

      @include('assets.js.script')
      @yield('scripts')
   </body>
</html>
