@extends('layouts.master')
@section('title', '| Requests')
@section('content')
<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item active">
        <a href="">Requests</a>
    </li>
</ol>

<div class="row">
    <div class="col-12">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-secondary">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Url</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($requests as $k=>$item)
                        <tr>
                            <td>{{++$k}}</td>
                            <td><a href="{{$item->url}}" target="_blank">{{$item->url}}</a></td>
                            <td>{{$item->name}}</td>
                            <td>{{$item->email}}</td>
                            <td>{{$item->phone}}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5">showing {{$requests->firstItem() ." to ". $requests->lastItem() ." out of ". $requests->total()}}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="float-right">
            {{ $requests->links() }}
        </div>
    </div>
</div>

@endsection
