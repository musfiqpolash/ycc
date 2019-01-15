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
@endsection

@section('content')
    <section class="panel">
        <header class="panel-heading">
            <h2 class="panel-title">Order List</h2>
        </header>
        <div class="panel-body table-responsive">
            @include('includes.flashMessage')
            <table class="table table-bordered table-striped mb-none" id="example">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Order Date</th>
                    <th>Order No</th>
                    <th>Transaction Id</th>
                    <th>Shipping Point</th>
                    <th>Order Amount</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>

                @foreach($page_data as $k=>$val)
                    @php
                    $tmp=json_decode($val->shipping_point);
                    @endphp
                    <tr class="text-center" style="font-size: 14px">
                        <td>{{$k+1}}</td>
                        <td class="text-left">{{$val->d_date}}</td>
                        <td class="text-left">{{$val->slug}}</td>
                        <td class="text-left">{{$val->transaction_id}}</td>
                        <td class="text-left">
                            <div class="">
                                @foreach($tmp as $sk=>$sval)
                                    <div class="col-md-6 text-weight-bold">{{str_replace('_',' ',ucfirst($sk))}}</div>
                                    <div class="col-md-6">{{$sval}}</div>
                                @endforeach
                            </div>
                        </td>
                        <td class="text-right">${{$val->order_amount}}</td>

                        <td>
                            <a href="{{url('admin/order/details/'.$val->id)}}" class="label label-info">Details</a>
                            <a style="cursor: pointer" onclick="getApproval({{$val->id}})"
                               class="label label-danger">Delete</a>
                            <form id="orderDltFrm{{$val->id}}" action="{{url('admin/order/delete')}}"
                                  method="post">
                                {{csrf_field()}}
                                <input type="hidden" name="orderId" value="{{$val->id}}">
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
            var c = confirm('Do You Want To Delete This Order?');
            if (c) {
                $('#orderDltFrm' + id).submit();
            }
        }
        $('#example').dataTable({
            "ordering": false
        });
    </script>
@endsection
@section('customCss')
    <link rel="stylesheet" href="{{url('resources/assets/backend/vendor/dataTbl')}}/dataTables.bootstrap4.min.css">
@endsection