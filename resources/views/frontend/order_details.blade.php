@extends('layouts.front')

@section('title','Orders')


@section('content')
    <div class="container">
        <div class="row">
            @include('includes.profile_sidebar')

            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading h4 bg-nav text-white m-0">Order Information</div>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <td>Order Number</td>
                                <td>1025487</td>
                            </tr>
                            <tr>
                                <td>Order Date</td>
                                <td>20/01/2018</td>
                            </tr>
                            <tr>
                                <td>Order Status</td>
                                <td>Delivered</td>
                            </tr>
                            <tr>
                                <td>Payment</td>
                                <td>Cash On Delivery</td>
                            </tr>
                            <tr>
                                <td>Total Payed</td>
                                <td>$505</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading bg-nav text-white h4 m-0">Order Items</div>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Product Code</th>
                                        <th>Product Name</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Discount</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>P123</td>
                                        <td>Lorem ipsum dolor sit amet.</td>
                                        <td>$250</td>
                                        <td class="text-right">2</td>
                                        <td class="text-right">0%</td>
                                        <td class="text-right">$500</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="text-right"><b>Product Total</b></td>
                                        <td></td>
                                        <td></td>
                                        <td class="text-right">$500</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="text-right"><b>Delivery Charge</b></td>
                                        <td></td>
                                        <td></td>
                                        <td class="text-right">$5</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="text-right"><b>Total</b></td>
                                        <td></td>
                                        <td></td>
                                        <td class="text-right">$505</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection