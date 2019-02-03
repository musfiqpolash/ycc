@extends('layouts.front')
@section('title',$title)

@section('content')
    <!--content-->
    <div class="container marginBottom">
        @include('includes.loading')
        <div class="row marginTop">
            <div id="lower" class="col-md-5 col-md-push-7 backgroundGrey sticky">
                <h4 class="pt-10">Order Summery</h4>
                <div class="row orderSummery">
                    <div class="col-md-12">
                        @foreach(Cart::Content() as $k=> $row)
                            <div class="row marginBottom">
                                <div class="col-md-4 col-xs-4">
                                    <img src="{{asset('public/uploads/assets/frontend/images/products')}}/{{$row->options->image}}" alt="1" class="img-thumbnail">
                                </div>
                                <div class="col-md-6 col-xs-6">
                                    <p>{{$row->name}}</p>
                                    <p>Qty: {{$row->qty}}</p>
                                    <p>Color: {{$row->options->color}}</p>
                                </div>
                                <div class="col-md-2 col-xs-2">
                    <span class="pull-right">
                        ${{$row->price*$row->qty}}
                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="row marginBottom">
                    <div class="col-md-12">
                        <hr class="hr">
                    </div>
                    <div class="col-md-12">
                        <p>Subtotal <span class="pull-right">${{Cart::subtotal()}}</span></p>
                        <p>Shipping <span class="pull-right">${{$page_data->shipping_cost}}</span></p>
                        {{--<p>Sales Tax <span class="pull-right">$3.90</span></p>--}}
                        <h4><b>Total <span class="pull-right">${{number_format((float)implode('',explode(',',Cart::subtotal()))+$page_data->shipping_cost,2)}}</span></b></h4>
                    </div>
                </div>
            </div>
            <div id="upper" class="col-md-7 col-md-pull-5">
                <form onsubmit="loading_func()" id="form" action="" method="POST">
                    {{ csrf_field() }}
                    <h3>1. Shipping Details <span class="pull-right edit1"><small><a
                                        class="color">Edit</a></small></span></h3>
                    <div class="row shipDetail">
                        <div class="col-md-12">
                            <label for="email">*Email for Order Information</label>
                            <div>
                                <input type="email" readonly class="form-control" id="email" name="email" value="{{auth('client')->user()->email}}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="firstName">*First Name</label>
                            <div>
                                <input type="text" class="form-control" id="firstName" name="firstName" value="{{auth('client')->user()->first_name}}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="lastName">*Last Name</label>
                            <div>
                                <input type="text" class="form-control" id="lastName" name="lastName" value="{{auth('client')->user()->last_name}}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="address">*Address</label>
                            <div>
                                <input type="text" class="form-control" id="address" name="address">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="city">*City</label>
                            <div>
                                <input type="text" class="form-control" id="city" name="city">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="country">*Country</label>
                            <div>
                                <input type="text" class="form-control" id="country" name="country">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="zip">*Zip / Postal Code</label>
                                    <div>
                                        <input type="text" name="zip" id="zip" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="phone">*Phone</label>
                                    <div>
                                        <input type="text" name="phone" id="phone" class="form-control" value="{{auth('client')->user()->phone}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 marginBottom marginTop">
                            <a id="con" class="btn btn-info form-control btn-lg">Continue</a>
                        </div>
                    </div>
                    <div class="row shipReview">
                        <div class="col-md-12">
                            <p id="sName"></p>
                            <p id="sEmail"></p>
                            <p id="sAddress"></p>
                            <p id="sPhone"></p>
                            <hr class="hr">
                        </div>
                    </div>

                    <h3>2. Delivery Method<span class="pull-right edit2"><small><a class="color">Edit</a></small></span>
                    </h3>
                    <div class="row deliveryDetails">
                        <div class="col-md-12">
                            <div class="radio">
                                <label for="deliveryMethod">
                                    <input checked type="radio" name="deliveryMethod" id="deliveryMethod"
                                           value="standard shipping">
                                    standard shipping
                                </label>
                                <span class="pull-right">${{$page_data->shipping_cost}}</span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <a id="con1" class="btn btn-info form-control btn-lg">Continue</a>
                        </div>
                    </div>
                    <div class="row deliveryReview">
                        <div class="col-md-12">
                            <p>standard shipping ${{$page_data->shipping_cost}}</p>
                        </div>
                    </div>
                    <hr class="hr">

                    <h3>3. Payment<span class="pull-right edit3"><small><a class="color">Edit</a></small></span></h3>
                    <div class="row paymentDetails">
                        <div class="col-md-12">
                            <div class="radio">
                                <label for="credit">
                                    <input checked type="radio" name="payment" id="credit" value="cash on delivery">
                                    Cash On Delivery
                                </label>
                                {{-- <span class="pull-right"><img src="{{url('public/images/creditCard.svg')}}"
                                                              alt="credit card"></span> --}}
                            </div>
                            {{-- <div class="radio">
                                <label for="paypal">
                                    <input type="radio" name="payment" id="paypal" value="paypal">
                                    PayPal
                                </label>
                                <span id="paypalImg" class="pull-right"><img src="{{url('public/images/payPal.svg')}}"
                                                                             alt="payPal"></span>
                            </div> --}}
                        </div>
                        <div class="col-md-12 marginTop marginBottom creditInfo">
                            {{-- <h4>Payment Information</h4>
                            <div class="form-group">
                                <label for="cc-number" class="control-label">Card number
                                    <small class="text-muted">[<span class="cc-brand"></span>]</small>
                                </label>
                                <input id="cc-number" type="tel" class="input-lg form-control cc-number"
                                       name="cc_number" autocomplete="cc-number" placeholder="•••• •••• •••• ••••">
                            </div>

                            <div class="form-group">
                                <label for="cc-exp" class="control-label">Card expiry date</label>
                                <input id="cc-exp" type="tel" class="input-lg form-control cc-exp" autocomplete="cc-exp"
                                       name="cc_exp" placeholder="•• / ••">
                            </div>

                            <div class="form-group">
                                <label for="cc-cvc" class="control-label">Card CVC</label>
                                <input id="cc-cvc" type="tel" class="input-lg form-control cc-cvc" autocomplete="off"
                                       name="cc_cvc" placeholder="•••">
                            </div>

                            <div class="form-group">
                                <label for="holderName" class="control-label">Card Holder name</label>
                                <input id="holderName" type="text" class="input-lg form-control" data-numeric>
                            </div> --}}

                            <div class="form-group">
                                <h4>Billing Address</h4>
                                <label for="check" class="control-label">
                                    <input id="check" type="checkbox" name="same_address" value="true" class="" checked>Same as Shipping Address
                                </label>

                            </div>
                            <div class="billingAddress">
                                <div class="form-group">
                                    <label for="bfirstName">*First Name</label>
                                    <div>
                                        <input type="text" class="form-control" id="bfirstName" name="bfirstName">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="blastName">*Last Name</label>
                                    <div>
                                        <input type="text" class="form-control" id="blastName" name="blastName">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="baddress">*Address</label>
                                    <div>
                                        <input type="text" class="form-control" id="baddress" name="baddress">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="bcity">*City</label>
                                    <div>
                                        <input type="text" class="form-control" id="bcity" name="bcity">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="bcountry">*Country</label>
                                    <div>
                                        <input type="text" class="form-control" id="bcountry" name="bcountry">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="bzip">*Zip / Postal Code</label>
                                            <div>
                                                <input type="text" name="bzip" id="bzip" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="bphone">*Phone</label>
                                            <div>
                                                <input type="text" name="bphone" id="bphone" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>

                        <div class="col-md-12 marginTop marginBottom paypalInfo text-justify">
                            <h4>Pay with PayPal</h4>
                            <p>When you hit "Place Order" you will be redirected to PayPal where you can complete your
                                purchase securely.</p>
                        </div>
                        <div class="col-md-12">
                            <a id="con2" class="btn btn-info form-control btn-lg">Continue</a>
                        </div>
                    </div>
                    <div class="row paymentReview">
                        <div class="col-md-12">
                            <p>Payment Method: Cash On Delivery</p>
                            <p id="pName"></p>
                            <p id="pEmail"></p>
                            <p id="pAddress"></p>
                            <p id="pPhone"></p>
                        </div>
                    </div>
                    <hr class="hr">

                    <h3>4. Review & Place Order</h3>
                    <div class="row orderReview">
                        <div class="col-md-12">
                            <p>Please review the order details above, and when you're ready, click Place Order.</p>
                        </div>
                        <div class="col-md-12">
                            <a id="con3" class="btn btn-info form-control btn-lg">Place Order</a>
                        </div>
                    </div>
                </form>
                <div class="well text-center warning-div">
                    <h4>There is a problem with your payment</h4>
                    <p>We weren't able to process your transaction. Please review your payment details and try again in
                        a few minutes.</p>
                    <a id="close" class="btn btn-info">Close</a>
                </div>
            </div>
        </div>
    </div>
    <!--content end-->
@endsection

@section('customJs')
    <script src="{{asset('resources/assets/frontend/js/jquery.validate.js')}}"></script>
    <script src="{{asset('resources/assets/frontend/js/validation.js')}}"></script>
    <script src="{{asset('resources/assets/frontend/js/jquery.payment.js')}}"></script>
    <script src="{{asset('resources/assets/frontend/js/checkout.js')}}"></script>
    <script>
        function loading_func() {
            $('#progress').show();
        }
    </script>
@endsection

@section('customCss')
@endsection