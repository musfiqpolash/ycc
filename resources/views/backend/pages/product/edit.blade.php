@extends('backend.layouts.app')

@section('dashboardRight')
    <li>
        <a href="#">
            <span>@if($access===0) Accessories @else Product @endif</span>
        </a>
    </li>
    <li>
        <a href="#">
            <span>@if($access===0) Accessories @else Product @endif List</span>
        </a>
    </li>
    <li>
        <a href="#">
            <span>@if($access===0) Accessories @else Product @endif Edit</span>
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
        @include('includes.flashMessage')
        <div class="col-md-12">
            <form id="productForm" action="{{url('admin/product/update')}}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="is_accessories" value="{{$page_data[0]->is_accessories}}">
                <fieldset style="margin: 30px 0;">
                    <legend>General information:</legend>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="product_name" class="">Product Name</label>
                            <div>
                                <input required type="text" class="form-control" id="product_name" name="product_name"
                                       value="{{$page_data[0]->name}}">
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="product_category" class="">Product Category</label>
                            <div>
                                <select id="product_category" name="product_category" class="form-control" required>
                                    <option value="">select Category</option>
                                    <option value="iphone" <?php if ($page_data[0]->category === 'iphone') echo 'selected';?>>
                                        Apple
                                    </option>
                                    <option value="samsung" <?php if ($page_data[0]->category === 'samsung') echo 'selected';?>>
                                        Samsung
                                    </option>
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
                                    {{$page_data[0]->description}}
                                </textarea>
                            </div>
                        </div>
                    </div>
                </fieldset>
                @foreach($page_data as $k=>$val)
                    <input type="hidden" name="pro_id[]" value="{{$val->id}}">
                    <fieldset style="margin: 30px 0;">
                        <legend>Additional information for Color: <i>{{$val->color}}</i> and Size: <i>{{$val->size}}</i>
                        </legend>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="product_color{{$k}}" class="">Product Color *[do not provide more than one
                                    color]</label>
                                <div><input onblur="chk(this.id)" required type="text" class="form-control"
                                            id="product_color{{$k}}"
                                            name="product_color[]"
                                            value="{{$val->color}}"></div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="product_size{{$k}}" class="">Product Size [storage capacity]</label>
                                <div><input onblur="chk(this.id)" required type="text" class="form-control"
                                            id="product_size{{$k}}"
                                            name="product_size[]"
                                            value="{{$val->size}}"></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="product_label{{$k}}" class="">Product Label</label>
                                <div>
                                    <select id="product_label{{$k}}" name="product_label[]" class="form-control">
                                        <option value="0">select label</option>
                                        <option value="ON SALE" <?php if ($val->label === 'ON SALE') echo 'selected';?>>
                                            ON SALE
                                        </option>
                                        <option value="LIMITED EDITION" <?php if ($val->label === 'LIMITED EDITION') echo 'selected';?>>
                                            LIMITED EDITION
                                        </option>
                                        <option value="NEW" <?php if ($val->label === 'NEW') echo 'selected';?>>NEW
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="product_price{{$k}}" class="">Product Price</label>
                                <div><input onblur="chk(this.id)" required type="tel" class="form-control"
                                            id="product_price{{$k}}"
                                            name="product_price[]" value="{{$val->price}}"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="product_quantity{{$k}}" class="">Product Quantity</label>
                                <div><input onblur="chk(this.id)" required type="tel" class="form-control"
                                            id="product_quantity{{$k}}"
                                            name="product_quantity[]" value="{{$val->quantity}}"></div>
                            </div>
                            <div id="addiInfo"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h3>Image: Front Page <span style="color: peru; font-size: 14px;">*Click on the image to update</span></h3>
                                <img onclick="openModal(this.id,'primary',this.src,'product_image[]','{{$val->id}}','{{$val->main_image}}')"
                                     id="primary{{$k}}"
                                     style="width: 10%"
                                     src="{{url('public/uploads/assets/frontend/images/products/'.$val->main_image)}}"
                                     alt="{{$val->main_image}}">
                            </div>
                            <div class="col-md-12 table-responsive">
                                <h3>Images: Details Page <span style="color: peru; font-size: 14px;">*Click on the image to update</span></h3>
                                <table align="center" class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Thumbnail</th>
                                        <th>Details Image</th>
                                        <th>Zoom Image</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php $i=1; @endphp
                                    @foreach($val->hasImage as $p)
                                        <tr>
                                            <td>{{$i++}}</td>
                                            <td>
                                                <div class="text-center"><img
                                                            onclick="openModal(this.id,'small',this.src,'product_details_image1[]','{{$p->product_id}}','{{$p->thum_img}}')"
                                                            id="small{{$k}}" style="width: 50%;"
                                                            src="{{url('public/uploads/assets/frontend/images/products/'.$p->thum_img)}}"
                                                            alt="{{$p->thum_img}}"></div>
                                            </td>
                                            <td>
                                                <div class="text-center"><img
                                                            onclick="openModal(this.id,'medium',this.src,'product_details_image2[]','{{$p->product_id}}','{{$p->main_img}}')"
                                                            id="medium{{$k}}" style="width: 40%;"
                                                            src="{{url('public/uploads/assets/frontend/images/products/'.$p->main_img)}}"
                                                            alt="{{$p->main_img}}"></div>
                                            </td>
                                            <td>
                                                <div class="text-center"><img
                                                            onclick="openModal(this.id,'large',this.src,'product_details_image3[]','{{$p->product_id}}','{{$p->zoom_img}}')"
                                                            id="large{{$k}}" style="width: 30%;"
                                                            src="{{url('public/uploads/assets/frontend/images/products/'.$p->zoom_img)}}"
                                                            alt="{{$p->zoom_img}}"></div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </fieldset>
                @endforeach
                <input type="hidden" name="desc" value="fail" id="desc">
                <img id="image" src="" width="70px" height="70px" style="display:none;">

                <div class="text-center">
                    <input id="submit" type="submit" class="btn btn-primary" name="submit" value="update">
                </div>

            </form>
            <div style="margin-top: 20px">
                <form id="productFormAdd" action="{{url('admin/product/updateAdd')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="group_name" value="{{$page_data[0]->group_name}}">
                    <div class="addsection"></div>
                    <div class="text-center">
                        <input id="addColor" type="button" class="btn btn-info" value="Add more color or size">
                        <input id="submitInfo" type="submit" class="btn btn-primary" name="add" value="Add" style="display: none;">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <form id="imageChangeForm" action="{{url('admin/product/updateImage')}}" method="post"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"></h4>
                    </div>
                    <div class="modal-body">
                        <div style="margin: 0 auto;" class="text-center">
                            <img id="cngImg" src="" alt="img" style="max-width: 30%">
                        </div>
                        <div>
                            <input required id="imgInput" type="file" class="form-control bbb" name="">
                            <input type="hidden" name="secterCng" id="secretCng" value="fail">
                            <input type="hidden" name="proId" id="proId" value="">
                            <input type="hidden" name="oldImg" id="oldImg" value="">
                            <span class="sp" style="display: none;">*Check images width and height</span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Update</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>


        </div>
    </div>
