@extends('layouts.front')

@section('title',$title)


@section('content')
        <!--details-->
<div class="container detailsDiv">
    <div class="row">
        <div class="col-md-12 detailsHeader">
            <h5><a href="{{url('/')}}">Home</a> / Product Details</h5>
        </div>
        <div class="col-md-6 imageDetails">
            <div class="row">
                <!--chng: Zoom image-->
                <div class="col-md-12">
                    <a id="zoom"
                       href="{{url('public/uploads/assets/frontend/images/products')}}/{{$product_details[0]->hasImage[0]->zoom_img}}"
                       class="MagicZoom" data-options="zoomPosition:inner; hint: always">
                        <img id="initial" class="img-thumbnail"
                             src="{{url('public/uploads/assets/frontend/images/products')}}/{{$product_details[0]->hasImage[0]->main_img}}"
                             alt="{{$product_details[0]->hasImage[0]->main_img}}">
                    </a>
                </div>
                <!--chng: Thumb image-->
                <div class="col-md-12" id="p_thum_div">
                    @foreach($product_details[0]->hasImage as $multiIMG)
                        <a onclick="changeZoom('{{$multiIMG->zoom_img}}','{{$multiIMG->main_img}}')">
                            <img src="{{url('public/uploads/assets/frontend/images/products')}}/{{$multiIMG->thum_img}}"
                                 alt="{{$multiIMG->thum_img}}"></a>
                    @endforeach
                </div>
                <!--product details-->
                <div id="wer" class="col-md-12 text-justify">
                    <?=$product_details[0]->description?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row">
                <!--Change: product name order-->
                <div class="col-md-12 productDetails">
                    <h3 id="productName">{{$product_details[0]->name.' - '.$product_details[0]->color.' " '.$product_details[0]->size.' " '}}</h3>
                    <h3><span class="hidden-sm-up">Price:</span>
                        @if($product_details[0]->quantity==0)
                            <span class="colorOut" id="productPrice">Out Of Stock</span>
                        @else
                            <span id="productPrice" class="txtLower">
                                @if($product_details[0]->is_discount==1)
                                    <i>${{$product_details[0]->price}} </i>&nbsp;
                                    ${{$product_details[0]->discount_price}}
                                @else
                                    ${{$product_details[0]->price}}
                                @endif
                        </span>
                        @endif

                    </h3>
                    <form id="addToCartForm" action="{{url('/addToCart')}}">
                        <div class="form-group">
                            <label for="color">Color: <span
                                        id="productClr">{{$product_details[0]->color}}</span></label><br>
                            @php
                            $getPrdctClrWise=$product_details->groupBy('color');
                            @endphp
                            @foreach($getPrdctClrWise as $clrVal)
                                <a onclick="changeImage({{$clrVal[0]}})">
                                    <img src="{{url('public/uploads/assets/frontend/images/products')}}/{{$clrVal[0]->hasImage[0]->color_img}}"
                                         alt="test">
                                </a>
                            @endforeach
                        </div>
                        <div class="form-group" id="productLabelDiv"
                             style="@if($clrVal[0]->is_accessories===0)display:none;@endif">
                            <label for="size">Size:</label><br>
                            @foreach($product_details as $row=> $val)
                                <label class="btn btn-info">
                                    <input type="radio" name="size" value="" autocomplete="off">{{$val->size}}
                                </label>
                            @endforeach
                        </div>
                        <div class="form-group">
                            <label for="quantity">Quantity</label>
                            <input min="1" class="form-control" type="number" name="quantity" id="quantity" value="1">
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                @if($product_details[0]->carrier_details=='')
                                @else
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Carier</th>
                                            <th>Compatibility Rating</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php
                                        $tmpCarrier=json_decode($product_details[0]->carrier_details);
                                        @endphp
                                        @foreach($tmpCarrier as $tC)
                                            <tr>
                                                <td>{{$tC->name}}</td>
                                                <td>{{$tC->description}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                        </div>
                        <input type="hidden" name="product_id" id="pro_id" value="{{$product_details[0]->id}}">
                        <input type="submit" value="Add to Cart" class="form-control btn btn-lg btn-info">
                        <div id="msg_div" class="mt-10" style="z-index: 5"></div>
                        <!-- <a href="cart.php" class="form-control btn btn-lg btn-info">Add to Cart</a> -->
                    </form>
                    <hr class="hr">
                </div>
                <div class="qqq">

                </div>
                <!-- product name order end-->

                <!-- RETURN & REFUND POLICY-->
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12 collapseA">
                            <hr class="hr hidden-md-up">
                            <a class="collapseDiv collapsed" role="button" data-toggle="collapse"
                               href="#rrp" aria-expanded="false">
                                <strong>RETURN & REFUND POLICY</strong>
                            </a>
                        </div>
                        <div class="col-md-12 collapse text-justify" id="rrp">
                            <p><?= $info[0]->description?> </p>
                        </div>
                    </div>
                    <hr class="hr">
                </div>
                <!-- RETURN & REFUND POLICY end-->
                <!-- SHIPPING INFO-->
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12 collapseA">
                            <a class="collapseDiv collapsed" role="button" data-toggle="collapse"
                               href="#si" aria-expanded="false">
                                <strong>SHIPPING INFO</strong>
                            </a>
                        </div>
                        <div class="col-md-12 collapse text-justify" id="si">
                            <p><?= $info[1]->description?> </p>
                        </div>
                    </div>
                    <hr class="hr">
                </div>
                <!--        SHIPPING INFO enf-->
                <!--                social icons-->
                <div class="col-md-12 social">
                    <a href=""><i class="fa fa-facebook-f"></i></a>
                    <a href=""><i class="fa fa-twitter"></i></a>
                    <a href=""><i class="fa fa-google-plus"></i></a>
                    <a href=""><i class="fa fa-pinterest-p"></i></a>
                </div>
                <!--                social icon ends-->
            </div>
        </div>
    </div>

</div>
<!--details end-->
<!--accessories-->
<div class="container sspImg">
    <h4>Related Products</h4>
    <div class="row" id="backup2">
        @foreach($accessories as $key=>$val)
            <a href="{{url(str_replace(' ','_',$val[0]->name).'/details/'.$val[0]->group_name)}}">
                <div class="col-md-3 col-xs-6 imageBox leave_img">
                    <div class="imageBox box leave_img">
                        <img id="prdct{{$val[0]->id}}" class="img-thumbnail leave_img"
                             src="{{url('public/uploads/assets/frontend/images/products/')}}/{{$val[0]->main_image}}"
                             @if(sizeof($val)>=2)
                             onmouseover="this.src='{{url('public/uploads/assets/frontend/images/products/')}}/{{$val[1]->main_image}}'"
                             onmouseout="this.src='{{url('public/uploads/assets/frontend/images/products/')}}/{{$val[0]->main_image}}'"
                             @endif
                             alt="1">


                        <div class="textBox text-center">
                            <a href="{{url(str_replace(' ','_',$val[0]->name).'/details/'.$val[0]->group_name)}}">QUICK
                                VIEW</a>
                        </div>
                        @if($val[0]->label!='')
                            <div class="textBoxTop {{$val[0]->label_css}}">
                                <p>{{$val[0]->label}}</p>
                            </div>
                        @endif
                    </div>
                    <div class="sspText">
                        <div class="txtUpper">
                            <p>{{$val[0]->name}}</p>
                        </div>
                        <hr>
                        <div class="txtLower">
                            <p>
                            @if($val[0]->quantity==0)
                                <p class="colorOut">Out Of Stock</p>
                            @else
                                @if($val[0]->is_discount==1)
                                    <i>${{$val[0]->price}} </i>&nbsp;
                                    ${{$val[0]->discount_price}}
                                @else
                                    ${{$val[0]->price}}
                                    @endif
                                    @endif
                                    </p>
                        </div>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
</div>
<!--accessories end-->
@endsection

@section('customJs')
    <script type="text/javascript" src="{{url('resources/assets/frontend')}}/magiczoom/magiczoom.js"></script>

    <script>
        var s_rc = '{{url("public/uploads/assets/frontend/images/products")}}/';
        function changeImage(prdct) {
            $('#pro_id').attr('value', prdct['id']);
            console.log(prdct);
            console.log(prdct['has_image'][0]['main_img']);
            console.log(prdct['id']);
            console.log(prdct.hasImage);
            //console.log(prdct['hasImage'][0]['main_img']);
            //console.log(prdct[0]['hasImage'][0]['zoom_img']);
            $('#productName').text(prdct['name'] + ' - ' + prdct['color'] + ' " ' + prdct['size'] + ' "');
            $('#productClr').text(prdct['color']);
            var tmpQty = prdct['quantity'];
            var Tprc = '';
            if (tmpQty == 0) {
                $('#productPrice').attr('class', 'colorOut');
                $('#productPrice').html('Out of Stock');
            } else {
                if (prdct['is_discount'] == 1) {
                    Tprc = '<i>$' + prdct['price'] + ' </i>&nbsp;' + '  $' + prdct['discount_price'] + '';
                } else {
                    Tprc = '$ ' + prdct['price'];
                }
                $('#productPrice').attr('class', 'txtLower');
                $('#productPrice').html(Tprc);
            }
            var zmImg = prdct['has_image'][0]['zoom_img'];
            var mainImg = prdct['has_image'][0]['main_img'];
            changeZoom(zmImg, mainImg);
        }

        function changeZoom(zmImg, mainImg) {
            var zoom = document.getElementById('zoom');
            MagicZoom.update('zoom', s_rc + zmImg, s_rc + mainImg);
        }
        $(document).ready(function () {
            if ($(window).width() < 700) {
                $('#wer').appendTo('.qqq');
            }
        });
    </script>
    <script>
        $("#addToCartForm").submit(function (event) {

            // Stop form from submitting normally
            event.preventDefault();

            // Get some values from elements on the page:
            var $form = $(this),
                    term = $form.find("input[name='product_id']").val(),
                    url = $form.attr("action");
            $.get(url, $form.serialize()).done(function (data) {
                console.log(data);
                var res = $.parseJSON(data);
                $('#cartTotal').text(res['count']);
                $('#msg_div').html('<div id="msg" class="alert alert-success"><p>' + res['message'] + '</p></div>').show();
                setTimeout(function () {
                    $("#msg").fadeOut();
                }, 3000);
            });

        });
    </script>
@endsection
@section('customCss')
    <link rel="stylesheet" href="{{url('resources/assets/frontend')}}/magiczoom/magiczoom.css">
@endsection