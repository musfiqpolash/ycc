@extends('layouts.front')

@section('title',$title)

@section('content')
<div class="container mt-100">
    <div class="row">
        <div class="col-md-12 text-center">
            <div class="bg-transparent mpc">
                <p>For any comments, questions or concerns please contact us at <br>
                    <b>{{$page_data->mail_address}}</b></p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('customJs')
    <script>
        $('.sspFooter').addClass('footer');
    </script>
@endsection
