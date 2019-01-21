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
            <span>Add New @if($access===0) Accessories @else Product @endif</span>
        </a>
    </li>
@endsection

@section('content')
    <form id="productForm" action="" method="post" enctype="multipart/form-data">
        {{csrf_field()}}
		<input type="hidden" name="is_accessories" value="{{$access}}">
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
                            @if(!empty($product) && isset($product))
								<input required readonly type="text" class="form-control" id="product_name"
									   name="product_name"
									   value="{{$product->name}}">
								<input type="hidden" name="group_name" value="{{$product->group_name}}">
							@else
								<input required type="text" class="form-control" id="product_name"
									   name="product_name"
									   value="{{old('product_name')}}">
							@endif
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="product_category" class=""><b>Product Category</b></label>
                        <div>
                            @if(!empty($product) && isset($product))
                                <select id="product_category" name="product_category" class="form-control" required>
                                    <option value="{{$product->hasCategory->id}}" selected>{{$product->hasCategory->name}}</option>
                                </select>
								{{-- <input required readonly type="text" class="form-control" id="product_category"
									   name="product_category"
									   value="{{$product->hasCategory->name}}"> --}}
							@else
								<select id="product_category" onchange="getSubCategory(this)" name="product_category" class="form-control" required>
                                    @if ($categories)
                                        <option value="">select Category</option>
                                        @foreach ($categories as $item)
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                        @endforeach
                                    @else
                                        <option value="">No Category Found</option>
                                    @endif
								</select>
							@endif
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="product_sub_category" class=""><b>Product Sub-Category</b></label>
                        <div>
                            @if(!empty($product) && isset($product))
                                <select id="product_sub_category" name="product_sub_category" class="form-control" required>
                                    <option value="{{$product->hasSubCategory->id}}" selected>{{$product->hasSubCategory->name}}</option>
                                </select>
							@else
								<select id="product_sub_category" name="product_sub_category" class="form-control" required>
                                    <option value="">select a Category First</option>
								</select>
							@endif
                        </div>
                    </div>
                </div>
                <div style="margin-top: 2rem;">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped mb-none" id="example">
                            <thead>
                            <tr>
                                <th></th>
                                {{-- <th>Condition</th> --}}
                                <th>Size</th>
                                <th>Color</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Label</th>
                                <th>Image</th>
                                {{-- <th>Carrier</th> --}}
								<th>Description</th>
                            </tr>
                            </thead>
                            <tbody id="append_row">
                            <tr id="row_0">
                                <td class="text-center" style="width: 5%">
                                    <a role="button" onclick="appendRow()" class="label label-primary"><i class="fa fa-plus"></i></a>
                                </td>
                                {{-- <td style="width: 12%">
                                    <select name="condition[0]" id="condition_0" class="form-control">
                                        <option value="GRADE A">GRADE A</option>
                                        <option value="GRADE B">GRADE B</option>
                                        <option value="GRADE C">GRADE C</option>
                                    </select>
                                </td> --}}
                                <td style="width: 15%;">
                                    <input type="text" name="memory[0]" id="memory_0" placeholder="Size" class="form-control">
                                </td>
                                <td style="width: 15%">
                                    <input onkeypress="return forColor(event)" type="text" name="color[0]" id="color_0" placeholder="Color" class="form-control">
                                    <input type="text" name="condition[]" value="GRADE A" style="display:none;" placeholder="condition" class="form-control">
                                </td>
                                <td style="width: 15%">
                                    <input type="text" name="price[0][]" id="price_0" placeholder="Price" class="form-control">
                                    {{-- <a role="button" onclick="openPriceModal(0)" class="label label-primary price_a_0">Add</a> --}}
                                </td>
                                <td style="width: 15%">
                                    <input type="tel" onkeypress="return onlyNumber(event)" name="stock[0]" id="stock_0" placeholder="Stock" class="form-control">
                                </td>
                                <td style="width: 15%">
                                    <select id="label_0" name="product_label[0]" class="form-control">
                                        <option value="0">select label</option>
                                        <option value="LIMITED EDITION">LIMITED EDITION</option>
                                        <option value="NEW">NEW</option>
                                    </select>
                                </td>
                                <td align="center">
                                    <a role="button" onclick="openImageModal(0)" class="label label-primary image_a_0">Add</a>
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
                </div>
			</div>
			<div class="panel-footer text-center">
				<div class="row">
					<div id="errDiv" class="alert alert-danger" style="display: none;"></div>
				</div>
				<button type="button" onclick="validateForm()" class="btn btn-primary">Save</button>
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
											<input type="hidden" name="max_quantity[0][]" id="max_quantity_0_0" placeholder="max quantity" value="1" readonly>
										</td>
										<td><input onkeypress="return onlyNumber(event)" type="text" name="price[0][]" id="price_0_0" data-id="0" placeholder="price" class="form-control price"></td>
									</tr>
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
		<div id="image_modal_div">
			<div id="image_modal_0" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
				<div class="modal-dialog">
					<!-- Modal content-->
					<div class="modal-content">
						<div class="modal-body text-center" id="img_div_0">
							<h3>* Image dimension must be 1024x1280</h3>
							<img src="" id="img" alt="img_0" style="display: none">
							<div style="margin-bottom: 4px;" class="input-group">
								<span style="background-color: #0088cc; color: white; border: none; cursor: pointer;" onclick="addImageInput(0)" class="input-group-addon"><i class="fa fa-plus"></i></span>
								<input type="file" name="image[0][]" id="image_0_0" class="form-control bbb">
								<input type="hidden" name="valid_image[]" data-id="0" class="valid_image">
							</div>
						</div>
						<div class="modal-footer">
							<button onclick="chkImageModal('image_modal_0')" type="button" class="btn btn-default" data-dismiss="modal">Continue</button>
						</div>
					</div>

				</div>
			</div>
		</div>
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
									<tr>
										<td><a onclick="addCarrierInput(0)" role="button" class="label label-primary"><i class="fa fa-plus"></i></a></td>
										<td><input type="text" name="c_name[0][]" id="c_name_0_0" placeholder="Name" class="form-control carrier"></td>
										<td><input type="text" name="c_description[0][]" id="c_description_0_0" placeholder="Description" class="form-control carrier"></td>
									</tr>
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
							<textarea name="description[0]" placeholder="Product Description" class="textarea" id="description_0" cols="30" rows="10"></textarea>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Continue</button>
						</div>
					</div>

				</div>
			</div>
		</div>
    </form>
