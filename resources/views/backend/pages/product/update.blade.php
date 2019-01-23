@extends('backend.layouts.app')

@section('customCss')
    <style>
        #example > th {
            text-align: center;
        }

        .form-control{
            padding: 3px 8px;
            height: 30px;
            font-size: 13px;
			text-transform: uppercase;
        }
		th{
			text-transform: uppercase;
		}
    </style>
@endsection


@section('dashboardRight')
    <li>
        <a href="#">
            <span>@if($access===0) Accessories @else Product @endif</span>
        </a>
    </li>
    <li>
        <a href="#">
            <span>Edit @if($access===0) Accessories @else Product @endif</span>
        </a>
    </li>
@endsection

@section('content')
    <form id="productForm" action="" method="post" enctype="multipart/form-data">
        {{csrf_field()}}
        <section class="panel">
            <div class="panel-body">
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
                </div>
                <div class="row">
                    @include('includes.flashMessage')
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="product_name" class=""><b>Product Name</b></label>
                        <div>
								<input required readonly type="text" class="form-control" id="product_name"
									   name="product_name"
									   value="{{$product->name}}">
								<input type="hidden" name="p_id" value="{{$product->id}}">

                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="product_category" class=""><b>Product Category</b></label>
                        <div>
								<select id="product_category" name="product_category" class="form-control" required>
										<option value="{{$product->hasCategory->id}}" selected>{{$product->hasCategory->name}}</option>
									</select>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="product_sub_category" class=""><b>Product Sub Category</b></label>
                        <div>
								<select id="product_sub_category" name="product_sub_category" class="form-control" required>
										<option value="{{$product->hasSubCategory->id}}" selected>{{$product->hasSubCategory->name}}</option>
									</select>
                        </div>
                    </div>
                </div>
                <div style="margin-top:2rem;">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped mb-none" id="example">
                            <thead>
                            <tr>
                                {{-- <th>Condition</th> --}}
                                <th>Memory</th>
                                <th>Color</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Label</th>
                                {{-- <th>Carrier</th> --}}
								<th>Description</th>
                            </tr>
                            </thead>
                            <tbody id="append_row">
                            <tr id="row_0">
                                {{-- <td style="width: 12%">
                                    <select name="condition" id="condition_0" class="form-control">
                                        <option @if($product->product_condition=='GRADE A')selected @endif value="GRADE A">GRADE A</option>
                                        <option @if($product->product_condition=='GRADE B')selected @endif value="GRADE B">GRADE B</option>
                                        <option @if($product->product_condition=='GRADE C')selected @endif value="GRADE C">GRADE C</option>
                                    </select>
                                </td> --}}
                                <td style="width: 20%;">
                                    <input type="text" name="memory" value="{{$product->size}}" id="memory_0" placeholder="Size" class="form-control">
                                </td>
                                <td style="width: 20%">
									<input onkeypress="return forColor(event)" type="text" name="color" value="{{$product->color}}" id="color_0" placeholder="Color" class="form-control">
                                    {{-- <input type="text" name="memory" value="{{$product->size}}"  placeholder="Memory" class="form-control" style="display: none;"> --}}
                                    <input type="text" name="condition" value="{{$product->product_condition}}"  placeholder="product_condition" class="form-control" style="display: none;">
                                </td>
                                <td style="width: 20%">
									<input type="text" name="price[0][]" value="{{$product->hasPrice[0]->price}}" id="price_0" placeholder="Color" class="form-control">
                                <td style="width: 20%">
                                    <input type="tel" onkeypress="return onlyNumber(event)" name="stock" value="{{$product->quantity}}" id="stock_0" placeholder="Stock" class="form-control">
                                </td>
                                <td style="width: 15%">
                                    <select id="label_0" name="product_label" class="form-control">
                                        <option value="0">select label</option>
                                        <option value="FEATURED">FEATURED</option>
                                        <option value="NEW">NEW</option>
                                    </select>
                                </td>
                                {{-- <td align="center">
                                    <a role="button" onclick="openCarrierModal(0)" class="label label-primary carrier_a_0">Add</a>
                                </td> --}}
								<td align="center">
									<a role="button" onclick="openDescriptionModal(0)" class="label label-primary desc_a_0">Add</a>
								</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
					<div style="margin-top: 25px;">
						<button type="button" onclick="openImageModal(0)" class="btn btn-primary pull-right">Add Images</button>
						<h4><b style="text-transform: uppercase;">* select image to change display product image</b></h4>
						@php($path=asset('public/uploads/assets/frontend/images/products'))
						<div style="margin-top:25px;">
							@foreach($product->hasImage as $k=>$val)
								<div class="col-md-2 col-sm-3 col-xs-4 text-center">
									<label for="pp_img{{$k}}" style="border: 1px solid #ccc; text-align: center">
										<img width="60" src="{{$path.'/'.$val->p_main_image}}" alt="{{$val->p_main_image}}">
										<br>
										<input @if($val->p_main_image=='no_image.png' && $k==0)checked @endif  @if($product->main_image==$val->p_main_image)checked @endif type="radio" name="display_pic" value="{{$val->p_main_image}}" id="pp_img{{$k}}">
									</label>
									<button type="button" onclick="changeImage('{{$val->id}}')" class="btn btn-info">Change</button>
								</div>
							@endforeach
						</div>
					</div>
                </div>
			</div>
			<div class="panel-footer text-center">
				<div class="row">
					<div id="errDiv" class="alert alert-danger" style="display: none;"></div>
				</div>
				<button type="button" onclick="validateForm()" class="btn btn-primary">Update</button>
			</div>
		</section>
		{{--modals--}}
        {{-- <div id="price_modal_div">
			<div id="price_modal_0" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
				<div class="modal-dialog">
					<!-- Modal content-->
					<div class="modal-content">
						<div class="modal-body">
							<div class="table-responsive">
								<table class="table table-bordered">
									<thead>
									<tr>
										<th></th>
										<th colspan="2">Quantity</th>
										<th>Price (per unit)</th>
									</tr>
									</thead>
									<tbody id="price_table_0">
									<tr>
										<td><a onclick="addPriceInput(0)" role="button" class="label label-primary"><i class="fa fa-plus"></i></a></td>
										<td colspan="2">
											<input type="text" name="min_quantity[0][]" id="min_quantity_0_0" placeholder="min quantity" value="1" readonly class="form-control">
											<input type="hidden" name="max_quantity[0][]" id="max_quantity_0_0" placeholder="max quantity" value="1">
										</td>
										<td><input onkeypress="return onlyNumber(event)" type="text" value="{{$product->hasPrice[0]->price}}" name="price[0][]" id="price_0_0" data-id="0" placeholder="price" class="form-control price"></td>
									</tr>
									@foreach($product->hasPrice as $k=>$val)
										@if(!$loop->first)
											<tr id="price_table_row_{{$k}}">
												<td><a onclick="removeElementById('price_table_row_{{$k}}')" role="button" class="label label-danger"><i class="fa fa-times"></i></a></td>
												<td>
													<div class="input-group">
														<span class="input-group-addon">Min</span>
														<input onblur="checkMax(this,'max_quantity_0_{{$k}}')" value="{{$val->min_quantity}}" onkeypress="return onlyNumber(event)" type="text" name="min_quantity[0][]" id="min_quantity_0_{{$k}}" data-id="0" placeholder="min quantity" class="form-control price">
													</div>
												</td>
												<td>
													<div class="input-group">
														<span class="input-group-addon">Max</span>
														<input onblur="checkMin(this,'min_quantity_0_{{$k}}')" value="{{$val->max_quantity}}" onkeypress="return onlyNumber(event)" type="text" name="max_quantity[0][]" id="max_quantity_0_{{$k}}" data-id="0" placeholder="max quantity" class="form-control price">
													</div>
												</td>
												<td><input onkeypress="return onlyNumber(event)" type="text" name="price[0][]" value="{{$val->price}}" id="price_0_{{$k}}" data-id="0" placeholder="price" class="form-control price"></td>
											</tr>
										@endif
									@endforeach
									</tbody>
								</table>
							</div>
						</div>
						<div class="modal-footer">
							<button onclick="chkPriceModal('price_modal_0')" type="button" class="btn btn-default" data-dismiss="modal">Continue</button>
						</div>
					</div>

				</div>
			</div>
		</div> --}}

		<div id="carrier_modal_div">
			<div id="carrier_modal_0" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
				<div class="modal-dialog">
					<!-- Modal content-->
					<div class="modal-content">
						<div class="modal-body">
							<div class="table-responsive">
								<table class="table table-bordered">
									<thead>
									<tr>
										<th></th>
										<th>Carrier Name</th>
										<th>Carrier Description</th>
									</tr>
									</thead>
									<tbody id="carrier_table_0">
									@php($i=1)
									@if(!empty($product->carrier_details))
										@php($j=json_decode($product->carrier_details))
										@foreach($j as $k)
											@if($loop->first)
												<tr>
													<td><a onclick="addCarrierInput(0)" role="button" class="label label-primary"><i class="fa fa-plus"></i></a></td>
													<td><input type="text" name="c_name[0][]" id="c_name_0_0" value="{{$k->name}}" placeholder="Name" class="form-control carrier"></td>
													<td><input type="text" name="c_description[0][]" id="c_description_0_0" value="{{$k->description}}" placeholder="Description" class="form-control carrier"></td>
												</tr>
											@else
												<tr id="carrier_table_row_{{$i}}">
													<td><a onclick="removeElementById('carrier_table_row_{{$i}}')" role="button" class="label label-danger"><i class="fa fa-times"></i></a></td>
													<td><input type="text" name="c_name[0][]" id="c_name_0_{{$i}}" value="{{$k->name}}" placeholder="Name" class="form-control carrier"></td>
													<td><input type="text" name="c_description[0][]" id="c_description_0_{{$i}}" value="{{$k->description}}" placeholder="Description" class="form-control carrier"></td>
												</tr>
											@endif
											@php($i++)
										@endforeach
									@else
										<tr>
											<td><a onclick="addCarrierInput(0)" role="button" class="label label-primary"><i class="fa fa-plus"></i></a></td>
											<td><input type="text" name="c_name[0][]" id="c_name_0_0" placeholder="Name" class="form-control carrier"></td>
											<td><input type="text" name="c_description[0][]" id="c_description_0_0" placeholder="Description" class="form-control carrier"></td>
										</tr>
									@endif
									</tbody>
								</table>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Continue</button>
						</div>
					</div>

				</div>
			</div>
		</div>
		<div id="description_modal_div">
			<div id="description_modal_0" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
				<div class="modal-dialog">
					<!-- Modal content-->
					<div class="modal-content">
						<div class="modal-body">
							<textarea name="description" placeholder="Product Description" class="textarea" id="description_0" cols="30" rows="10"><?=$product->description?></textarea>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Continue</button>
						</div>
					</div>

				</div>
			</div>
		</div>
    </form>
	<div id="image_modal_div">
		<div id="image_modal_0" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog">
				<!-- Modal content-->
				<form action="{{url('admin/upload_image')}}" method="post" enctype="multipart/form-data" id="img_upload_form">
					{{csrf_field()}}
					<div class="modal-content">
						<div class="modal-body text-center" id="img_div_0">
							<h3>* Image dimension must be 1024x1280</h3>
							<img src="" id="img" alt="img_0" style="display: none">
							<div style="margin-bottom: 4px;" class="input-group">
								<span style="background-color: #0088cc; color: white; border: none; cursor: pointer;" onclick="addImageInput(0)" class="input-group-addon"><i class="fa fa-plus"></i></span>
								<input type="file" name="image[]" id="image_0_0" class="form-control bbb">
								<input type="hidden" name="valid_image[]" data-id="0" class="valid_image">
							</div>
						</div>
						<div class="modal-footer">
							<input type="hidden" name="p_id" value="{{$product->id}}">
							<button onclick="submitImgForm('img_upload_form')" type="button" class="btn btn-primary">Upload</button>
							<a role="button" class="btn btn-default" data-dismiss="modal">Close</a>
						</div>
					</div>
				</form>

			</div>
		</div>
	</div>

	<div id="image_change_modal_div">
		<div id="image_change_modal_0" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog">
				<!-- Modal content-->
				<div class="modal-content">
					<form method="post" action="{{url('admin/change_image')}}" id="image_change_form" enctype="multipart/form-data">
						{{csrf_field()}}
						<div class="modal-body text-center" id="img_div_00">
							<h3>* Image dimension must be 1024x1280</h3>
							<img src="" id="imgg" alt="img_0" style="display: none">
							<div style="margin-bottom: 4px;" class="input-group">
								<input type="file" name="image" id="image" class="form-control bbb">
								<input type="hidden" name="valid_image" data-id="0" class="valid_image">
							</div>
							<input type="hidden" name="img_table_id" id="image_table_id" value="">
						</div>
						<div class="modal-footer">
							<button type="button" onclick="submitImgForm('image_change_form')" class="btn btn-primary">Update</button>
							<a role="button" class="btn btn-default" data-dismiss="modal">Close</a>
						</div>
					</form>
				</div>

			</div>
		</div>
	</div>

