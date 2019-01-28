@extends('layouts.front')

@section('title',$title)

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
                <iframe src="https://maps.google.it/maps?q=House: 452, Road:31, New Mohakhali DOHS Dhaka 1206 &output=embed"
                width="100%" height="350" frameborder="0" style="border:0"></iframe>
        </div>
        <div class="col-md-4">
            <h3>Contact Info</h3>
            <p><i class="fa fa-map-marker"></i> House: 452, Road:31, New Mohakhali DOHS</p>
            <p><i class="fa fa-phone"></i> 01713002255</p>
            <p><i class="fa fa-envelope"></i> <a href="mailto:info@geeksntechnology.com">info@geeksntechnology.com</a></p>
        </div>
        <div class="col-md-8">
            <h3>Contact Form</h3>
            @if (session('msg'))
                <div class="alert alert-success">
                    {{session('msg')}}
                </div>
            @endif
            <form action="{{url('customer_message')}}" method="POST" class="modal-form">
                {{ csrf_field() }}
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="con_name" class="control-label">Name</label>
                        <input type="text" name="name" value="{{old('name')}}" class="form-control" id="con_name">
                        @if ($errors->has('name'))
                            <i style="color:red;">{{$errors->first('name')}}</i>
                        @endif
                    </div>
                    <div class="form-group col-md-6">
                        <label for="con_email" class="control-label">Email</label>
                        <input type="email" name="email" value="{{old('email')}}" class="form-control" id="con_email">
                        @if ($errors->has('email'))
                            <i style="color:red;">{{$errors->first('email')}}</i>
                        @endif
                    </div>
                    <div class="form-group col-md-12">
                        <label for="con_subject" class="control-label">Subject</label>
                        <input type="text" name="subject" value="{{old('subject')}}" class="form-control" id="con_subject">
                        @if ($errors->has('subject'))
                            <i style="color:red;">{{$errors->first('subject')}}</i>
                        @endif
                    </div>
                    <div class="form-group col-md-12">
                        <label for="con_message" class="control-label">Message</label>
                        <textarea name="message" cols="8" class="form-control" id="con_message">{{old('message')}}</textarea>
                        @if ($errors->has('message'))
                            <i style="color:red;">{{$errors->first('message')}}</i>
                        @endif
                    </div>
                    <div class="form-group col-md-12">

                        <button type="submit" class="btn btn-default">Send Message</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('customJs')
   
@endsection
