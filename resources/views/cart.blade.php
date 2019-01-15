@extends('layout.master')
@section('content')
<!--content-->
<div class="container">
    <div class="row marginTop">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <a href=""><h5>&lt; Continue Shopping</h5></a>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-6 marginBottom">
                            <a href="" class="btn btn-warning btn-custom ckout">Checkout With <span><img src="images/paypal.png"
                                                                                                   alt="pay"></span></a>
                        </div>
                        <div class="col-md-6 marginBottom">
                            <a href="checkout.php" class="btn btn-info btn-custom ckout">Checkout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row marginTop">
        <div class="col-md-12">
            <table class="table">
                <thead>
                <tr>
                    <th class="width40">My Cart (2)</th>
                    <th class="width20 text-center">Price</th>
                    <th class="width20 text-center">Qty</th>
                    <th class="width20 text-right">Total</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>
                        <div class="row">
                            <div class="col-md-4">
                                <img src="images/1.png" alt="img" class="img-thumbnail border">
                            </div>
                            <div class="col-md-8">
                                <h4>Windows</h4>
                                <p>Color: Black</p>
                                <a href=""><i class="remove">Remove</i></a>
                            </div>
                        </div>
                    </td>
                    <td class="text-center">$399</td>
                    <td class="text-center">
                        <div>
                            <input type="number" name="quantity" value="1" class="form-control quantity" readonly>
                        </div>
                    </td>
                    <td class="text-right">$399</td>
                </tr>
                <tr>
                    <td>
                        <div class="row">
                            <div class="col-md-4">
                                <img src="images/1.png" alt="img" class="img-thumbnail border">
                            </div>
                            <div class="col-md-8">
                                <h4>Windows</h4>
                                <p>Color: Black</p>
                                <a href=""><i class="remove">Remove</i></a>
                            </div>
                        </div>
                    </td>
                    <td class="text-center">$399</td>
                    <td class="text-center">
                        <div>
                            <input type="number" name="quantity" value="1" class="form-control quantity" readonly>
                        </div>
                    </td>
                    <td class="text-right">$399</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="row marginTop marginBottom">
        <div class="col-md-7">
            <form action="">
                <div class="marginBottom" style="display: none">
                    <a data-toggle="collapse" data-target="#promo"><i class="fa fa-tag color"></i>&nbsp; Enter a promo code</a>
                </div>
                <div class="collapse marginBottom" id="promo">
                    <div class="input-group width60">
                        <input type="text" name="promo" class="form-control">
                        <div class="input-group-btn">
                            <button class="btn btn-default btn-lg">Apply</button>
                        </div>
                    </div>
                </div>
                <div class="marginBottom">
                    <a data-toggle="collapse" data-target="#note"><i class="fa fa-sticky-note color"></i>&nbsp; Add a Note</a>
                </div>
                <div class="collapse" id="note">
                    <textarea name="note" id="" cols="40" rows="5"></textarea>
                </div>
            </form>
        </div>
        <div class="col-md-5">
            <p><strong>Subtotal <span class="pull-right">$798</span></strong></p>
            <p><strong>Shipping <span class="pull-right">$15</span></strong></p>
            <p><a href=""><i>bangladesh</i></a></p>
            <hr class="hr">
            <h4>Total <span class="pull-right">$813</span></h4>
            <a href="checkout.php" class="btn btn-info btn-custom marginBottom ckout">Checkout</a>
            <a href="" class="btn btn-warning btn-custom ckout">Checkout with <span><img src="images/paypal.png" alt="pay"></span></a>

        </div>
    </div>
</div>
<!--content end-->
@endsection
