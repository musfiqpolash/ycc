@extends('layouts.front')

@section('title','Profile')


@section('content')
    <div class="container">
        {{-- <h4>Welcome {{auth('client')->user()->first_name.' '.auth('client')->user()->last_name}}</h4> --}}
        <div class="row">
            @include('includes.profile_sidebar')

            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading bg-nav text-white h4 m-0">Profile</div>
                    <div class="panel-body">
                        <form id="client_update_form" action="{{ url('client/update') }}" method="POST" class="modal-form">
                            {{ csrf_field() }}
                            <div class="form-group @if($errors->has('first_name')) has-error @endif">
                                <label for="reg_first_name" class="control-label">First Name</label>
                                <input type="text" name="first_name" value="{{auth('client')->user()->first_name}}" id="first_name" class="form-control">
                                @if($errors->has('first_name')) 
                                <span id="first_name_err" class="help-block">{{$errors->first('first_name')}}</span>
                                @endif
                            </div>
                            <div class="form-group @if($errors->has('last_name')) has-error @endif">
                                <label for="last_name" class="control-label">Last Name</label>
                                <input type="text" name="last_name" value="{{auth('client')->user()->last_name}}" id="last_name" class="form-control">
                                @if($errors->has('last_name')) 
                                <span id="last_name_err" class="help-block">{{$errors->first('last_name')}}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label  class="control-label">Email</label>
                                <p class="form-control-static">{{auth('client')->user()->email}}</p>
                            </div>
                            <div class="form-group @if($errors->has('phone')) has-error @endif">
                                <label for="phone" class="control-label">Phone</label>
                                <input type="tel" name="phone" value="{{auth('client')->user()->phone}}" id="phone" class="form-control">
                                @if($errors->has('phone')) 
                                <span id="phone_err" class="help-block">{{$errors->first('phone')}}</span>
                                @endif
                            </div>
                        </form>
                    </div>
                    <div class="panel-footer">
                        <button type="submit" class="btn btn-success" form="client_update_form">Update</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection