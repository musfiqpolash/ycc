@extends('backend.layouts.app')

@section('customCss')
    <style>
        .has-error1 {
            font-size: .8em;
            color: #a94442;
        }

        .has-error1 .form-control {
            border-color: #a94442;
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
        }

        .has-error {
            font-size: .8em;
            color: #a94442;
        }

        .plus, .minus {
            padding: 6px 8px;
        }
    </style>
@endsection

@section('customJs')
    {{--<script type="text/javascript" src="{{URL::to('js/jquery.validate.js')}}"></script>--}}
    <script src="{{URL::to('public/js/productValidator.js')}}"></script>
    <script src="{{url('public/ckeditor/ckeditor.js')}}"></script>

    <script>
        $(document).ajaxStart(function(){
            $("#wait").css("display", "block");
        });
        $(document).ajaxComplete(function(){
            $("#wait").css("display", "none");
        });
        var _URL = window.URL || window.webkitURL;
        // <button onclick="addImageSection(this.id)" id="' + zz + 'q" type="button" class="btn btn-success">add more additional images</button>
        // function getDiscountDiv() {
        //     alert('dgf');
        // }

        $(document).ready(function () {
            function getDiscountDiv() {
                alert('dgf');
            }
        });

        $(document).on('change', '.a', function () {
            var v = $(this).attr('data-image-type');
            var va = $(this).attr('id');
            console.log(v);
            var file, img;
            if ((file = this.files[0])) {
                img = new Image();
                img.onload = function () {
                    console.log("width : " + this.width + " and height : " + this.height);
                    if (v === 'primary' && this.width === 263 && this.height === 390) {
                        $('#desc').val('pass');
                        $('#' + va).parent().removeClass('has-error1');
                        $('.sp' + v).hide();
                        console.log('pass');
                    }
                    else if (v === 'small' && this.width === 50 && this.height === 50) {
                        $('#desc').val('pass');
                        $('#' + va).parent().removeClass('has-error1');
                        $('.sp' + v).hide();
                        console.log('pass');
                    }
                    else if (v === 'medium' && this.width === 480 && this.height === 600) {
                        $('#desc').val('pass');
                        $('#' + va).parent().removeClass('has-error1');
                        $('.sp' + v).hide();
                        console.log('pass');
                    }
                    else if (v === 'large' && this.width === 1024 && this.height === 1024) {
                        $('#desc').val('pass');
                        $('#' + va).parent().removeClass('has-error1');
                        $('.sp' + v).hide();
                        console.log('pass');
                    }
                    else {
                        $('#desc').val('fail');
                        $('#' + va).parent().addClass('has-error1');
                        $('#' + va).parent().append('<span class="sp' + v + '">*Check images width and height</span>');
                        console.log('fail');
                    }

                };

                img.src = _URL.createObjectURL(file);

                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#image')
                            .attr('src', e.target.result);
                };
                reader.readAsDataURL(this.files[0]);
            }
        });
        var count = 0;
        // $('.plus').on('click', function () {
        //     count += 1;
        //     $('#caree').append('<tr class="r' + count + '">' +
        //         '<td><div><input type="text" name="carrierName[]" class="form-control" required/></div></td>' +
        //         '<td><div><input type="text" name="carrierDescription[]" class="form-control" required/></div></td>' +
        //         '<td ><a  onclick="rmv(this.id)" id="' + count + '" class="minus label label-danger">' + "&nbsp;-&nbsp;" + '</a></td>' +
        //         '</tr>');
        // });

        function addCarrier(e) {
            count += 1;
            $('#' + e + 'ee').append('<tr class="r' + count + '">' +
                    '<td><div><input type="text" name="carrierName[]" class="form-control" required/></div></td>' +
                    '<td><div><input type="text" name="carrierDescription[]" class="form-control" required/></div></td>' +
                    '<td ><a  onclick="rmv(this.id)" id="' + count + '" class="minus label label-danger">' + "&nbsp;-&nbsp;" + '</a></td>' +
                    '</tr>');
        }

        function rmv(id) {
            $('.r' + id).remove();
        }

        function rmve(id) {
            $('.' + id).remove();
        }

        $('#product_name').on('blur',function () {
            $.get( "{{url('admin/product/get_info')}}", {name: $(this).val()} )
                .done(function (data) {
                    //console.log(data);
                    if (data === 'absent') {
                        console.log('absent');
                        $('#chk_name').val('absent');
                    }
                    else {
                        console.log('present');
                        $('#chk_name').val('present');
                    }
                });
        });

        $('#productForm').on('submit', function (params) {
            var req = 0;
            $('#productForm *').filter(':input').each(function () {
                if ($(this).val() === "" && $(this).attr('required')) {
                    $(this).parent().addClass('has-error1');
                    req++;
                }
            });
            if (req === 0) {
                if ($('#productForm').valid() && $('#desc').val() === "pass" && $('#chk_name').val()==='absent') {
                    return true;
                    // if($('#chk_name').val()==='absent'){
                    //     return true;
                    // }else {
                    //
                    //     return false;
                    // }
                }
                else {
                    console.log('2');
                    if($('#chk_name').val()==='present'){
                        alert('this product already exists, please add it from edit product section');
                    }
                    return false;
                }
            } else {
                console.log('3');
                //alert("Error: you need fill all required input, inputs empty" + req + " .");
                return false;
            }
        });
        CKEDITOR.replace('product_description');

        $('#product_labelll').on('change', function () {
            console.log($(this).val());
            if ($(this).val() === 'ON SALE') {
                $('#addiInfo').append(
                        '<div class="form-group col-md-6">' +
                        '<label for="product_discount_price" class="">Product Discount Price</label>' +
                        '<div><input type="tel" class="form-control" id="product_discount_price" name="product_discount_price" required></div>' +
                        '</div>'
                );
            }
            else $('#addiInfo').empty();
        });

        function addImageSection(e) {
            addimg += 1;
            $('#' + e + 'g').append(
                    '<div class="row ' + addimg + '"><div class="col-md-11"><div class="row">' +
                    '                        <div class="form-group col-md-4">' +
                    '                            <label for="product_details_image1' + addimg + '" >Product Image (Details Page) *50x50 px</label>' +
                    '                            <div><input type="file" class="form-control a" id="product_details_image1' + addimg + '" name="product_details_image1[]" value="" data-image-type="small" required></div></div>' +
                    '                        <div class="form-group col-md-4">' +
                    '                            <label for="product_details_image2' + addimg + '" class="">Product Image (Details Page) *480x600 px</label>' +
                    '                            <div><input type="file" class="form-control a" id="product_details_image2' + addimg + '" name="product_details_image2[]" value="" data-image-type="medium" required></div>' +
                    '                        </div>' +
                    '                        <div class="form-group col-md-4">' +
                    '                            <label for="product_details_image3' + addimg + '" class="">Product Image (Details Page) *1024x1024 px</label>' +
                    '                            <div><input type="file" class="form-control a" id="product_details_image3' + addimg + '" name="product_details_image3[]" value="" data-image-type="large" required></div>' +
                    '                        </div></div></div><div class="col-md-1"> <a  onclick="rmve(this.id)" id="' + addimg + '" class="minus label label-danger">' + "&nbsp;-&nbsp;" + '</a>' +
                    '                    </div></div>'
            );
        }

        var addimg = 0;
        // $('#addiii').on('click', function () {
        //     addimg += 1;
        //     $('#appendImg').append(
        //         '<div class="row ' + addimg + '"><div class="col-md-11"><div class="row">' +
        //         '                        <div class="form-group col-md-4">' +
        //         '                            <label for="product_details_image1' + addimg + '" >Product Image (Details Page) *50x50 px</label>' +
        //         '                            <div><input type="file" class="form-control a" id="product_details_image1' + addimg + '" name="product_details_image1[]" value="" data-image-type="small" required></div></div>' +
        //         '                        <div class="form-group col-md-4">' +
        //         '                            <label for="product_details_image2' + addimg + '" class="">Product Image (Details Page) *480x600 px</label>' +
        //         '                            <div><input type="file" class="form-control a" id="product_details_image2' + addimg + '" name="product_details_image2[]" value="" data-image-type="medium" required></div>' +
        //         '                        </div>' +
        //         '                        <div class="form-group col-md-4">' +
        //         '                            <label for="product_details_image3' + addimg + '" class="">Product Image (Details Page) *820x1024 px</label>' +
        //         '                            <div><input type="file" class="form-control a" id="product_details_image3' + addimg + '" name="product_details_image3[]" value="" data-image-type="large" required></div>' +
        //         '                        </div></div></div><div class="col-md-1"> <a  onclick="rmve(this.id)" id="' + addimg + '" class="minus label label-danger">' + "&nbsp;-&nbsp;" + '</a>' +
        //         '                    </div></div>'
        //     );
        // });
        function rmvZZ(e) {
            $('.zz' + e).remove();
        }

        var zz = 0;
        $('#addColor').on('click', function () {
            zz += 1;
            $('.addsection').append('<div class="panel zz' + zz + '"><fieldset style="margin: 30px 0;">\n' +
                    '                    <legend>Additional information</legend><a  onclick="rmvZZ(this.id)" id="' + zz + '" class="minus label label-danger">' + "&nbsp;-&nbsp;" + '</a>' +
                    '                    <div class="row">\n' +
                    '                        <div class="form-group col-md-6">\n' +
                    '                            <label for="product_color'+zz+'" class="">Product Color *[do not provide more than one color]</label>\n' +
                    '                            <div><input required type="text" class="form-control" id="product_color'+zz+'" onblur="chk(this.id)" name="product_color[]"\n' +
                    '                                        value=""></div>\n' +
                    '                        </div>\n' +
                    '\n' +
                    '                        <div class="form-group col-md-6">\n' +
                    '                            <label for="product_size'+zz+'" class="">Product Size [storage capacity]</label>\n' +
                    '                            <div><input required type="text" class="form-control" id="product_size'+zz+'" onblur="chk(this.id)" name="product_size[]"\n' +
                    '                                        value=""></div>\n' +
                    '                        </div>\n' +
                    '                    </div>\n' +
                    '\n' +
                    '                    <div class="row">\n' +
                    '                        <div class="form-group col-md-6">\n' +
                    '                            <label for="product_label'+zz+'" class="">Product Label</label>\n' +
                    '                            <div>\n' +
                    '                                <select id="product_label'+zz+'" name="product_label[]" class="form-control">\n' +
                    '                                    <option value="0">select label</option>\n' +
                    '                                    <option value="ON SALE">ON SALE</option>\n' +
                    '                                    <option value="LIMITED EDITION">LIMITED EDITION</option>\n' +
                    '                                    <option value="NEW">NEW</option>\n' +
                    '                                </select>\n' +
                    '                            </div>\n' +
                    '                        </div>\n' +
                    '                        <div class="form-group col-md-6">\n' +
                    '                            <label for="product_price'+zz+'" class="">Product Price</label>\n' +
                    '                            <div><input required type="tel" class="form-control" onblur="chk(this.id)" id="product_price'+zz+'"\n' +
                    '                                        name="product_price[]" value=""></div>\n' +
                    '                        </div>\n' +
                    '                    </div>\n' +
                    '                    <div class="row">\n' +
                    '                        <div class="form-group col-md-6">\n' +
                    '                            <label for="product_quantity'+zz+'" class="">Product Quantity</label>\n' +
                    '                            <div><input required type="tel" class="form-control" onblur="chk(this.id)" id="product_quantity'+zz+'"\n' +
                    '                                        name="product_quantity[]" value=""></div>\n' +
                    '                        </div>\n' +
                    '                        <div id="addiInfo"></div>\n' +
                    '                    </div>\n' +
                    '\n' +
                    '                </fieldset>\n' +
                    '                <fieldset style="margin: 30px 0;" id="' + zz + 'qg">\n' +
                    '                    <legend>Images</legend>\n' +
                    '                    <div class="row" style="margin-bottom: 30px">\n' +
                    '                        <div class="form-group col-md-4">\n' +
                    '                            <label for="product_image'+zz+'" class="">Product Image (Front Page) *263x390 px</label>\n' +
                    '                            <div><input type="file" class="form-control a" id="product_image'+zz+'" name="product_image[]"\n' +
                    '                                        value="" data-image-type="primary" required>\n' +
                    '                            </div>\n' +
                    '                        </div>\n' +
                    '                        <div class="pull-right">\n'+
                    '                        </div>\n' +
                    '                    </div>\n' +
                    '\n' +
                    '                    <div class="row" id="additionalImage'+zz+'">\n' +
                    '                        <div class="form-group col-md-4">\n' +
                    '                            <label for="product_details_image'+zz+'" class="">Product Image (Details Page) *50x50 px</label>\n' +
                    '                            <div><input type="file" class="form-control a" id="product_details_image1'+zz+'"\n' +
                    '                                        name="product_details_image1[]" value="" data-image-type="small" required></div>\n' +
                    '                        </div>\n' +
                    '\n' +
                    '                        <div class="form-group col-md-4">\n' +
                    '                            <label for="product_details_image2'+zz+'" class="">Product Image (Details Page) *480x600\n' +
                    '                                px</label>\n' +
                    '                            <div><input type="file" class="form-control a" id="product_details_image2'+zz+'"\n' +
                    '                                        name="product_details_image2[]" value="" data-image-type="medium" required>\n' +
                    '                            </div>\n' +
                    '                        </div>\n' +
                    '\n' +
                    '                        <div class="form-group col-md-4">\n' +
                    '                            <label for="product_details_image 3'+zz+'" class="">Product Image (Details Page) *820x1024\n' +
                    '                                px</label>\n' +
                    '                            <div><input type="file" class="form-control a" id="product_details_image3'+zz+'"\n' +
                    '                                        name="product_details_image3[]" value="" data-image-type="large" required></div>\n' +
                    '                        </div>\n' +
                    '                    </div>\n' +
                    '\n' +
                    '                </fieldset></div>');
        });

        function chk(e) {
            if($('#'+e).val()===""){$('#'+e).parent().addClass('has-error1');}else $('#'+e).parent().removeClass('has-error1');
        }


    </script>
