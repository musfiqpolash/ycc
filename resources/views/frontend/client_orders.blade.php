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
                                        <th>Price</th>
                                        <th>Paid</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (auth('client')->user()->orders as $item)
                                        <tr>
                                            <td>{{$item->slug}}</td>
                                            <td>{{$item->d_date}}</td>
                                            <td>{{$item->order_amount}}</td>
                                            <td>{{$item->order_amount}}</td>
                                            <td><a href="{{ url('client/order/'.$item->id) }}"><span class="badge">View</span></a></td>
                                        </tr>
                                    @endforeach
                                    @if (auth('client')->user()->orders->count('id')==0)
                                    <tr>
                                        <td colspan="5" class="text-center">No Order Found</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection