<head>
    <!-- Basic -->
    <meta charset="UTF-8">
    <title>@yield('title') | YClassyCloset</title>
    <meta name="keywords" content="YClassyCloset" />
    <meta name="description" content="YClassyCloset">
    <meta name="author" content="tahminaiti@gmail.com">


    <meta name="csrf-token" content="{{ csrf_token() }}">


    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

    <!-- Web Fonts  -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="{{url('resources/assets/backend')}}/vendor/bootstrap/css/bootstrap.css" />

    <link rel="stylesheet" href="{{url('resources/assets/backend')}}/vendor/font-awesome/css/font-awesome.css" />
    <link rel="stylesheet" href="{{url('resources/assets/backend')}}/vendor/magnific-popup/magnific-popup.css" />
    <link rel="stylesheet" href="{{url('resources/assets/backend')}}/vendor/bootstrap-datepicker/css/datepicker3.css" />

    <!-- Theme CSS -->
    <link rel="stylesheet" href="{{url('resources/assets/backend')}}/stylesheets/theme.css" />

    <!-- Skin CSS -->
    <link rel="stylesheet" href="{{url('resources/assets/backend')}}/stylesheets/skins/default.css" />

    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="{{url('resources/assets/backend')}}/stylesheets/theme-custom.css">

    @yield('customCss')

    <!-- Head Libs -->
    <script src="{{url('resources/assets/backend')}}/vendor/modernizr/modernizr.js"></script>
</head>