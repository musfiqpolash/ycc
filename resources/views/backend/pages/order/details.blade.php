@extends('backend.layouts.app')

@section('dashboardRight')
    <li>
        <a href="#">
            <span>Order</span>
        </a>
    </li>
    <li>
        <a href="#">
            <span>Order List</span>
        </a>
    </li>
    <li>
        <a href="#">
            <span>Order Details</span>
        </a>
    </li>
@endsection

@section('content')
    <section class="panel">
        <header class="panel-heading">
            <h2 class="panel-title">Order Details</h2>
        </header>
        <div class="panel-body">
            @include('includes.flashMessage')
            <div class="row">
                <div class="col-md-12">
                    <div class="tabs">
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a href="#order_details" data-toggle="tab"><i class="fa fa-file"></i> Order Details</a>
                            </li>
                            <li>
                                <a href="#item_details" data-toggle="tab"><i class="fa fa-info-circle"></i> Item Details</a>
                            </li>
                            <li>
                                <a href="#payment_details" data-toggle="tab"><i class="fa fa-money"></i> Payment Details</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div id="order_details" class="tab-pane active">
                                <table class="table table-striped">
                                    <tr>
                                        <td>Order Date</td>
                                        <td>{{$page_data->d_date}}</td>
                                    </tr>
                                    <tr>
                                        <td class="col-md-3">Order No</td>
                                        <td>{{$page_data->slug}}</td>
                                    </tr>
                                    <tr>
                                        <td>Transaction Id</td>
                                        <td>{{$page_data->transaction_id}}</td>
                                    </tr>
                                    <tr>
                                        <td>Shipping Point</td>
                                        @php
                                        $tmp=json_decode($page_data->shipping_point);
                                        @endphp
                                        <td>
                                            <table class="table ">
                                                @foreach($tmp as $sk=>$sval)
                                                    <tr>
                                                        <td class="col-md-4">{{str_replace('_',' ',ucfirst($sk))}} </td>
                                                        <td>{{$sval}}</td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Order Amount</td>
                                        <td>$ {{$page_data->order_amount}}</td>
                                    </tr>
                                </table>
                            </div>
                            <div id="item_details" class="tab-pane">
                                <table class="table table-bordered table-striped">
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">Image</th>
                                        <th class="text-center">Name</th>
                                        <th class="text-center">Color</th>
                                        <th class="text-center">Size</th>
                                        <th class="text-center">Quantity</th>
                                        <th class="text-center">Unit Price</th>
                                        <th class="text-center">Total Price</th>
                                    </tr>
                                    @php $ttl=0; @endphp
                                    @foreach($page_data->hasOrderDetails as $k=>$val)
                                        <tr>
                                            <td class="text-center">{{$k+1}}</td>
                                            <td class="text-center">
                                                <img style="width: 50px; height: auto"
                                                     src="{{url('public/uploads/assets/frontend/images/products/'.$val->hasProduct->main_image)}}"
                                                     alt="{{$val->hasProduct->main_image}}">
                                            </td>
                                            <td>{{$val->hasProduct->name}}</td>
                                            <td class="text-center">{{$val->hasProduct->color}}</td>
                                            <td class="text-center">{{$val->hasProduct->size}}</td>
                                            <td class="text-center">{{$val->p_qty}}</td>
                                            <td class="text-right">${{$val->p_sell_price}}</td>
                                            <td class="text-right">${{$val->p_qty*$val->p_sell_price}}</td>
                                            @php $ttl+= $val->p_qty*$val->p_sell_price; @endphp
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td class="text-right" colspan="7">SubTotal</td>
                                        <td class="text-right">$ {{$ttl}}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-right" colspan="7">Shipping Cost</td>
                                        <td class="text-right">$ {{$page_data->shipping_cost}}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-right" colspan="7">Total</td>
                                        <td class="text-right">$ {{$page_data->order_amount}}</td>
                                    </tr>
                                </table>
                            </div>
                            <div id="payment_details" class="tab-pane">
                                <table class="table table-striped">
                                    <tr>
                                        <td class="col-md-3">Transaction Id</td>
                                        <td>{{$page_data->transaction_id}}</td>
                                    </tr>
                                    <tr>
                                        <td>Payment Method</td>
                                        <td>{{$page_data->hasPayment->payment_method}}</td>
                                    </tr>
                                    <tr>
                                        <td>Payee Email</td>
                                        <td>{{$page_data->hasPayment->email}}</td>
                                    </tr>
                                    <tr>
                                        <td>Payee First Name</td>
                                        <td>{{$page_data->hasPayment->first_name}}</td>
                                    </tr>
                                    <tr>
                                        <td>Payee Last Name</td>
                                        <td>{{$page_data->hasPayment->last_name}}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </div>
    </section>
@endsection

@section('customJs')
    <script src="{{url('resources/assets/backend/vendor/dataTbl')}}/jquery.dataTables.min.js"></script>
    <script src="{{url('resources/assets/backend/vendor/dataTbl')}}/dataTables.bootstrap4.min.js"></script>
    <script>
        function getApproval(id) {
            var c = confirm('Do You Want To Delete This Product?');
            if (c) {
                $('#prdctDltFrm' + id).submit();
            }
        }
        $('#example').dataTable({
            "ordering": false
        });
    </script>
@endsection
@section('customCss')
    <style>
        .colorSale {
            background: #c7432a;
        }

        .colorOut {
            color: red;
        }
    </style>
    <link rel="stylesheet" href="{{url('resources/assets/backend/vendor/dataTbl')}}/dataTables.bootstrap4.min.css">
@endsection