@endsection

@section('dashboardRight')
    <li>
        <a href="#">
            <span>@if($access===0) Accessories @else Product @endif</span>
        </a>
    </li>
    <li>
        <a href="#">
            <span>Add New @if($access===0) Accessories @else Product @endif</span>
        </a>
    </li>
@endsection

@section('content')
    <div class="row">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
            <div id="wait" style="display:none;width:69px;height:89px;border:1px solid black;position:absolute;top:50%;left:50%;padding:2px;"><img src='{{url('public/images/tenor.gif')}}' />
            </div>
        <div class="col-md-12">
            <form id="productForm" action="{{url('admin/product/add')}}" method="post" enctype="multipart/form-data" >
                @csrf
                <input type="hidden" name="is_accessories" value="{{$access}}">
                <fieldset style="margin: 30px 0;">
                    <legend>General information:</legend>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="product_name" class="">Product Name</label>
                            <div>
                                <input onblur="chk(this.id)" required type="text" class="form-control" id="product_name" name="product_name"
                                       value="{{old('product_name')}}">
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="product_category" class="">Product Category</label>
                            <div>
                                <select id="product_category" name="product_category" class="form-control" required>
                                    <option value="">select Category</option>
                                    <option value="iphone" selected>Apple</option>
                                    <option value="samsung">Samsung</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6" style="@if($access===0) display:none; @endif">
                            <label class="">Career: </label>
                            <div>
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Carrier Name</th>
                                        <th>Carrier Description</th>
                                        <th><a onclick="addCarrier(this.id)" id="car"
                                               class="plus label label-success">+</a></th>
                                    </tr>
                                    </thead>
                                    <tbody id="caree">
                                    <tr>
                                        <td>example: AT&T</td>
                                        <td>example: Fully Compatible</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="form-group @if($access===0) col-md-8 col-md-offset-2 @else col-md-6 @endif">
                            <label for="product_description" class="">Product Description</label>
                            <div>
                                <textarea required class="form-control" name="product_description"
                                          id="product_description">
                                    {{old('product_description')}}
                                </textarea>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <fieldset style="margin: 30px 0;">
                    <legend>Additional information</legend>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="product_color" class="">Product Color *[do not provide more than one
                                color]</label>
                            <div><input onblur="chk(this.id)" required type="text" class="form-control" id="product_color"
                                        name="product_color[]"
                                        value="{{old('product_color')}}"></div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="product_size" class="">Product Size [storage capacity]</label>
                            <div><input onblur="chk(this.id)" required type="text" class="form-control" id="product_size" name="product_size[]"
                                        value="{{old('product_size')}}"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="product_label" class="">Product Label</label>
                            <div>
                                <select id="product_label" name="product_label[]" class="form-control">
                                    <option value="0">select label</option>
                                    <option value="ON SALE">ON SALE</option>
                                    <option value="LIMITED EDITION">LIMITED EDITION</option>
                                    <option value="NEW">NEW</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="product_price" class="">Product Price</label>
                            <div><input onblur="chk(this.id)" required type="tel" class="form-control" id="product_price"
                                        name="product_price[]" value="{{old('product_price')}}"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="product_quantity" class="">Product Quantity</label>
                            <div><input onblur="chk(this.id)" required type="tel" class="form-control" id="product_quantity"
                                        name="product_quantity[]" value="{{old('product_quantity')}}"></div>
                        </div>
                        <div id="addiInfo"></div>
                    </div>

                </fieldset>
                <input type="hidden" name="desc" value="fail" id="desc">
                <fieldset style="margin: 30px 0;" id="appendImg">
                    <legend>Images</legend>
                    <div class="row" style="margin-bottom: 30px">
                        <div class="form-group col-md-4">
                            <label for="product_image" class="">Product Image (Front Page) *263x390 px</label>
                            <div><input type="file" class="form-control a" id="product_image" name="product_image[]"
                                        value="" data-image-type="primary" required>
                            </div>
                        </div>
                        {{--<div class="pull-right">--}}
                        {{--<button onclick="addImageSection(this.id)" id="appendIm" type="button"--}}
                        {{--class="btn btn-success">add more additional images--}}
                        {{--</button>--}}
                        {{--</div>--}}
                    </div>

                    <div class="row" id="additionalImage">
                        <div class="form-group col-md-4">
                            <label for="product_details_image1" class="">Product Image (Details Page) *50x50 px</label>
                            <div><input type="file" class="form-control a" id="product_details_image1"
                                        name="product_details_image1[]" value="" data-image-type="small" required></div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="product_details_image2" class="">Product Image (Details Page) *480x600
                                px</label>
                            <div><input type="file" class="form-control a" id="product_details_image2"
                                        name="product_details_image2[]" value="" data-image-type="medium" required>
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="product_details_image 3" class="">Product Image (Details Page) *1024x1024
                                px</label>
                            <div><input type="file" class="form-control a" id="product_details_image3"
                                        name="product_details_image3[]" value="" data-image-type="large" required></div>
                        </div>
                    </div>

                </fieldset>
                <div class="addsection">

                </div>
                <img id="image" src="" width="70px" height="70px" style="display:none;">
                <input type="hidden" name="chk_name" value="absent" id="chk_name">

                <div class="text-center">
                    <input id="addColor" type="button" class="btn btn-info" name="addColor" value="Add more color or size">
                    <input id="submit" type="submit" class="btn btn-primary" name="submit" value="Add">
                </div>

            </form>
        </div>
    </div>
@endsection