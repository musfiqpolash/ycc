@extends('layouts.master')
@section('title', '| Information')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">
            <a href="">Information</a>
        </li>
    </ol>
    <form id="info-form" action="{{route('information.store')}}" method="post">
        @csrf
            <div class="row">
                <div class="col-md-6 form-group {{$errors->has('email')?'has-danger':''}}">
                    <label for="email" class="control-label">Email</label>
                    <input required type="email" name="email" id="email" class="form-control" value="{{old('email')?old('email'):$info->email}}">
                    @if($errors->has('email')) <em>{{$errors->first('email')}}</em> @endif
                </div>

                <div class="col-md-6 form-group {{$errors->has('phone')?'has-danger':''}}">
                    <label for="phone" class="control-label">Phone</label>
                    <input required type="text" name="phone" value="{{old('phone')?old('phone'):$info->phone}}" class="form-control" id="phone">
                    @if($errors->has('phone')) <em>{{$errors->first('phone')}}</em> @endif
                </div>

                <div class="col-md-6 form-group {{$errors->has('fb')?'has-danger':''}}">
                    <label for="fb" class="control-label">Fb Link</label>
                    <input type="url" name="fb" value="{{old('fb')?old('fb'):$info->fb}}" class="form-control" id="fb">
                    @if($errors->has('fb')) <em>{{$errors->first('fb')}}</em> @endif
                </div>

                <div class="col-md-6 form-group {{$errors->has('instagram')?'has-danger':''}}">
                    <label for="instagram" class="control-label">Instagram Link</label>
                    <input type="url" name="instagram" value="{{old('instagram')?old('instagram'):$info->instagram}}" class="form-control" id="instagram">
                    @if($errors->has('instagram')) <em>{{$errors->first('instagram')}}</em> @endif
                </div>

                <div class="col-md-6 form-group {{$errors->has('twitter')?'has-danger':''}}">
                    <label for="twitter" class="control-label">Twitter Link</label>
                    <input type="text" name="twitter" value="{{old('twitter')?old('twitter'):$info->twitter}}" class="form-control" id="twitter">
                    @if($errors->has('twitter')) <em>{{$errors->first('twitter')}}</em> @endif
                </div>
                <div class="col-12 text-right">
                    <button type="submit" class="btn btn-info">Apply</button>
                </div>
            </div>
    </form>
@endsection

@section('css')
    <style>
        .has-danger .form-control{
            border-color: #dc3545;
        }
        .has-danger label, .has-danger em{
            color: #dc3545;
        }
    </style>
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>
    <script>
        let validate = $('#info-form').validate({
            highlight: function(element) {
                $(element).parent().addClass('has-danger');
            },
            unhighlight: function(element) {
                $(element).parent().removeClass('has-danger');
            },
            errorElement: "em",
            errorPlacement: function (e, a) {
                $(a).parents(".form-group").append(e)
            },
            rules:{
                email:{
                    required:true,
                    email:true,
                },
                phone:{
                    required:true,
                    digits:true,
                },
                fb:{
                    url:true,
                },
                twitter:{
                    url:true,
                },
                instagram:{
                    url:true,
                }
            }
        });
    </script>
@endsection
