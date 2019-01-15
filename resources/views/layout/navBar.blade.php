<nav class="navbar navbar-fixed-top">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-sm-3 sspHide">
                <img src="images/sslogo.png" alt="sspLogo" width="160px" height="80px">
            </div>
            <div class="col-xs-3 sspShow ni1">
                <img src="images/logo.png" alt="sspLogo" height="60px" width="60px">
            </div>
            <div class="col-md-3 col-sm-3 col-xs-2 middle ni2">
                <a href="{{route('home')}}">Home</a>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-4 middle ni3">
                <a href="{{route('contact_us')}}">Contact Us</a>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-3 right ni4">
                <i class="fa fa-shopping-cart fa-3x" aria-hidden="true"></i>
                <span>{{$num}}</span>
            </div>
        </div>

    </div>
</nav>