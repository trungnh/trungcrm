<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>{{ config('app.name') }} @yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    {{--{!! google_analytics() !!}--}}
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link rel="manifest" href="{{asset('site.webmanifest')}}">
    <link rel="apple-touch-icon" href="{{ asset('icon.png') }}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Custom fonts for this template-->
    <link href="{{ asset('lib/bootstrap/css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ mix('css/admin/admin.css') }}" rel="stylesheet">

    @if (config('app.env') !== 'production')
        <meta name="robots" content="noindex,nofollow">
        <meta name="googlebot" content="none, noarchive, nosnippet, notranslate, noimageindex">
    @endif

    @yield('head')
</head>
<body class="{{ app()->getLocale() }}">
<div id="@yield('pageId', 'frontendPage')" class="mainModule mainComponent frontendPage @yield('pageId') @yield('pageClasses')">
    <header>
        @include('admin.partials.header')
        @yield('header')
    </header>

    <main class="main">
        <div class="wrapper">
            @include('admin.partials.nav')
            <!-- Main content -->
                <div class="main-content" id="panel">
                    <div class="header bg-primary pb-6">
                        <div class="container-fluid">
                            @include('admin.partials.top_navbar')
                            @yield('content')
                        </div>
                    </div>
                </div>
        </div>
    </main>

    <footer>
        @yield('footer')
        @include('admin.partials.footer')
    </footer>
</div>

<!-- Scripts -->
<script src="{{ asset('lib/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('lib/lodash/lodash.min.js') }}"></script>
<script src="{{ asset('lib/vue/vue.min.js') }}"></script>
<script src="{{ asset('lib/vuex/vuex.min.js') }}"></script>
<script src="{{ asset('lib/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ mix('js/admin.js') }}" defer></script>
</body>
</html>
