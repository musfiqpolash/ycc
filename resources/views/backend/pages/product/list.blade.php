@extends('backend.layouts.app')

@section('dashboardRight')
    <li>
        <a href="#">
            <span>@if($access===0) Accessories @else Product @endif</span>
        </a>
    </li>
    <li>
        <a href="#">
            <span>@if($access===0) Accessories @else Product @endif List</span>
        </a>
    </li>
@endsection

@section('content')
    <section class="panel">
        <header class="panel-heading">
            <h2 class="panel-title">@if($access===0) Accessories @else Product @endif List</h2>
        </header>
        <div class="panel-body table-responsive">
            @include('includes.flashMessage')
            <table class="table table-bordered table-striped mb-none" id="example">
                <thead>
                <tr>
                    <th style="width: 2%">#</th>
                    <th>IMAGE</th>
                    <th style="width: 18%">NAME</th>
                    <th>CATEGORY</th>
					@if($access===1)
                    <th>SIZE</th>
					@endif
                    <th>COLOR</th>
                    <th>QTY</th>
                    <th style="width: 9%!important;">ACTION</th>
                </tr>
                </thead>
                <tbody>
                @php $i=1; @endphp
                @foreach($page_data as $k=>$val)
                    <tr>
                        <td style="width: 2%; text-align: center">{{$i++}}</td>
                        <td style="text-align: center">
                            <img style="width:30px; height: auto"
                                 src="{{url('public/uploads/assets/frontend/images/products/'.$val[0]->main_image)}}"
                                 alt="{{$val[0]->main_image}}">
                        </td>
                        <td class="text-left" style="width: 18%">{{$val[0]->name}}</td>
                        <td>{{$val[0]->category}}</td>
						@if($access===1)
                        <td>
                            <div style="word-wrap: break-word;">
                                @php $size=$val->groupBy('size'); @endphp
                                @foreach($size as $k_size=>$s)
                                    <span style="display: inline-block" class="label label-primary">{{$k_size}}</span>&nbsp;
                                @endforeach
                            </div>
                        </td>
						@endif
                        <td>
                            <div style="word-wrap: break-word;">
                                @php $color=$val->groupBy('color'); @endphp
                                @foreach($color as  $k_color=>$clr)
                                    <span style="display: inline-block" class="label label-primary">{{$k_color}}</span>
                                    &nbsp;
                                @endforeach
                            </div>
                        </td>
                        {{--<td>--}}
                        {{--@if($val[0]->is_discount==1)--}}
                        {{--<span><del>${{$val[0]->price}}</del></span>--}}
                        {{--<span class="label label-primary">$ {{$val[0]->discount_price}}</span>--}}
                        {{--@else--}}
                        {{--${{$val[0]->price}}--}}
                        {{--@endif--}}
                        {{--</td>--}}
                        <td>
                            @if($val->sum('quantity')==0)
                                <span class="label label-danger">Out Of Stock</span>
                            @else
                                <span class="label label-primary">{{$val->sum('quantity')}}</span>
                            @endif
                        </td>
                        <td style="width: 9%!important; text-align: center">
                            <a href="{{url('admin/product/details/'.$val[0]->group_name).'/'.$val[0]->is_accessories}}"
                               class="label label-info" title="PRODUCT DETAILS"> <i class="fa fa-eye"></i></a>
                            <a style="cursor: pointer" onclick="getApproval({{$val[0]->id}})"
                               class="label label-danger" title="PRODUCT DELETE"> <i class="fa fa-trash"></i></a>
                            <form id="prdctDltFrm{{$val[0]->id}}" action="{{url('admin/product/delete')}}"
                                  method="post">
                                {{csrf_field()}}
                                <input type="hidden" name="productId" value="{{$val[0]->group_name}}">
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
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
    <link rel="stylesheet" href="{{url('resources/assets/backend/vendor/dataTbl')}}/dataTables.bootstrap4.min.css">
    <style>
        #example th {
            font-size: 12px;
            font-weight: 700;
            text-align: center !important;
        }

        #example td {
            font-size: 12px;
        }

        .container-fluid {
            padding-left: 0px !important;
            padding-right: 0px !important;
        }
    </style>
@endsection