@endsection

@section('customJs')
	<script src="https://cdn.ckeditor.com/4.8.0/full/ckeditor.js"></script>
    <script>
		var i=1;
        CKEDITOR.replace('description_0');

        function openPriceModal(flag) {
			var p_modal=$('#price_modal_'+flag);
			p_modal.modal();
        }
        function openImageModal(flag) {
            var i_modal=$('#image_modal_'+flag);
            i_modal.modal();
        }
        function openCarrierModal(flag) {
            var c_modal=$('#carrier_modal_'+flag);
            c_modal.modal();
        }

        function openDescriptionModal(flag) {
            var c_modal=$('#description_modal_'+flag);
            c_modal.modal();
        }

        var price_count='<?=sizeof($product->hasPrice)?>';
        function addPriceInput(flag) {
			$('#price_table_'+flag).append(`
				<tr id="price_table_row_${price_count}">
					<td><a onclick="removeElementById('price_table_row_${price_count}')" role="button" class="label label-danger"><i class="fa fa-times"></i></a></td>
					<td>
						<div class="input-group">
							<span class="input-group-addon">Min</span>
							<input onblur="checkMax(this,'max_quantity_${flag}_${price_count}')" onkeypress="return onlyNumber(event)" type="text" name="min_quantity[${flag}][]" id="min_quantity_${flag}_${price_count}" data-id="${flag}" placeholder="min quantity" class="form-control price">
						</div>
					</td>
					<td>
						<div class="input-group">
							<span class="input-group-addon">Max</span>
							<input onblur="checkMin(this,'min_quantity_${flag}_${price_count}')" onkeypress="return onlyNumber(event)" type="text" name="max_quantity[${flag}][]" id="max_quantity_${flag}_${price_count}" data-id="${flag}" placeholder="max quantity" class="form-control price">
						</div>
					</td>
					<td><input onkeypress="return onlyNumber(event)" type="text" name="price[${flag}][]" id="price_${flag}_${price_count}" data-id="${flag}" placeholder="price" class="form-control price"></td>
				</tr>
			`);
			price_count++;
        }

        var img_count=1;
        function addImageInput(flag) {
			$('#img_div_'+flag).append(
			    `<div style="margin-bottom: 4px;" class="input-group" id="img_input_div_${flag}_${img_count}">
					<span style="background-color: #d2322d; color: white; border: none; cursor: pointer;" onclick="removeElementById('img_input_div_${flag}_${img_count}')" class="input-group-addon"><i class="fa fa-times"></i></span>
					<input type="file" name="image[]" id="image_${flag}_${img_count}" class="form-control bbb">
					<input type="hidden" name="valid_image[]" data-id="0" class="valid_image">
				</div>`
			);
			img_count++;
        }
        var car_count='<?=$i?>';
        function addCarrierInput(flag) {
            $('#carrier_table_'+flag).append(`
				<tr id="carrier_table_row_${car_count}">
					<td><a onclick="removeElementById('carrier_table_row_${car_count}')" role="button" class="label label-danger"><i class="fa fa-times"></i></a></td>
					<td><input type="text" name="c_name[${flag}][]" id="c_name_${flag}_${car_count}" placeholder="Name" class="form-control carrier"></td>
					<td><input type="text" name="c_description[${flag}][]" id="c_description_${flag}_${car_count}" placeholder="Description" class="form-control carrier"></td>
				</tr>
			`);
            car_count++;
        }

        function removeElementById(id) {
			$('#'+id).remove();
        }


        var _URL = window.URL || window.webkitURL;

        function isImage(file){
            return file['type'].split('/')[0]=='image';
        }

        $(document).on('change', '.bbb', function () {
            var file, img;
            var tis=$(this);
            file = this.files[0];
            if ((file) && isImage(file)) {
                img = new Image();
                img.onload = function () {
                    console.log("width : " + this.width + " and height : " + this.height);
                    if (this.width === 1024 && this.height === 1280) {
                        tis.css('border','1px solid green');
                        tis.parent().parent().parent().find('button').removeAttr('disabled');
                        tis.parent().find('.chkk').remove();
						tis.parent().append('<span class="input-group-addon chkk" style="background-color: green; color: white; border: none"><i class="fa fa-check"></i></span>');
                        tis.parent().find('.valid_image').val(1);
                        console.log('pass');
                    }
                    else {
                        tis.css('border','1px solid red');
                        tis.parent().find('.chkk').remove();
                        tis.parent().append('<span class="input-group-addon chkk" style="background-color: red; color: white; border: none"><i class="fa fa-ban"></i></span>');
                        tis.parent().parent().parent().find('button').attr('disabled','disabled');
                        tis.parent().find('.valid_image').val('');
                        console.log('fail');
                    }

                };

                img.src = _URL.createObjectURL(file);

                var reader = new FileReader();

                reader.onload = function (e) {
                    tis.parent().parent().find('img')
                        .attr('src', e.target.result);
                };
                reader.readAsDataURL(this.files[0]);
            }
            else {
                tis.css('border','1px solid red');
                tis.parent().find('.chkk').remove();
                tis.parent().append('<span class="input-group-addon chkk" style="background-color: red; color: white; border: none"><i class="fa fa-ban"></i></span>');
                tis.parent().parent().parent().find('button').attr('disabled','disabled');
                tis.parent().find('.valid_image').val('');
                console.log('fail');
			}
        });

        function onlyNumber(e) {
			var k=e.keyCode;
            if (k > 31 && (k < 48 || k > 57))
                return false;
            return true;
        }
        function forColor(e) {
            var k=e.keyCode;
            if (k == 46 || k==59 || k ==44)
                return false;
            return true;
        }

        function checkMax(min,max) {
			var min=$(min);
			var max=$('#'+max);
			if(!$.isEmptyObject(max.val()) && parseInt(min.val())>parseInt(max.val())) min.val('');
        }
        function checkMin(max,min) {
            var min=$('#'+min);
            var max=$(max);
            if(!$.isEmptyObject(min.val()) && parseInt(min.val())>parseInt(max.val())) max.val('');
        }

        function validateForm() {
            var ij=0;
            $('.label-primary').css('border','none');
            $('#productForm *').filter(':input').each(function (){
                if(!$(this).is('button') && !$(this).is(':file') && !$(this).is('.carrier') && !$(this).is('textarea')){
                    if ($.isEmptyObject($(this).val())){
                        $(this).css('border','1px solid red');
                        if($(this).is('.price')){
                            $('.price_a_'+$(this).attr('data-id')).css('border','1px solid red');
						}
                        if($(this).is('.valid_image')){
                            $('.image_a_'+$(this).attr('data-id')).css('border','1px solid red');
                        }
                        ij++;
                        //console.log($(this));
                    }else {
                        $(this).css('border','1px solid #cccccc');
                    }
				}
			});
            if (ij===0){
                $('#productForm').submit();
                $('#errDiv').html('').hide();
			}else {
                $('#errDiv').html('Fill up all the required fields').show();
			}
        }
        $('input').on('blur',function () {
			if(!$.isEmptyObject($(this).val())){
                $(this).css('border','1px solid #cccccc');
			}
        });

        function chkPriceModal(e) {
			var d=e.split('_');
			var dd=d[d.length-1];
			var ddd=0;
			$('#'+e+ ' *').filter(':input').each(function () {
				if($.isEmptyObject($(this).val()) && !$(this).is('button')){
				    $(this).css('border','1px solid red');
				    ddd++;
				}else {
                    $(this).css('border','1px solid #cccccc');
				}
            });
			if(ddd==0){
			    $('.price_a_'+dd).css('border','none');
			}else {
                $('.price_a_'+dd).css('border','1px solid red');
			}
        }

        function chkImageModal(e) {
            var d=e.split('_');
            var dd=d[d.length-1];
            var img=$('#'+e).find(':file');
            var img_err=0;
            $.each(img,function () {
                if($.isEmptyObject($(this).val())){
                    $(this).parent().find('.valid_image').val('');
                    $(this).parent().find('.chkk').remove();
                }
                if($.isEmptyObject($(this).parent().find('.valid_image').val())){
                    img_err++;
                }
            });
            if (img_err!==0){
                $('.image_a_'+dd).css('border','1px solid red');
			}else {
                $('.image_a_'+dd).css('border','none');
			}
        }

        function changeImage(id) {
            $('#image_change_form')[0].reset();
            $('#image_change_form').find('.chkk').remove();
			var modal=$('#image_change_modal_0');
			$('#image_table_id').val(id);
			modal.modal();
        }

        function submitImgForm(e) {
			var form=$('#'+e);
			var val=form.find('input');
			var zs=0;
			val.each(function () {
				if ($.isEmptyObject($(this).val())) {
                    $(this).css('border','1px solid red');
                    $(this).parent().find('.chkk').remove();
                    $(this).parent().append('<span class="input-group-addon chkk" style="background-color: red; color: white; border: none"><i class="fa fa-ban"></i></span>');
                    $(this).parent().parent().parent().find('button').attr('disabled','disabled');
                    $(this).parent().find('.valid_image').val('');
				    zs++;
                }
            });
			if (zs===0)form.submit();

        }
    </script>
@endsection