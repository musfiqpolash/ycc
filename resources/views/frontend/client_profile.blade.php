@extends('layouts.front')

@section('title','Profile')


@section('content')
    <div class="container">
        <h4>Welcome {{auth('client')->user()->first_name.' '.auth('client')->user()->last_name}}</h4>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Order Id</th>
                        <th>Price</th>
                        <th>Status</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection