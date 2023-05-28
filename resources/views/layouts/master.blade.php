<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Language" content="en"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'MatchCrafters')</title>
    <script>
        window.App = {
            mixins: [],
        };
    </script>
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,300i,400,400i,500,500i,600,600i,700,700i&amp;subset=latin-ext">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet"/>
    <!-- Start of moneymatchenterprise Zendesk Widget script -->
{{--    <script id="ze-snippet" src="https://static.zdassets.com/ekr/snippet.js?key=7da16520-3e95-470a-b877-6cf82af0560d"> </script>--}}
    <!-- End of moneymatchenterprise Zendesk Widget script -->

    @yield('head')
</head>
<body>
<div id="app" class="page">
    <div class="@yield('page.class') d-flex flex-column">
        @section('header')

        @show
        <main class="py-4">
            @yield('content')
        </main>
        @section('footer')

        @show
    </div>
</div>
@yield('custom-js')
@stack('mixins')
@stack('scripts')
</body>
@yield('transfer-filter-js')
</html>
