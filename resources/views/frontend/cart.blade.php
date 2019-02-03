@extends('layouts.front')
@section('title',$title)

@section('content')
    <div class="container-fluid">
        @include('includes.loading')
        @include('includes.flashMessage')
        <form id="form" onsubmit="return loading_func()" action="{{url('paypal')}}" method="post">
            <div class="row marginTop">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="{{url('/')}}"><h5>&lt; Continue Shopping</h5></a>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6 marginBottom">
                                    <button type="submit" class="btn btn-warning btn-custom ckout">Checkout with <span><img
                                                    src="{{asset('public/images/paypal.png')}}" alt="pay"></span>
                                    </button>
                                    {{--<a href="{{url('/payPal')}}" class="btn btn-warning btn-custom">Checkout With <span><img--}}
                                    {{--src="{{asset('public/images/paypal.png')}}"--}}
                                    {{--alt="pay"></span></a>--}}
                                </div>
                                <div class="col-md-6 marginBottom">
                                    {{-- <button type="submit" class="btn btn-info btn-custom ckout">Checkout</button> --}}
                                    <a href="{{url('/checkout')}}" class="btn btn-info btn-custom">Checkout</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{csrf_field()}}
            {{--<input type="hidden" name="amount" value="10">--}}
            <div class="row marginTop">
                <div class="col-md-12">
                    <div id="message"></div>
                    <table class="table">
                        <thead>
                        <tr>
                            <th class="width40 crtNum">My Cart ({{sprintf("%'.02d", Cart::count())}})</th>
                            <th class="width20 text-center">Price</th>
                            <th class="width20 text-center">Qty</th>
                            <th class="width20 text-right">Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach(Cart::Content() as $k=> $row)
                            <tr>
                                <td>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <img src="{{asset('public/uploads/assets/frontend/images/products')}}/{{$row->options->image}}"
                                                 alt="img" class="img-thumbnail border">
                                        </div>
                                        <div class="col-md-8">
                                            <input type="hidden" name="p_name[]" value="{{$row->name}}">
                                            <input type="hidden" name="p_amount[]" value="{{$row->price}}">
                                            <input type="hidden" name="p_qty[]" value="{{$row->qty}}">
                                            <input type="hidden" name="p_clr[]" value="{{$row->options->color}}">
                                            <input type="hidden" name="p_size[]" value="{{$row->options->size}}">
                                            <input type="hidden" name="p_code[]" value="{{$row->options->p_code}}">
                                            <h4>{{$row->name}}</h4>
                                            <p>Color: {{$row->options->color}}</p>
                                            <p>Size: {{$row->options->size}}</p>
                                            <a href="{{url('/rmv')}}/{{$row->rowId}}"><i class="remove">Remove</i></a>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center"><span><img class="taka" src="{{ url('public/images/taka.png') }}" alt="taka"></span> <span id="price{{$row->rowId}}">{{$row->price}}</span></td>
                                <td class="text-center">
                                    <div>
                                        <input min="1" onblur="updateCart(this.id,'{{$row->id}}',this.value)"
                                        		onkeyup="updateCart(this.id,'{{$row->id}}',this.value)"
                                        		onchange="updateCart(this.id,'{{$row->id}}',this.value)"
                                        id="{{$row->rowId}}" type="number" name="quantity" value="{{$row->qty}}" class="form-control quantity">
                                    </div>
                                </td>
                                <td class="text-right" id="t{{$row->rowId}}"><span><img class="taka" src="{{ url('public/images/taka.png') }}" alt="taka"></span>{{$row->price*$row->qty}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row marginTop marginBottom">
                <div class="col-md-7">
                    <div class="marginBottom">
                        <a data-toggle="collapse" data-target="#note"><i class="fa fa-sticky-note color"></i>&nbsp;
                            Add
                            a Note</a>
                    </div>
                    <div class="collapse" id="note">
                        <textarea name="note" id="" cols="40" rows="5"></textarea>
                    </div>
                </div>
                <div class="col-md-5">
                    <p><strong>Subtotal <span id="subTotal" class="pull-right"><span><img class="taka" src="{{ url('public/images/taka.png') }}" alt="taka"></span>{{Cart::subtotal()}}</span></strong></p>
                    <p><strong>Shipping <span class="pull-right"><span><img class="taka" src="{{ url('public/images/taka.png') }}" alt="taka"></span>{{$page_data->shipping_cost}}</span></strong></p>
                    <p><a href=""><i>bangladesh</i></a></p>
                    <hr class="hr">
                    <h4>Total <span id="sTotal"
                                    class="pull-right"><span><img class="taka" src="{{ url('public/images/taka.png') }}" alt="taka"></span>{{number_format((float)implode('',explode(',',Cart::subtotal()))+$page_data->shipping_cost,2)}}</span>
                    </h4>
                    <a href="{{url('/checkout ')}}" class="btn btn-info btn-custom marginBottom">Checkout</a>
                    {{--<a href="{{url('/payPal')}}" class="btn btn-warning btn-custom">Checkout with <span><img--}}
                    {{--src="{{asset('public/images/paypal.png')}}" alt="pay"></span></a>--}}
                    {{-- <button type="submit" class="btn btn-info btn-custom marginBottom ckout">Checkout</button> --}}
                    <button type="submit" class="btn btn-warning btn-custom ckout">Checkout with <span><img
                                    src="{{asset('public/images/paypal.png')}}" alt="pay"></span></button>

                </div>
            </div>
        </form>
    </div>
@endsection

@section('customJs')
    <script>
        function updateCart(rowId, id, val) {

            //console.log(rowId+'/'+id+'/'+val);
            $.ajax({

                type: "GET",
                url: "{{url('/updateCart')}}/" + rowId + '/' + id + '/' + val,
                success: function (data) {
                    var e = $.parseJSON(data);
                    //console.log($.parseJSON(data));
                    if (e['status'] === 'false') {
                        $('#' + rowId).val(e['qty']);
                        $('#message').html('<label class="alert alert-warning">We&apos;re sorry. You&apos;ve requested more than the ' + e["stock"] + ' available stocks.</label>').show().fadeOut(5000);
                        // setTimeout(function () {
                        //     $("#message").fadeOut();
                        // }, 3000);
                    }
                    else if(e['status']==='reload'){
                        location.reload();
                    }
                     else {
                        $('#t' + rowId).text('$' + e['total']);
                        $('#price'+rowId).text(e['new_price']);
                        $('#subTotal').text('$' + e['subTotal']);
                        $('.crtNum').text(e['count']);
                        $('#sTotal').text('$' + e['tTotal']);
                    }

                }
            });
        }
        function loading_func() {
             if($('#cartTotal').text()==='00') {
                 $('#progress').hide();
                 alert('Cart can not be empty');
                 return false;
             }else {
                 $('#progress').show();
                 return true;
             }

        }

    </script>
@endsection

@section('customCss')
@endsection