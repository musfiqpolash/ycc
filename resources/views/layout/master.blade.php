<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SSP WEB</title>
    <link rel="stylesheet" href="{{URL::to('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{URL::to('css/style.css')}}">
    <link rel="stylesheet" href="{{URL::to('css/font-awesome.css')}}">
    <link rel="stylesheet" href="{{URL::to('magiczoom/magiczoom.css')}}"/>
    @yield('style')
    <script type="text/javascript" src="{{URL::to('js/jquery-3.3.1.min.js')}}"></script>
    <script type="text/javascript" src="{{URL::to('js/bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{URL::to('magiczoom/magiczoom.js')}}"></script>
    <script type="text/javascript" src="{{URL::to('js/jquery.validate.js')}}"></script>
    <script type="text/javascript" src="{{URL::to('js/validation.js')}}"></script>
    <script type="text/javascript" src="{{URL::to('js/jquery.payment.js')}}"></script>
    <script type="text/javascript" src="{{URL::to('js/checkout.js')}}"></script>
</head>
<body>

@include('layout.navBar')

@yield('content')

@include('layout.footer')
@yield('script')
</body>
</html>