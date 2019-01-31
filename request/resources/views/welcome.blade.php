<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <!-- font awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <link rel="stylesheet" href="{{url('public')}}/css/sweetalert2.min.css">
    <link rel="stylesheet" href="{{url('public')}}/css/index.css">
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />

    <title>Request</title>

</head>

<body>
    <div id="bg"></div>
    <nav class="navbar navbar-light bg-light">
        <div>
            <span class="nav-text" style="font-size: .7rem;"><i class="fa fa-phone"></i>{{$info->phone?$info->phone:'01702365471'}}</span>
            <span class="nav-text" style="font-size: .7rem;"><i class="fa fa-envelope"></i>{{$info->email?$info->email:'info@geeksntechnology.com'}}</span>
        </div>
        <div class="ml-auto float-right">
            <a href="{{$info->fb?$info->fb:'#'}}" class="nav-item mr-1 text-dark"><i class="fab fa-facebook"></i></a>
            <a href="{{$info->instagram?$info->instagram:'#'}}" class="nav-item mr-1 text-dark"><i class="fab fa-instagram"></i></a>
            <a href="{{$info->twitter?$info->twitter:'#'}}" class="nav-item text-dark"><i class="fab fa-twitter"></i></a>
        </div>
    </nav>
    <nav style="padding:0 16px;" class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#"><img src="{{url('public')}}/img/logo.png" height="80" alt="logo"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">FAQ</a>
                </li>
            </ul>
        </div>
    </nav>


        <div class="container">
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
            @if ($sliders->count('id')>0)

            <p class="mt-4">We are taking orders from</p>
            <div id="slick">
                @foreach ($sliders as $item)

                <img class="img-fluid mx-auto d-block" src="{{url('public/uploads/'.$item->name)}}" alt="">

                @endforeach

            </div>
            @endif

            @if ($additionals->count('id')>0)

            <div class="row my-4">
                @foreach ($additionals as $item)

                <div class="col-12 mb-2">
                    <div class="card">
                        <div class="card-header bg-white">{{$item->title}}</div>
                        <div class="card-body text-justify">
                            {{$item->description}}
                        </div>
                    </div>
                </div>
                @endforeach


            </div>
            @endif

        </div>
        <footer>
            <nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
                <strong style="font-size: .7rem;" class="nav-text ml-auto float-right">all right reserved by <a class="text-white" href="http://www.geeksntechnology.com">Geeksntechnology Ltd</a></strong>
            </nav>
        </footer>



    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>
    <script src="{{url('public')}}/js/sweetalert2.all.min.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        const toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 10000
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

        $('#slick').slick({
            centerMode: true,
            centerPadding: '60px',
            slidesToShow: 4,
            autoplay: true,
            responsive: [{
                    breakpoint: 768,
                    settings: {
                        arrows: false,
                        centerMode: true,
                        centerPadding: '40px',
                        slidesToShow: 3
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        arrows: false,
                        centerMode: true,
                        centerPadding: '40px',
                        slidesToShow: 1
                    }
                }
            ]
        });

    </script>
</body>

</html>
