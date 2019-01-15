<head>
    <title>@yield('title') | YClassyCloset</title>
    <!-- BEGIN META -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="your,keywords">
    <meta name="description" content="Short explanation about this website">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{url('resources/assets/frontend')}}/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{url('resources/assets/frontend')}}/css/style.css">
    <link rel="stylesheet" href="{{url('resources/assets/frontend')}}/css/font-awesome.css">
    <link rel="stylesheet" href="{{url('resources/assets/frontend')}}/css/newLoader.css">
    <link rel="stylesheet" href="{{ url('public/OwlCarousel/assets/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ url('public/OwlCarousel/assets/owl.theme.default.min.css') }}">
    @yield('customCss')
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>