@endsection

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
    <script src="https://cdn.ckeditor.com/4.8.0/full/ckeditor.js"></script>

    <script>
        function openModal(id, val, src, nm, proId, oldImg) {
            console.log(id + ' ' + val + ' ' + src + ' ' + nm + ' ' + proId + ' ' + oldImg);
            if (val === 'primary') $('.modal-title').text('Change Main Image. Dimension: 263X390 px');
            if (val === 'small') $('.modal-title').text('Change Thumbnail Image. Dimension: 50X50 px');
            if (val === 'medium') $('.modal-title').text('Change Details Image. Dimension: 480X600 px');
            if (val === 'large') $('.modal-title').text('Change Zoom Image Dimension: 1024X1024 px');
            $('#imgInput').attr({'name': nm, 'data-image-type': val});
            $('#cngImg').attr({'src': src, 'data-image-type': val});
            $("#proId").val(proId);
            $("#oldImg").val(oldImg);
            $("#myModal").modal()
        }

        $('#myModal').on('hidden.bs.modal', function () {
            $('#imgInput').val("");
            $('.sp').hide().parent().removeClass('has-error1');
            $('#secretCng').val('fail');
            $("#proId").val('');
            $("#oldImg").val('');

        });
        $('#imageChangeForm').on('submit', function () {
            return $('#imageChangeForm').valid() && $('#secretCng').val() === "pass" ? true : false;
        });


        var _URL = window.URL || window.webkitURL;
        // <button onclick="addImageSection(this.id)" id="' + zz + 'q" type="button" class="btn btn-success">add more additional images</button>
        // function getDiscountDiv() {
        //     alert('dgf');
        // }

        $(document).on('change', '.bbb', function () {
            var v = $(this).attr('data-image-type');
            var va = $(this).attr('id');
            console.log(v);
            var file, img;
            if ((file = this.files[0])) {
                img = new Image();
                img.onload = function () {
                    console.log("width : " + this.width + " and height : " + this.height);
                    if (v === 'primary' && this.width === 263 && this.height === 390) {
                        $('#secretCng').val('pass');
                        $('#' + va).parent().removeClass('has-error1');
                        $('.sp').hide();
                        console.log('pass');
                    }
                    else if (v === 'small' && this.width === 50 && this.height === 50) {
                        $('#secretCng').val('pass');
                        $('#' + va).parent().removeClass('has-error1');
                        $('.sp').hide();
                        console.log('pass');
                    }
                    else if (v === 'medium' && this.width === 480 && this.height === 600) {
                        $('#secretCng').val('pass');
                        $('#' + va).parent().removeClass('has-error1');
                        $('.sp').hide();
                        console.log('pass');
                    }
                    else if (v === 'large' && this.width === 1024 && this.height === 1024) {
                        $('#secretCng').val('pass');
                        $('#' + va).parent().removeClass('has-error1');
                        $('.sp').hide();
                        console.log('pass');
                    }
                    else {
                        $('#secretCng').val('fail');
                        $('#' + va).parent().addClass('has-error1');
                        $('.sp').show();
                        console.log('fail');
                    }

                };

                img.src = _URL.createObjectURL(file);

                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#cngImg')
                        .attr('src', e.target.result);
                };
                reader.readAsDataURL(this.files[0]);
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


        $('#productForm').on('submit', function (params) {
            var req = 0;
            $('#productForm *').filter(':input').each(function () {
                if ($(this).val() === "" && $(this).attr('required')) {
                    $(this).parent().addClass('has-error1');
                    req++;
                }
            });
            if (req === 0) {
                if ($('#productForm').valid()) {
                    return true;
                }
                else return false;
            } else {
                //alert("Error: you need fill all required input, inputs empty" + req + " .");
                return false;
            }
        });
        $('#productFormAdd').on('submit', function (params) {
            var req = 0;
            $('#productFormAdd *').filter(':input').each(function () {
                if ($(this).val() === "" && $(this).attr('required')) {
                    $(this).parent().addClass('has-error1');
                    req++;
                }
            });
            if (req === 0) {
                if ($('#productFormAdd').valid() && $('#desc').val() === "pass") {
                    return true;
                }
                else return false;
            } else {
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

        function rmvZZ(e) {
            $('.zz' + e).remove();
            if ($('.addsection').children().length===0){
                $('#submitInfo').hide();
            }
        }

        var zz = 0;
        $('#addColor').on('click', function () {
            $('#submitInfo').show();
            zz += 1;
            $('.addsection').append('<div class="panel zz' + zz + '"><fieldset style="margin: 30px 0;">\n' +
                '                    <legend>Additional information</legend><a  onclick="rmvZZ(this.id)" id="' + zz + '" class="minus label label-danger">' + "&nbsp;-&nbsp;" + '</a>' +
                '                    <div class="row">\n' +
                '                        <div class="form-group col-md-6">\n' +
                '                            <label for="product_color' + zz + '" class="">Product Color *[do not provide more than one color]</label>\n' +
                '                            <div><input required type="text" class="form-control" id="product_color' + zz + '" onblur="chk(this.id)" name="product_color[]"\n' +
                '                                        value=""></div>\n' +
                '                        </div>\n' +
                '\n' +
                '                        <div class="form-group col-md-6">\n' +
                '                            <label for="product_size' + zz + '" class="">Product Size [storage capacity]</label>\n' +
                '                            <div><input required type="text" class="form-control" id="product_size' + zz + '" onblur="chk(this.id)" name="product_size[]"\n' +
                '                                        value=""></div>\n' +
                '                        </div>\n' +
                '                    </div>\n' +
                '\n' +
                '                    <div class="row">\n' +
                '                        <div class="form-group col-md-6">\n' +
                '                            <label for="product_label' + zz + '" class="">Product Label</label>\n' +
                '                            <div>\n' +
                '                                <select id="product_label' + zz + '" name="product_label[]" class="form-control">\n' +
                '                                    <option value="0">select label</option>\n' +
                '                                    <option value="ON SALE">ON SALE</option>\n' +
                '                                    <option value="LIMITED EDITION">LIMITED EDITION</option>\n' +
                '                                    <option value="NEW">NEW</option>\n' +
                '                                </select>\n' +
                '                            </div>\n' +
                '                        </div>\n' +
                '                        <div class="form-group col-md-6">\n' +
                '                            <label for="product_price' + zz + '" class="">Product Price</label>\n' +
                '                            <div><input required type="tel" class="form-control" onblur="chk(this.id)" id="product_price' + zz + '"\n' +
                '                                        name="product_price[]" value=""></div>\n' +
                '                        </div>\n' +
                '                    </div>\n' +
                '                    <div class="row">\n' +
                '                        <div class="form-group col-md-6">\n' +
                '                            <label for="product_quantity' + zz + '" class="">Product Quantity</label>\n' +
                '                            <div><input required type="tel" class="form-control" onblur="chk(this.id)" id="product_quantity' + zz + '"\n' +
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
                '                            <label for="product_image' + zz + '" class="">Product Image (Front Page) *263x390 px</label>\n' +
                '                            <div><input type="file" class="form-control a" id="product_image' + zz + '" name="product_image[]"\n' +
                '                                        value="" data-image-type="primary" required>\n' +
                '                            </div>\n' +
                '                        </div>\n' +
                '                        <div class="pull-right">\n' +
                '                        </div>\n' +
                '                    </div>\n' +
                '\n' +
                '                    <div class="row" id="additionalImage' + zz + '">\n' +
                '                        <div class="form-group col-md-4">\n' +
                '                            <label for="product_details_image' + zz + '" class="">Product Image (Details Page) *50x50 px</label>\n' +
                '                            <div><input type="file" class="form-control a" id="product_details_image1' + zz + '"\n' +
                '                                        name="product_details_image1[]" value="" data-image-type="small" required></div>\n' +
                '                        </div>\n' +
                '\n' +
                '                        <div class="form-group col-md-4">\n' +
                '                            <label for="product_details_image2' + zz + '" class="">Product Image (Details Page) *480x600\n' +
                '                                px</label>\n' +
                '                            <div><input type="file" class="form-control a" id="product_details_image2' + zz + '"\n' +
                '                                        name="product_details_image2[]" value="" data-image-type="medium" required>\n' +
                '                            </div>\n' +
                '                        </div>\n' +
                '\n' +
                '                        <div class="form-group col-md-4">\n' +
                '                            <label for="product_details_image 3' + zz + '" class="">Product Image (Details Page) *820x1024\n' +
                '                                px</label>\n' +
                '                            <div><input type="file" class="form-control a" id="product_details_image3' + zz + '"\n' +
                '                                        name="product_details_image3[]" value="" data-image-type="large" required></div>\n' +
                '                        </div>\n' +
                '                    </div>\n' +
                '\n' +
                '                </fieldset></div>');
        });

        function chk(e) {
            if ($('#' + e).val() === "") {
                $('#' + e).parent().addClass('has-error1');
            } else $('#' + e).parent().removeClass('has-error1');
        }


    </script>
@endsection