@endsection

@section('customJs')
	<script src="{{url('public/ckeditor/ckeditor.js')}}"></script>
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

        function appendRow() {
            var row=
							`<tr id="row_${i}">
                                <td class="text-center" style="width: 5%">
                                    <a role="button" onclick="removeRow(${i})" class="label label-danger"><i class="fa fa-times"></i></a>
                                </td>

                                <td style="width: 15%;">
                                    <input type="text" name="memory[${i}]" id="memory_${i}" placeholder="Memory" class="form-control">
                                </td>
                                
                                <td style="width: 15%">
                                    <input onkeypress="return forColor(event)" type="text" name="color[${i}]" id="color_${i}" placeholder="Color" class="form-control">
                                    <input type="text" name="condition[]" value="GRADE A" placeholder="condition" class="form-control" style="display:none;">
                                </td>
                                <td align="center">
                                    <input type="text" name="price[${i}][]" id="price_${i}" placeholder="Price" class="form-control">
                                </td>
                                <td style="width: 15%">
                                    <input type="tel" onkeypress="return onlyNumber(event)" name="stock[${i}]" id="stock_${i}" placeholder="Stock" class="form-control">
                                </td>
                                <td style="width: 15%">
                                    <select id="label_${i}" name="product_label[${i}]" class="form-control">
                                        <option value="0">select label</option>
                                        <option value="LIMITED EDITION">LIMITED EDITION</option>
                                        <option value="NEW">NEW</option>
                                    </select>
                                </td>
                                <td align="center">
                                    <a role="button" onclick="openImageModal(${i})" class="label label-primary image_a_${i}">Add</a>
                                    <label for="same_image_${i}">
                                    	<input type="checkbox" name="same_image[${i}]" id="same_image_${i}" onchange="sameImage(this,${i})">
                                    	S.A.B
									</label>
                                </td>
                                <td align="center">
									<a role="button" onclick="openDescriptionModal(${i})" class="label label-primary desc_a_${i}">Add</a>
									<label for="same_desc_${i}">
                                    	<input type="checkbox" name="same_desc[${i}]" id="same_desc_${i}" onchange="sameDescription(this,${i})">
                                    	S.A.B
									</label>
								</td>
                            </tr>`;
            $('#append_row').append(row);
            // appendPriceModal(i);
            appendImageModal(i);
            // appendCarrierModal(i);
            appendDescriptionModal(i);
			i++;
        }

        function removeRow(e) {
			$('#row_'+e).remove();
			$('#price_modal_'+e).remove();
            $('#image_modal_'+e).remove();
            $('#carrier_modal_'+e).remove();
            $('#description_modal_'+e).remove();
        }

        function appendPriceModal(flag) {
			var mod=
				`<div id="price_modal_${flag}" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
					<div class="modal-dialog">
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
									<tbody id="price_table_${flag}">
									<tr>
										<td><a onclick="addPriceInput(${flag})" role="button" class="label label-primary"><i class="fa fa-plus"></i></a></td>
										<td colspan="2">
											<input type="text" name="min_quantity[${flag}][]" id="min_quantity_${flag}_0" placeholder="min quantity" value="1" readonly class="form-control">
											<input type="hidden" name="max_quantity[${flag}][]" id="max_quantity_${flag}_0" placeholder="max quantity" value="1" readonly>
										</td>
										<td><input onkeypress="return onlyNumber(event)" type="text" name="price[${flag}][]" id="price_${flag}_0" data-id="${flag}" placeholder="price" class="form-control price"></td>
									</tr>
									</tbody>
								</table>
							</div>
                    		</div>
							<div class="modal-footer">
								<button onclick="chkPriceModal('price_modal_${flag}')" type="button" class="btn btn-default" data-dismiss="modal">Continue</button>
							</div>
                    	</div>
                    </div>
                </div>`;
			$('#price_modal_div').append(mod);
        }

        function appendImageModal(flag) {
            var mod=
                `<div id="image_modal_${flag}" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
					<div class="modal-dialog">
                    	<div class="modal-content">
                    		<div class="modal-body text-center" id="img_div_${flag}">
                    			<h3>* Image dimension must be 1024x1280</h3>
                    			<img style="display: none" src="" width="240" height="300" alt="img_${flag}">

                    			<div style="margin-bottom: 4px;" class="input-group">
									<span style="background-color: #0088cc; color: white; border: none; cursor: pointer;" onclick="addImageInput(${flag})" class="input-group-addon"><i class="fa fa-plus"></i></span>
									<input type="file" name="image[${flag}][]" id="image_${flag}_0" class="form-control bbb">
									<input type="hidden" name="valid_image[]" data-id="0" class="valid_image">
								</div>
                    		</div>
							<div class="modal-footer">
								<button onclick="chkImageModal('image_modal_${flag}')" type="button" class="btn btn-default" data-dismiss="modal">Continue</button>
							</div>
                    	</div>
                    </div>
                </div>`;
            $('#image_modal_div').append(mod);
        }

        function appendCarrierModal(flag) {
            var mod=
                `<div id="carrier_modal_${flag}" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
					<div class="modal-dialog">
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
									<tbody id="carrier_table_${flag}">
									<tr>
										<td><a onclick="addCarrierInput(${flag})" role="button" class="label label-primary"><i class="fa fa-plus"></i></a></td>
										<td><input type="text" name="c_name[${flag}][]" id="c_name_${flag}_0" placeholder="Name" class="form-control carrier"></td>
										<td><input type="text" name="c_description[${flag}][]" id="c_description_${flag}_0" placeholder="Description" class="form-control carrier"></td>
									</tr>
									</tbody>
								</table>
							</div>
                    		</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Continue</button>
							</div>
                    	</div>
                    </div>
                </div>`;
            $('#carrier_modal_div').append(mod);
        }

        function appendDescriptionModal(flag) {
			$('#description_modal_div').append(
			    `<div id="description_modal_${flag}" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
					<div class="modal-dialog">
                    	<div class="modal-content">
                    		<div class="modal-body">
                    			<textarea name="description[${flag}]" placeholder="Product Description" class="textarea" id="description_${flag}" cols="30" rows="10"></textarea>
                    		</div>
                    		<div class="modal-footer">
                    			<button type="button" class="btn btn-default" data-dismiss="modal">Continue</button>
                    		</div>
                    	</div>
                    </div>
				</div>`
			);
            CKEDITOR.replace('description_'+flag);

        }

        var price_count=1;
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
					<input type="file" name="image[${flag}][]" id="image_${flag}_${img_count}" class="form-control bbb">
					<input type="hidden" name="valid_image[]" data-id="0" class="valid_image">
				</div>`
			);
			img_count++;
        }
        var car_count=1;
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

        function samePrice(t, r) {
           if($(t).is(':checked')){
               $(t).parent().parent().find('a').hide();
               $('#price_table_'+r+' *').filter(':input').each(function () {
				   if(!$(this).is('[readonly]'))$(this).val(1);
               });
		   }else {
               $(t).parent().parent().find('a').show();
               $('#price_table_'+r+' *').filter(':input').each(function () {
                   if(!$(this).is('[readonly]'))$(this).val('');
               });
           }
        }

        function sameImage(t, r) {
            if($(t).is(':checked')){
                $(t).parent().parent().find('a').hide();
                $('#image_modal_'+r).find('.valid_image').val(1);
            }else {
                $(t).parent().parent().find('a').show();
                $('#image_modal_'+r).find('.valid_image').val('');
            }
        }

        function sameCarrier(t, r) {
            if($(t).is(':checked')){
                $(t).parent().parent().find('a').hide();
            }else $(t).parent().parent().find('a').show();
        }

        function sameDescription(t, r) {
            if($(t).is(':checked')){
                $(t).parent().parent().find('a').hide();
            }else $(t).parent().parent().find('a').show();
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

        function getSubCategory(e) {
            $cat=$(e);
            let val=$cat.val(),
                sub_cat=$('#product_sub_category');
            if ($.isEmptyObject(val)) {
                sub_cat.html(`<option value="">select a Category First</option>`)
            } else {
                $.ajax({
                    url:"{{url('admin/getSubCategory')}}/"+val,
                    type:'get',
                    success:function(json){
                        // console.log(json);
                        let option='<option value="">select a Sub-Category</option>'
                        $.each(json.sub_category, function(k, v) {
                            option+=`<option value="${v.id}">${v.name}</option>`
                        });
                        sub_cat.html(option);
                        
                    },
                    error:function(err){
                        console.error(err);
                        
                    }
                })
            }
            
        }
    </script>
@endsection