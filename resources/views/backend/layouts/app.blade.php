<!doctype html>
<html class="fixed">
<head>

    <!-- Basic -->
    <meta charset="UTF-8">

    <title>Dashboard | YClassyCloset</title>
    <meta name="keywords" content="YClassyCloset" />
    <meta name="description" content="YClassyCloset">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

    @include('backend.includes.headerLinks')


</head>
<body>
<section class="body">
    <!-- start: header -->
@include('backend.includes.header')


    <div class="inner-wrapper">
        <!-- start: sidebar -->
        @include('backend.includes.sidebarLeft')
        <!-- end: sidebar -->

        <section role="main" class="content-body">
            <header class="page-header">
                <h2>@yield('dashboardLeft')</h2>

                <div class="right-wrapper pull-right">
                    <ol class="breadcrumbs">
                        <li>
                            <a href="#">
                                <i class="fa fa-home"></i>
                            </a>
                        </li>
                        @yield('dashboardRight')
                    </ol>

                    <a class="sidebar-right-toggle" data-open="sidebar-right"></a>
                </div>
            </header>

            <!-- start: page -->
            @yield('content')
            <!-- end: page -->
        </section>
    </div>

    @include('backend.includes.sidebarRight')
</section>

<!-- Vendor -->
@include('backend.includes.footerLinks')

</body>
</html>