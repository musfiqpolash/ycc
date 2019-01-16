@extends('layouts.front')

@section('title','Orders')


@section('content')
    <div class="container">
        <div class="row">
            @include('includes.profile_sidebar')

            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading bg-nav text-white h4 m-0">Orders</div>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Order Number</th>
                                        <th>Order Date</th>
                                        <th>Order Status</th>
                                        <th>Price</th>
                                        <th>Paid</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1025487</td>
                                        <td>20/01/2018</td>
                                        <td>Delivered</td>
                                        <td>$250</td>
                                        <td>$250</td>
                                        <td><a href="{{ url('client/order/1') }}"><span class="badge">View</span></a></td>
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