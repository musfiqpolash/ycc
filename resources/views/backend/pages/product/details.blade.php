@extends('backend.layouts.app')

@section('dashboardRight')
    <li>
        <a href="#">
            <span>Product</span>
        </a>
    </li>
    <li>
        <a href="#">
            <span>Product List</span>
        </a>
    </li>
    <li>
        <a href="#">
            <span>Product Details</span>
        </a>
    </li>
@endsection

@section('content')
    <section class="panel">
        <header class="panel-heading">
            <h2 class="panel-title">{{$page_data[0]->name}}
                <p class="panel-subtitle">{{$page_data[0]->category}}</p></h2>
        </header>
        <div class="panel-body">
            @include('includes.flashMessage')
            <div class="row">
                <div class="col-md-9">
                    <div class="tabs">
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a href="#popular" data-toggle="tab"><i class="fa fa-file"></i> Description</a>
                            </li>
                            <li>
                                <a href="#recent" data-toggle="tab"><i class="fa fa-info-circle"></i> Additional
                                    Information</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div id="popular" class="tab-pane active">
                                <p>
                                    <?= $page_data[0]->description?>
                                </p>
                            </div>
                            <div id="recent" class="tab-pane">
                                @if($page_data[0]->carrier_details=='')
                                @else
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Carier</th>
                                            <th>Compatibility Rating</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php
                                        $tmpCarrier=json_decode($page_data[0]->carrier_details);
                                        @endphp
                                        @foreach($tmpCarrier as $tC)
                                            <tr>
                                                <td>{{$tC->name}}</td>
                                                <td>{{$tC->description}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-md-3" style="text-align: center;">
                    <img style="width: 100%"
                         src="{{url('public/uploads/assets/frontend/images/products/'.$page_data[0]->main_image)}}"
                         alt="">
                </div>
            </div>
        </div>
    </section>
    <div class="row">
        @php
        $p_clr_wise=$page_data->groupBy('color');
        @endphp
        @foreach($p_clr_wise as $p)
            <div class="col-md-4 col-xs-12">
                <div class="panel panel-featured">
                    <header class="panel-heading">
                        <h2 class="panel-title">{{$p[0]->color}}</h2>
                    </header>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <p class="label label-default" style="font-size: 13px">{{$p[0]->label}}</p>
                            </div>
                        </div>
                        <div class="row" style="text-align: center">
                            <img style="width: 60%"
                                 src="{{url('public/uploads/assets/frontend/images/products/'.$p[0]->main_image)}}"
                                 alt="">
                        </div>
                        <div class="row">
                            <table class="table text-center table-striped">
                                <tr>
                                    <th class="text-center">Size</th>
                                    <th class="text-center">Price</th>
                                    <th class="text-center">Quantity</th>
                                </tr>
                                @foreach($p as $size_p)
                                    <tr style="font-size: 14px">
                                        <td>{{$size_p->size}}</td>
                                        <td>
                                            @if($size_p->is_discount==1)
                                                <del> ${{$size_p->hasPrice[0]->price}}</del>
                                                <span class="label label-success"> $ {{$size_p->discount_price}}</span>
                                            @else
                                                <span class="label label-primary"> $ {{$size_p->hasPrice[0]->price}}</span>
                                        @endif
                                        <td>
                                            @if($size_p->quantity==0)
                                                <span class="label label-danger">Out Of Stock</span>
                                            @else
                                                <span class="label label-primary">{{$size_p->quantity}}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h4>Images</h4>
                                @foreach($p[0]->hasImage as $img_p)
                                    <img src="{{url('public/uploads/assets/frontend/images/products/'.$img_p->thum_img)}}"
                                         alt="">
                                @endforeach
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        @endforeach
    </div>
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