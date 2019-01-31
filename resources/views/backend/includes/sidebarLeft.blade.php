<aside id="sidebar-left" class="sidebar-left">

    <div class="sidebar-header">
        <div class="sidebar-title">
            Navigation
        </div>
        <div class="sidebar-toggle hidden-xs" data-toggle-class="sidebar-left-collapsed" data-target="html"
             data-fire-event="sidebar-left-toggle">
            <i class="fa fa-bars" aria-label="Toggle sidebar"></i>
        </div>
    </div>

    <div class="nano">
        <div class="nano-content">
            <nav id="menu" class="nav-main" role="navigation">
                <ul class="nav nav-main">
                    <li class="nav">
                        <a href="{{url('admin')}}">
                            <i class="fa fa-dashboard" aria-hidden="true"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-parent">
                        <a>
                            <i class="fa fa-th" aria-hidden="true"></i>
                            <span>Product Category</span>
                        </a>
                        <ul class="nav nav-children">
                            <li>
                                <a href="{{url('admin/category')}}">
                                    Product Categories
                                </a>
                            </li>

                        </ul>
                    </li>
                    <li class="nav-parent">
                        <a>
                            <i class="fa fa-th" aria-hidden="true"></i>
                            <span>Product</span>
                        </a>
                        <ul class="nav nav-children">
                            {{--<li>--}}
                                {{--<a href="{{url('admin/product/add/1')}}">--}}
                                    {{--Add New Product--}}
                                {{--</a>--}}
                            {{--</li>--}}
                            <li>
                                <a href="{{url('admin/product/create')}}">
                                    Add New Product
                                </a>
                            </li>
                            <li>
                                <a href="{{url('admin/product/list/1')}}">
                                    Product List
                                </a>
                            </li>

                        </ul>
                    </li>
                    <li class="nav">
                        <a href="{{url('admin/banners')}}">
                            <i class="fa fa-th" aria-hidden="true"></i>
                            <span>Banners</span>
                        </a>
                    </li>
                    <li class="nav">
                        <a href="{{url('admin/brands')}}">
                            <i class="fa fa-th" aria-hidden="true"></i>
                            <span>Top Brands</span>
                        </a>
                    </li>
                    <li class="nav">
                        <a href="{{url('admin/customer_message')}}">
                            <i class="fa fa-th" aria-hidden="true"></i>
                            <span>Customer Message</span>
                        </a>
                    </li>
        
                    <li class="nav">
                        <a href="{{url('admin/order/list')}}">
                            <i class="fa fa-list" aria-hidden="true"></i>
                            <span>Order List</span>
                        </a>
                    </li>

                    <li class="nav">
                        <a href="{{url('admin/product_request')}}">
                            <i class="fa fa-th" aria-hidden="true"></i>
                            <span>Product Requests</span>
                        </a>
                    </li>
                    <li class="nav">
                            <a href="{{url('admin/request_brands')}}">
                                <i class="fa fa-th" aria-hidden="true"></i>
                                <span>Request Brands</span>
                            </a>
                        </li>

                    <hr class="sperator">
                    <li class="nav-parent">
                        <a>
                            <i class="fa fa-th" aria-hidden="true"></i>
                            <span>Settings</span>
                        </a>
                        <ul class="nav nav-children">
                            <li>
                                <a href="{{url('admin/settings/return_policy')}}">
                                    Return Policy
                                </a>
                            </li>
                            <li>
                                <a href="{{url('admin/settings/shipping_info')}}">
                                    Shipping Info
                                </a>
                            </li>

                        </ul>
                    </li>
                    <hr class="sperator">
                    <li class="nav">
                        <a href="{{url('/')}}" target="_blank">
                            <i class="fa fa-home" aria-hidden="true"></i>
                            <span>Website</span>
                        </a>
                    </li>
                </ul>
            </nav>

        </div>
    </div>


</aside>