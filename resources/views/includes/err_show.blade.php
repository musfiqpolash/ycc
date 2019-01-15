@extends('backend.layouts.app')

@section('dashboardRight')
    {{--<li>--}}
        {{--<a href="#">--}}
            {{--<span>Order</span>--}}
        {{--</a>--}}
    {{--</li>--}}
    {{--<li>--}}
        {{--<a href="#">--}}
            {{--<span>Order List</span>--}}
        {{--</a>--}}
    {{--</li>--}}
@endsection

@section('content')
    <section>
        <div class="card">
            <div class="card-body">
                <div class="row col-md-10 col-md-offset-1 text-center " >
                    <h3 class="text-dark bg-info" style="padding: 8px">{{$msg}}</h3>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('customJs')
@endsection
@section('customCss')
@endsection


@section('specifiedCss')
@endsection
