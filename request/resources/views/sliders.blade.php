@extends('layouts.master')
@section('title', '| Sliders')
@section('content')
<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item active">
        <a href="">Sliders</a>
    </li>
</ol>

<div class="row">
    <div class="col-12">
        <div class="form-group">
            <label for="image" class="control-label">Uplaod Image</label>
            <input onchange="initCroppie(this)" type="file" name="image" id="image" class="form-control-file">
        </div>

    </div>
    <div class="col-12">
        <div class="sliders row">
            @foreach ($sliders as $item)
            <div class="col-md-4 position-relative" id="it-{{$item->id}}">
                <img class="img-fluid" src="{{ url('public/uploads/'.$item->name) }}" alt="{{$item->name}}">
                <a href="" onclick="event.preventDefault(); deleteSlider('{{$item->id}}')" class="badge badge-danger p-ab rounded-0">
                    <i class="fa fa-trash"></i>
                </a>
            </div>
            @endforeach
        </div>

    </div>

    <div class="modal" role="dialog" id="modal" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Crop The Image</h5>
                </div>
                <div class="modal-body">
                    <div id="image_cropper"></div>
                </div>
                <div class="model-footer">
                    <button class="btn btn-primary" onclick="cropImage()" id="crop-btn">Crop Image</button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('css')
<link rel="stylesheet" href="{{ url('public/vendor/croppie/croppie.css') }}">
<style>
    .p-ab {
        position: absolute;
        top: 1px;
        left: 1rem;
        display: none;
    }

    .position-relative:hover .p-ab {
        display: block;
    }

</style>
@endsection

@section('js')
<script src="{{ url('public/vendor/croppie/croppie.js') }}"></script>
<script>
    $crop = $('#image_cropper').croppie({
        enableExif: true,
        viewport: {
            width: 300,
            height: 200,
            type: "square"
        },
        boundary: {
            width: 400,
            height: 400
        }
    });

    function initCroppie(e) {
        var reader = new FileReader();
        reader.onload = function (event) {
            $crop.croppie('bind', {
                url: event.target.result
            }).then(function () {
                console.log('mounted bind');
            });
        }
        reader.readAsDataURL(e.files[0]);
        $('#modal').modal('show');
    }

    function cropImage() {
        $crop.croppie('result', {
                type: 'canvas',
                size: 'viewport'
            })
            .then(function (response) {

                $.ajax({

                    url: "{{route('sliders.store')}}",

                    type: 'POST',

                    data: {
                        'image': response
                    },

                    success: function (data) {

                        $('#modal').modal('hide');
                        $('.sliders').append(
                            `<div class="col-md-4 position-relative" id="it-${data.slider.id}">
                                <img class="img-fluid" src="${response}" alt="${data.slider.name}">
                                <a href="" onclick="event.preventDefault(); deleteSlider('${data.slider.id}')" class="badge badge-danger p-ab rounded-0">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </div>`
                        );
                        Swal({
                            title: data.message,
                            type: data.status,
                            confirmButtonText: 'Close'
                        });


                    },
                    error: function (err) {
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
                                title: 'Something Went Wrong. Please Try Again.',
                                type: 'error',
                                confirmButtonText: 'Close'
                            });
                        }
                    }

                });

                $('#modal').modal('hide');
                document.getElementById("image").value = null;

            });
    }

    function deleteSlider(id) {
        Swal({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            reverseButtons: true,
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: "{{url('sliders/delete')}}/" + id,
                    type: 'post',
                    success: function (data) {
                        $('#it-' + id).remove();
                        Swal(
                            'Deleted!',
                            data.message,
                            data.status
                        );
                    },
                    error: function (err) {
                        Swal({
                            title: 'Something Went Wrong. Please Try Again.',
                            type: 'error',
                            confirmButtonText: 'Close'
                        });
                    }
                });
            }
        })
    }

</script>
@endsection
