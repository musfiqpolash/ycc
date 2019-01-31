@extends('backend.layouts.app')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">Product Requests</div>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Product URL</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Requested At</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($p_req->count('id')==0)
                        <tr>
                            <td class="text-center" colspan="5">No Request Available</td>
                        </tr>
                    @endif
                    @foreach ($p_req as $item)
                        <tr>
                            <td><a href="{{$item->url}}" target="_blank">{{$item->url}}</a></td>
                            <td>{{$item->name}}</td>
                            <td>{{$item->email}}</td>
                            <td>{{$item->phone}}</td>
                            <td>{{$item->created_at}}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                            <td colspan="5">showing {{$p_req->firstItem() ." to ". $p_req->lastItem() ." out of ". $p_req->total()}}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="text-right">
            {{ $p_req->links() }}
        </div>
    </div>
@endsection

@section('customJs')
    
@endsection