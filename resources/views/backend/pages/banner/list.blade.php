@extends('backend.layouts.app')

@section('content')
<form action="{{ url('admin/banner/store') }}" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="panel panel-default">
        <div class="panel-heading">Add Banner</div>
        <div class="panel-body">
            <div class="form-group {{$errors->has('image')?'has-error':''}}">
                <label for="image" class="control-label">Image <sub>*Image will be resized to 1024x350 px</sub></label>
                <div class="input-group">
                    <input type="file" name="image" id="image" class="form-control">
                    <span class="input-group-btn"><button class="btn btn-info" type="submit">Add</button></span>
                </div>
                @if ($errors->has('image'))
                    <span id="image-error" class="help-block">{{$errors->first('image')}}</span>
                @endif
            </div>
        </div>
    </div>
</form>
<div class="panel panel-default">
    <div class="panel-heading">Banners</div>
    <div class="panel-body">
        @foreach ($banners as $item)
            <div class="bann">
                <a class="bann-link" href="{{ url('admin/banner/'.$item->id.'/delete') }}"><span class="label label-danger"><i class="fa fa-trash"></i></span></a>
                <img class="img-responsive" src="{{ url('public/uploads/banner/'.$item->name) }}" alt="">
            </div>
        @endforeach
    </div>
</div>
@endsection

@section('customCss')
    <style>
        .bann{
            position: relative;
            margin-bottom: 1rem;
        }
        .bann-link{
            position: absolute;
            right:1rem;
            top:1rem;
            opacity: 0;
        }
        .bann:hover .bann-link{
            opacity: 1;
            transition: 300ms;
        }
    </style>
@endsection