@extends('backend.layouts.app')

@section('dashboardRight')
    <li>
        <a href="#">
            <span>Product</span>
        </a>
    </li>
    <li>
        <a href="#">
            <span>Product List</span>
        </a>
    </li>
    <li>
        <a href="#">
            <span>Product Details</span>
        </a>
    </li>
@endsection

@section('content')
    <section class="panel">
        <header class="panel-heading">
            <h2 class="panel-title">{{$page_data[0]->name}}
                <p class="panel-subtitle">{{$page_data[0]->hasCategory->name}}</p></h2>
        </header>
        <div class="panel-body">
			<div class="row">
				<div class="col-xs-12 text-right" style="margin-bottom: 5px;">
					<a href="{{url('admin/product/create/'.$page_data[0]->group_name)}}" class="btn btn-primary">Add Product</a>
				</div>
			</div>
            @include('includes.flashMessage')
			<div class="table-responsive">
				<table class="table table-bordered">
					<thead>
					<tr>
						<th>#</th>
						<th>Image</th>
						{{-- <th>condition</th> --}}
						<th>Price</th>
						{{-- <th>size</th> --}}
						<th>color</th>
						<th>quantity</th>
						<th>action</th>
					</tr>
					</thead>
					<tbody>
					@foreach($page_data as $k=>$val)
						<tr>
							<td class="text-center">{{($k+1)}}</td>
							<td class="text-center"><img style="width: 30px; height: auto;" src="{{url('public/uploads/assets/frontend/images/products/'.$val->main_image)}}" alt="p_img_{{$k}}"></td>
							{{-- <td class="text-center">{{$val->product_condition}}</td> --}}
							<td><label class="label label-primary">${{$val->hasPrice[0]->price}}</label></td>
							{{-- <td><label class="label label-primary">{{$val->size}}</label></td> --}}
							<td><label class="label label-primary">{{$val->color}}</label></td>
							<td><label class="label label-primary">{{$val->quantity}}</label></td>
							<td class="text-center">
								@php
								if ($access==1) $url=url('admin/product/update/'.$val->id);
								else $url=url('admin/accessories/update/'.$val->id)
								@endphp
								<a href="{{url('admin/product_details_list/details/'.$val->p_code)}}" class="label label-info"><i class="fa fa-eye"></i></a>
								<a href="{{$url}}" class="label label-warning"><i class="fa fa-edit"></i></a>
							</td>
						</tr>
					@endforeach
					</tbody>
				</table>
			</div>
        </div>
    </section>
@endsection

@section('customJs')

@endsection
@section('customCss')
    <style>
        .colorSale {
            background: #c7432a;
        }

        .colorOut {
            color: red;
        }
		thead th{
			text-transform: uppercase;
			text-align: center;
		}
		tbody td{
			vertical-align: middle !important;
		}
    </style>
    <link rel="stylesheet" href="{{url('resources/assets/backend/vendor/dataTbl')}}/dataTables.bootstrap4.min.css">
@endsection