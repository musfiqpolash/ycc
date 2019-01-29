@extends('backend.layouts.app')

@section('content')
<div class="panel panel-default">
    <div class="panel-heading">Customer Messages</div>
    <div class="panel-body">
        @foreach ($messages as $item)
        <div class="float-left m-w panel panel-default">
            <div class="panel-heading">
                <p class="m-0">{{$item->name}} <sub>(<i>{{$item->email}}</i>)</sub></p>
                <b>{{$item->subject}}</b>
                <a class="reply-link" title="reply" href="mailto:{{$item->email}}"><i class="fa fa-reply"></i></a>
            </div>
            <div class="panel-body">
                {{$item->message}}
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

@section('customCss')
    <style>
        .panel-heading{
            position: relative;
        }
        .reply-link{
            position: absolute;
            top: 1rem;
            right:1rem;
        }
        .m-0{
            margin:0;
        }
        .m-w{
            max-width:100%;
            min-width: 250px;
        }
        @media only screen and (min-width: 500px){
            .m-w{
                max-width:48%;
            }
            .float-left{
                float: left;
            }

        }
        @media only screen and (min-width: 700px){
            .m-w{
                max-width:33%;
            }
            .float-left{
                float: left;
            }

        }
    </style>
@endsection