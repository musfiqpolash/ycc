<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SSP WEB</title>
    <link rel="stylesheet" href="{{URL::to('css/bootstrap.min.css')}}">
    @yield('style')
    <script type="text/javascript" src="{{URL::to('js/jquery-3.3.1.min.js')}}"></script>
    <script type="text/javascript" src="{{URL::to('js/bootstrap.min.js')}}"></script>
</head>
<body>

@yield('content')

@yield('script')
</body>
</html>