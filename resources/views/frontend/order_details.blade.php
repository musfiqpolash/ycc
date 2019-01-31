@extends('layouts.front')

@section('title','Orders')


@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('includes.profile_sidebar')

            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading h4 bg-nav text-white m-0">Order Information</div>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <td>Order Number</td>
                                <td>{{$order->slug}}</td>
                            </tr>
                            <tr>
                                <td>Order Date</td>
                                <td>{{$order->d_date}}</td>
                            </tr>
                            <tr>
                                <td>Order Status</td>
                                <td>Delivered</td>
                            </tr>
                            <tr>
                                <td>Payment</td>
                                <td>Paypal</td>
                            </tr>
                            <tr>
                                <td>Total Payed</td>
                                <td>${{$order->order_amount}}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                {{-- {{dd($order->hasOrderDetails[0]->hasProduct)}} --}}
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
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php($ttl=0)
                                    @foreach ($order->hasOrderDetails as $item)
                                        <tr>
                                            <td>{{$item->hasProduct->p_code}}</td>
                                            <td>{{$item->hasProduct->name}}</td>
                                            <td class="text-right">${{$item->hasProduct->hasPrice[0]->price}}</td>
                                            <td>{{$item->p_qty}}</td>
                                            <td class="text-right">${{$item->hasProduct->hasPrice[0]->price*$item->p_qty}}</td>
                                        </tr>
                                        @php($ttl+=$item->hasProduct->hasPrice[0]->price*$item->p_qty)
                                    @endforeach
                                    <tr>
                                        <td colspan="2" class="text-right"><b>Product Total</b></td>
                                        <td></td>
                                        <td></td>
                                        <td class="text-right">${{$ttl}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="text-right"><b>Shipping Cost</b></td>
                                        <td></td>
                                        <td></td>
                                        <td class="text-right">${{$order->shipping_cost}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="text-right"><b>Total</b></td>
                                        <td></td>
                                        <td></td>
                                        <td class="text-right">${{$ttl+$order->shipping_cost}}</td>
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