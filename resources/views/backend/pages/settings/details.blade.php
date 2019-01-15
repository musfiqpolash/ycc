@extends('backend.layouts.app')

@section('dashboardRight')
    <li>
        <a href="#">
            <span>Settingd</span>
        </a>
    </li>
    <li>
        <a href="#">
            <span>{{$page_name}}</span>
        </a>
    </li>
@endsection

@section('content')
    <section class="panel">
        <header class="panel-heading">
            <h2 class="panel-title">{{$page_name}}</h2>
        </header>
        <div class="panel-body">
            @include('includes.flashMessage')
            <div class="row">
                <div class="col-md-12">
                    <form action="{{url('admin/settings/update_info')}}" method="post">
                        {{csrf_field()}}
                        <input type="hidden" name="id" value="{{$page_data->id}}">
                        <div class="row">
                            <div class="col-md-12">
                                <textarea name="description" class="form-control" rows="14">{{$page_data->description}}</textarea>
                            </div>
                        </div>
                        <div class="row text-center">
                            <div class="com-md-12" style="padding-top: 10px">
                                <button class="btn btn-primary">Update</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </section>
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
    </style>
    <link rel="stylesheet" href="{{url('resources/assets/backend/vendor/dataTbl')}}/dataTables.bootstrap4.min.css">
@endsection