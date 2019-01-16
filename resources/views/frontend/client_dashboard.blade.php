@extends('layouts.front')

@section('title','Dashboard')


@section('content')
    <div class="container">
        <div class="row">
            @include('includes.profile_sidebar')
            <div class="col-md-3">
                <div class="dash-tab bg-green">
                    <i class="fa fa-cart-arrow-down"></i>
                    <div class="dash-right">
                        <p class="number">0</p>
                        <p class="txt">Pending Order</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="dash-tab bg-blue">
                    <i class="fa fa-cart-plus"></i>
                    <div class="dash-right">
                        <p class="number">1</p>
                        <p class="txt">Total Order</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="dash-tab bg-sky">
                    <i class="fa fa-usd"></i>
                    <div class="dash-right">
                        <p class="number">505</p>
                        <p class="txt">Transaction</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection