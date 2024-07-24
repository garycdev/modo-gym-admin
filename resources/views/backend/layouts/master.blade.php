<!doctype html>
{{-- <html class="no-js" lang="es"> --}}
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>@yield('title', 'Modo GYM Admin')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--favicon-->
    <link rel="icon" href="{{ asset('modo-gym/logo_2.png') }}" type="image/png" />
    @include('backend.layouts.partials.styles')
    @yield('styles')
    <style>
        .required_value::after {
            content: '*';
            color: #f00;
        }

        .text-danger.required_value {
            font-size: .85em;
        }
    </style>
</head>

<body>
    <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

    <!-- page container area start -->
    <div class="wrapper">

        @include('backend.layouts.partials.sidebar')

        <!-- main content area start -->

        @include('backend.layouts.partials.header')
        @yield('admin-content')

        <!-- main content area end -->
        <a href="javaScript:;" class="back-to-top"><i class="bx bxs-up-arrow-alt"></i></a>
        @include('backend.layouts.partials.footer')
    </div>
    <!-- page container area end -->

    {{-- @include('backend.layouts.partials.offsets') --}}
    @include('backend.layouts.partials.switcher')
    @include('backend.layouts.partials.scripts')
    @yield('scripts')
    {{-- <script></script> --}}
</body>

</html>
