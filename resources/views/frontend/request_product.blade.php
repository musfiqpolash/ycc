@extends('layouts.front')

@section('title','Product Request')

@section('content')
    <div class="container-fluid">
            <form onsubmit="event.preventDefault(); ajaxSubmit();" id="product_request_form" method="POST" action="server.php">
                    <div class="form-group mt-4">
                        <label for="product_url">Product URL <span class="red">*</span></label>
                        <input type="url" placeholder="Enter Your Product URL Here" required name="url" class="form-control" id="product_url">
                    </div>
                    <button type="button" id="req_btn" class="btn btn-primary">Request Product</button>
                    <!-- <input type="submit" class="btn btn-primary" value="Submit"> -->
                    <!-- modal -->
                    <div id="modal" class="modal" tabindex="-1" role="dialog">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Information</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="name">Name <span class="red">*</span></label>
                                        <input type="text" class="form-control modal-input" id="name" name="name">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email <span class="red">*</span></label>
                                        <input type="email" class="form-control modal-input" id="email" name="email">
                                    </div>
                                    <div class="form-group">
                                        <label for="phone">Phone <span class="red">*</span></label>
                                        <input type="text" class="form-control modal-input" id="phone" name="phone">
                                    </div>
                                    <div class="form-group">
                                        <label for="address">Address</label>
                                        <textarea class="form-control modal-input" id="address" name="address"></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <input type="submit" class="btn btn-primary" value="Submit">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
    </div>
    @if ($brands->count('id')>0)
        
    <div class="container-fluid mb-50">
            <div class="p-title">
                    <h3>We are taking orders from</h3>
                    <div class="p-title-line"></div>
                </div>
            {{-- brands --}}
            <div class="brand owl-carousel owl-theme">
                @foreach ($brands as $item)
                    
                <div class="brand-item">
                    <img src="{{ url('public/uploads/banner/'.$item->name) }}" alt="{{$item->name}}">
                </div>
                @endforeach
            </div>
        {{-- brands end --}}
        </div>
    @endif
@endsection

@section('customCss')
<link rel="stylesheet" href="{{url('public')}}/css/sweetalert2.min.css">
<style>
        .p-title{
            display: flex;
        }
        .p-title h3{
            margin: 15px 0;
        }
        .p-title-line{
            position: relative;
            flex-grow: 100;
        }
        .p-title-line::after{
            position: absolute;
            content:"";
            top: 50%;
            left: 15px;
            right: 0;
            height: 1px;
            background: #ccc;
        }

        .brand-item{
            border: 1px solid #ccc;
        }
        .brand-item img{
            padding: 11px;
        }
    </style>
@endsection

@section('customJs')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>
<script src="{{url('public')}}/js/sweetalert2.all.min.js"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        let validate = $('#product_request_form').validate({
            errorClass: "is-invalid",
            validClass: "is-valid",
            errorElement: "em",
            errorPlacement: function (e, a) {
                $(a).parents(".form-group").append(e)
            },
        });

        $('#req_btn').on('click', () => {
            if ($('#product_request_form').valid()) {
                addRules();
                $('#modal').modal();
            }
        });

        function addRules() {
            $('#name').rules('add', {
                required: true,
                minlength: 3,
            })
            $('#email').rules('add', {
                required: true,
                email: true,
            })
            $('#phone').rules('add', {
                required: true,
                digits: true,
            })
            // $('#address').rules('add', {
            //     required: true,
            // })
        }

        $('#modal').on('hide.bs.modal', function (e) {
            $('.modal-input').removeClass('is-invalid is-valid');

        })

        function ajaxSubmit() {
            let form = $('#product_request_form');
            if (form.valid()) {
                $.ajax({
                    url: "{{route('request.store')}}",
                    data: form.serialize(),
                    type: 'post',
                    success: function (data) {
                        // console.log(data);

                        $('#modal').modal('hide');
                        let swal_type = 'error';
                        if (data.status == 1) {
                            swal_type = 'success';
                            document.getElementById("product_request_form").reset();
                            $('.form-control').removeClass('is-invalid is-valid');
                        }

                        // toast({
                        //     type: swal_type,
                        //     title: data.message
                        // })

                        Swal({
                            title: data.message,
                            type: swal_type,
                            confirmButtonText: 'Close'
                        })
                    },
                    error: function (err) {

                        $msg = 'Something Went Wrong. Please Try Again.'
                        if (err.status === 422) {
                            // console.log(err.responseJSON);
                            $li = '';
                            $.each(err.responseJSON.errors, function (k, v) {
                                $li += `<li>${v[0]}</li>`;
                            })
                            $html = `<ul>${$li}</ul>`;
                            Swal({
                                html: $html,
                                type: 'error',
                                confirmButtonText: 'Close'
                            });

                        } else {
                            Swal({
                                title: $msg,
                                type: 'error',
                                confirmButtonText: 'Close'
                            });
                        }
                    }
                });
            }
        }

        $('.brand').owlCarousel({
            margin:10,
            loop:true,
            autoplay:true,
            autoplayTimeout:5000,
            // autoplayHoverPause:false,
            animateOut: 'fadeOut',
            responsiveClass:true,
            responsive : {
                // breakpoint from 0 up
                0 : {
                    items:2,
                },
                // breakpoint from 480 up
                480 : {
                    items:4,
                },
                // breakpoint from 768 up
                768 : {
                    items:6,
                }
            }
        })
    </script>
@endsection
