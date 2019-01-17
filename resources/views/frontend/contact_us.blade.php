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
            <form action="" class="modal-form">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="con_name" class="control-label">Name</label>
                        <input type="text" name="con_name" class="form-control" id="con_name">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="con_email" class="control-label">Email</label>
                        <input type="email" name="con_email" class="form-control" id="con_email">
                    </div>
                    <div class="form-group col-md-12">
                        <label for="con_subject" class="control-label">Subject</label>
                        <input type="text" name="con_subject" class="form-control" id="con_subject">
                    </div>
                    <div class="form-group col-md-12">
                        <label for="con_message" class="control-label">Message</label>
                        <textarea name="con_message" cols="8" class="form-control" id="con_message"></textarea>
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
