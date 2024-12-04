<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        
        @vite([
            'public/plugins/fontawesome-free/css/all.min.css',
            'public/plugins/ekko-lightbox/ekko-lightbox.css',
            'public/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css',
            'public/plugins/icheck-bootstrap/icheck-bootstrap.min.css',
            'public/plugins/jqvmap/jqvmap.min.css',
            'public/dist/css/adminlte.min.css',
            'public/plugins/overlayScrollbars/css/OverlayScrollbars.min.css',
            'public/plugins/daterangepicker/daterangepicker.css',
            'public/plugins/summernote/summernote-bs4.min.css',
            ])
    </head>
    <body class="hold-transition sidebar-mini layout-fixed">       
            <!-- Page Content -->
            <div class="wrapper">
                <!-- Include Navbar -->
                @include('layouts.navigation')
                <!-- Include Sidebar -->
                @include('layouts.sidebar')
                <!-- Preloader -->
                <div class="preloader flex-column justify-content-center align-items-center">
                    <img class="animation__shake" src="{{ Vite::asset('public/dist/img/logo-rj.png') }}" alt="Rendering..." height="60" width="60">
                </div>
                {{ $slot }}
                <!-- Include footer -->
                @include('layouts.footer')
            </div>
    </body>
    <!-- jQuery -->
    <script>
    $.widget.bridge('uibutton', $.ui.button)
    </script>

    @vite([
            'public/plugins/jquery/jquery.min.js',
            'public/plugins/jquery-ui/jquery-ui.min.js',
            'public/plugins/bootstrap/js/bootstrap.bundle.min.js',
            'public/plugins/chart.js/Chart.min.js',
            'public/plugins/sparklines/sparkline.js',
            'public/plugins/jqvmap/jquery.vmap.min.js',
            'public/plugins/jqvmap/maps/jquery.vmap.usa.js',
            'public/plugins/jquery-knob/jquery.knob.min.js',
            'public/plugins/moment/moment.min.js',
            'public/plugins/daterangepicker/daterangepicker.js',
            'public/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js',
            'public/plugins/summernote/summernote-bs4.min.js',
            'public/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js',
            'public/dist/js/adminlte.js',
            'public/plugins/ekko-lightbox/ekko-lightbox.min.js',
            'public/plugins/filterizr/jquery.filterizr.min.js',
            'public/dist/js/demo.js',
            'public/dist/js/pages/dashboard.js'
            ])
</html>
