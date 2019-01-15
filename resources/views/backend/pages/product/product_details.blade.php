@extends('backend.layouts.app')

@section('dashboardRight')
    <li>
        <a href="#">
            <span>Product</span>
        </a>
    </li>
    <li>
        <a href="#">
            <span>@if($page_data->is_accessories==1)Product @else Accessories @endif List</span>
        </a>
    </li>
    <li>
        <a href="#">
            <span>@if($page_data->is_accessories==1)Product @else Accessories @endif Details</span>
        </a>
    </li>
@endsection

@section('content')
    <section class="panel">
        <header class="panel-heading">
            <h2 class="panel-title">{{$page_data->name}}
                <p class="panel-subtitle">{{$page_data->category}}</p></h2>
        </header>
        <div class="panel-body">
            @include('includes.flashMessage')
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="panel panel-info" style="border: 1px solid #bce8f1 !important;">
                                <header class="panel-heading">
                                    <h2 class="panel-title">General Information</h2>
                                </header>
                                <div class="panel-body">
                                    <div class="row">
                                        @if($page_data->is_accessories==1)
                                            <div class="col-xs-4 text-center">
                                                <b>COLOR</b><br><label
                                                        class="label label-primary">{{$page_data->color}}</label>
                                            </div>
                                            <div class="col-xs-4 text-center">
                                                <b>SIZE</b><br><label
                                                        class="label label-primary">{{$page_data->size}}</label>
                                            </div>
                                            <div class="col-xs-4 text-center">
                                                <b>STOCK</b><br><label
                                                        class="label label-primary">{{$page_data->quantity}}</label>
                                            </div>
                                        @else
                                            <div class="col-xs-6">
                                                <b>COLOR</b><br><label
                                                        class="label label-primary">{{$page_data->color}}</label>
                                            </div>
                                            <div class="col-xs-6">
                                                <b>STOCK</b><br><label
                                                        class="label label-primary">{{$page_data->quantity}}</label>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-xs-12">
                            <div class="panel panel-info" style="border: 1px solid #bce8f1 !important;">
                                <header class="panel-heading">
                                    <h2 class="panel-title">Price</h2>
                                </header>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <b>QUANTITY</b>
                                        </div>
                                        <div class="col-xs-6">
                                            <b>PER UNIT PRICE</b>
                                        </div>
                                        @foreach($page_data->hasPrice as $k=>$val)
                                            @if($loop->first)
                                                <div class="col-xs-6">
                                                    1
                                                </div>
                                                <div class="col-xs-6">
                                                    <label class="label label-primary">${{$val->price}}</label>
                                                </div>
                                            @else
                                                <div class="col-xs-6">
                                                    {{$val->min_quantity}} to {{$val->max_quantity}}
                                                </div>
                                                <div class="col-xs-6">
                                                    <label class="label label-primary">${{$val->price}}</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>

                            </div>
                        </div>
                        @if($page_data->is_accessories==1)
                            <div class="col-xs-12">
                                <div class="panel panel-info" style="border: 1px solid #bce8f1 !important;">
                                    <header class="panel-heading">
                                        <h2 class="panel-title">Carrier Information</h2>
                                    </header>
                                    <div class="panel-body">
                                        <div class="row">
                                            @if(!empty($page_data->carrier_details))
                                                <div class="col-xs-6">
                                                    <b>CARRIER</b>
                                                </div>
                                                <div class="col-xs-6">
                                                    <b>COMPATIBILITY RATING</b>
                                                </div>
                                                @php($pp=json_decode($page_data->carrier_details))
                                                @foreach($pp as $k)
                                                    <div class="col-xs-6">
                                                        {{$k->name}}
                                                    </div>
                                                    <div class="col-xs-6">
                                                        {{$k->description}}
                                                    </div>
                                                @endforeach
                                            @else
                                                <h4 class="text-center">Not Available</h4>
                                            @endif
                                        </div>
                                    </div>

                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="panel panel-info" style="border: 1px solid #bce8f1 !important;">
                        <header class="panel-heading">
                            <h2 class="panel-title">Images</h2>
                        </header>
                        <div class="panel-body">
                            <div class="row">
                                @foreach($page_data->hasImage as $k=>$value)
                                    <div class="col-md-3 col-sm-4 col-xs-6">
                                        <img src="{{url('public/uploads/assets/frontend/images/products/'.$value->main_img)}}" alt="img_{{$k}}" style="width: 100%" height="auto;">
                                    </div>
                                @endforeach
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="panel panel-info" style="border: 1px solid #bce8f1 !important;">
                        <header class="panel-heading">
                            <h2 class="panel-title">Description</h2>
                        </header>
                        <div class="panel-body">
                            @if(!empty($page_data->description))
                                <?=$page_data->description?>
                            @else
                                <h4>Not Available</h4>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
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

        label {
            font-size: 11px !important;
        }
    </style>
    <link rel="stylesheet" href="{{url('resources/assets/backend/vendor/dataTbl')}}/dataTables.bootstrap4.min.css">
@endsection