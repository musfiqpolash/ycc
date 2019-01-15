<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
@include('includes.authHeaderlink')
<body>
<!-- start: page -->
@yield('content')
<!-- end: page -->

@include('includes.authFooterlink')
</body>
</html>