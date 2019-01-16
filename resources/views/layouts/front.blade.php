<!DOCTYPE html>
<html lang="en">
<!--heaaderlink-->
@include('includes.frontHeaderlink')
@stack('login_css')
 <!--headerlink end-->
<body>
<section class="wrapper" style="display: none;">
    <div class="spinner">
        <i></i>
        <i></i>
        <i></i>
        <i></i>
        <i></i>
        <i></i>
        <i></i>
    </div>
</section>
<input type="hidden" name="base_url" id="base_url" value="{{url('/')}}">

<!--menu-->
@include('includes.frontMenu')
<!--menu end-->
<div class="alerts">
    @if (session('info'))
    <div class="alert alert-info alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>{{session('info')}}</strong>
    </div>
    @endif
    @if (session('success'))
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>{{session('success')}}</strong>
    </div>
    @endif
    @if (session('danger'))
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>{{session('danger')}}</strong>
    </div>
    @endif
    @if (session('warning'))
    <div class="alert alert-warning alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>{{session('warning')}}</strong>
    </div>
    @endif
</div>
@yield('content')

@include('includes.login_modal')
@include('includes.signup_modal')
<!--footer-->
{{-- @include('includes.frontFooter') --}}
<!--footer end-->

<!--footerlink-->
@include('includes.frontFooterlink')
@stack('signupJs')
@stack('loginJs')
@stack('passwordJs')
<!--footerlink end-->
</body>
</html>