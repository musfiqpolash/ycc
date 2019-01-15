<nav id="top-nav" class="navbar navbar-custom">
    <div class="container">
        <!-- Collect the nav links, forms, and other content for toggling -->
        <ul class="nav navbar-nav">
            <li><a href="{{url('/')}}">Home</a></li>
            <li><a href="{{url('/contact_us')}}">Contact Us</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            @if (auth('client')->check())
            <li><a href="{{url('client/profile')}}">{{auth('client')->user()->first_name}}</a></li>
            @else
            <li><a data-toggle="modal" data-target="#client_signup_modal">Register</a></li>
            <li><a data-toggle="modal" data-target="#client_login_modal">Login</a></li>
            @endif
        </ul>
    </div><!-- /.container-fluid -->
</nav>

<div class="nav-after">
    <div class="container">
        <div class="row">

            <div class="col-md-3" id="custom-nav-left">
                <a href="{{url('/')}}">

                    <img src="{{url('public/logo.png')}}" alt="logo" height="100">
                </a>
            </div>

            <div class="col-md-6" id="custom-nav-middle">
                <span>
                    <i class="fa fa-phone"></i> 01713000000
                </span>
                <span>
                    <i class="fa fa-envelope"></i> info@yclassycloset.com
                </span>

                <form class="form-inline">
                    <div class="form-group form-custom" style="margin: 0;">
                        <label class="sr-only" for="search">Search</label>
                        <input type="search" name="search" class="form-control" id="search" placeholder="Search">
                    </div>
                    <div class="form-group form-custom" style="margin: 0;">
                        <label class="sr-only" for="category">Category</label>
                        <div class="input-group">
                            <select name="category" id="category" class="form-control">
                                <option value="">All Category</option>
                                <option value="1">Category 1</option>
                                <option value="2">Category 2</option>
                                <option value="3">Category 3</option>
                            </select>
                            <div class="input-group-addon" style="padding: 4px; border-radius: 0;">
                                <button type="submit" class="btn"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                    <!-- <button type="submit" class="btn btn-default" style="height:45px;"><i class="fa fa-search"></i></button> -->
                </form>

            </div>

            <div class="col-md-3" id="custom-nav-right">
                <a href="{{url('/cart')}}" style="text-decoration: none;">
                    <i class="fa fa-shopping-cart fa-3x" aria-hidden="true"></i>
                    <span id="cartTotal" class="crtNum">{{sprintf("%'.02d", Cart::count())}}</span>
                </a>
            </div>
        </div>
    </div>
</div>
<nav class="navbar navbar-custom">
    <div class="container">
        <div class="owl-carousel">
            <a href="#">Cat 1</a>
            <a href="#">Cat 2</a>
            <a href="#">Cat 3</a>
            <a href="#">Cat 4</a>
            <a href="#">Cat 5</a>
            <a href="#">Cat 6</a>
            <a href="#">Cat 7</a>
            <a href="#">Cat 8</a>
            <a href="#">Cat 9</a>
            <a href="#">Cat 10</a>

        </div>
</nav>
</div>