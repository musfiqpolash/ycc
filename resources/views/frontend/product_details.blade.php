@extends('layouts.front')
<style type="text/css">

    .mute-box {
        border: 1px dashed #0d0d0d !important;
        color: #000000 !important;
        opacity: 0.7;
    }

    .mute-box:hover, .mute-box:active
    {
         opacity: 1;
    }
    .activeImg img, #p_thum_div a img {
        border: 1px solid #dedede;
    }

    .activeImg img:hover, .activeImg img:focus, #p_thum_div a img:hover, #p_thum_div a img:focus {
        border: 1px solid #9c9c9c !important;
    }

    .aacc {
        border: 1px solid #0797d4 !important;
    }

    .condition-opt {
        background-color: white;
        /*border-color:black;*/
        color: #3b3b3b;
        border: 1px solid #cac7c7 !important;
    }

    .condition-opt:hover, .condition-opt:active {
        background-color: white;
        /*border-color:black;*/
        color: black;
        border: 1px solid #3b3b3b !important;
    }

    .active-condition {
        border: 1px solid #0797d4 !important;
        color: #0797d4 !important;
    }

    .active-condition:hover, .active-condition:active {
        border: 1px solid #0797d4 !important;
        color: #0797d4 !important;
    }

    .f-w-light {
        font-weight: 300;
        font-size: 15px;
    }

    .col-d.collapseDiv.collapsed:after {
        content: "\25b2";
        font-size: 9px;
        background-color: #5bc0de;
        padding: 5px 6px;
        font-weight: 700;
        border-radius: 40px;
        color: white;
    }

    .col-d.collapseDiv:after {
        content: "\25bc";
        font-size: 9px;
        background-color: #5bc0de;
        padding: 5px 6px;
        font-weight: 700;
        border-radius: 40px;
        color: white;
    }

    #addToCartForm .form-group {
        margin-bottom: 0px;
    }

</style>
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
                       href="{{url('public/uploads/assets/frontend/images/products')}}/{{$prdctInfo[0]->hasImage[0]->zoom_img}}"
                       class="MagicZoom" data-options="zoomPosition:inner; hint: always">
                        <div class="loader"></div>
                        <img id="initial" class="img-thumbnail"
                             src="{{url('public/uploads/assets/frontend/images/products')}}/{{$prdctInfo[0]->hasImage[0]->main_img}}"
                             alt="{{$prdctInfo[0]->hasImage[0]->main_img}}">
                    </a>
                </div>
                <!--chng: Thumb image-->
                <div class="col-md-12" id="p_thum_div">
                    @foreach($prdctInfo[0]->hasImage as $multiIMG)
                        <a onclick="changeZoom('{{$multiIMG->zoom_img}}','{{$multiIMG->main_img}}')">
                            <img src="{{url('public/uploads/assets/frontend/images/products')}}/{{$multiIMG->thum_img}}"
                                 alt="{{$multiIMG->thum_img}}"></a>
                    @endforeach
                </div>
                <!--product details-->
                <div id="wer" class="col-md-12 text-justify">
                    <?=$prdctInfo[0]->description?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row">
                <!--Change: product name order-->
                <div class="col-md-12 productDetails">
                    <h3 id="productName">{{$prdctInfo[0]->name.' - '.$prdctInfo[0]->color.' " '.$prdctInfo[0]->size.' " '}}</h3>
                    <h3><span class="hidden-sm-up f-w-light">Price:</span>
                        @if($prdctInfo[0]->quantity==0)
                            <span class="colorOut" id="productPrice">Out Of Stock</span>
                        @else
                            <span id="productPrice" class="txtLower" style="color: #af0000; font-weight: 700;">
                               ${{$prdctInfo[0]->hasSinglePrice->price}}
                            </span>
                        @endif
                    </h3>
                    <form id="addToCartForm" action="{{url('/addToCart')}}">
                        <!--condition start-->
                        <div class="form-group">
                            <label for="condition" style="margin-top:0px; margin-bottom: 2px;"><span class="f-w-light">Condition: </span><span
                                        id="gradeValueLabel">{{$activeGrade}}</span></label><br>
                            <div id="gradeValueDiv">
                                @foreach($condList as $key=> $val)
                                    <label onclick="getProductJson('cond_id','{{$val}}');"
                                           id="{{str_replace(' ','_',$val)}}"
                                           class="btn condition-opt mypops {{($activeGrade==$val?'active-condition':'')}}"
                                           style="margin-top: 0px; padding: 0px 6px 0.5px 6px;" title="<b>Grade {{explode(' ',$val)[1]}}</b>"
                                           @php
                                                $grade=explode(' ',$val)[1];
                                                $txt="";
                                                if($grade=='A')
                                                {
                                                     $txt="<ul>
                                                        <li>No crack</li>
                                                        <li>No chip</li>
                                                        <li>No watermark</li>
                                                        <li>No scratches</li>
                                                        <li>No major dent</li>
                                                        <li>Scratches less than 50%</li>
                                                        <li>No engraving or removed engraving</li>
                                                        <li>No visible scratches on screen</li>
                                                        <li>Very minimal signs of wear</li>
                                                     </ul>";
                                                }
                                                else if($grade=='B')
                                                {
                                                     $txt="<ul>
                                                        <li>No crack</li>
                                                        <li>Edge chip < 2.0mm acceptable</li>
                                                        <li>Visible scratches acceptable </li>
                                                        <li>Water mark no bigger than a dime acceptable</li>
                                                        <li>Minor dent</li>
                                                        <li>Removed engraving acceptable</li>
                                                        <li>will show some signs of wear</li>
                                                     </ul>";
                                                }
                                                else if($grade=='C')
                                                {
                                                     $txt="<ul>
                                                        <li>No crack</li>
                                                        <li>Edge chip < 5.0mm acceptable</li>
                                                        <li>Visible scratches </li>
                                                        <li>Possible dent</li>
                                                        <li>will show heavy signs of wear</li>
                                                     </ul>";
                                                }

                                           @endphp

                                            data-content="{{ $txt }}" data-placement="bottom" data-html="true" >
                                        Grade <span
                                                style="font-size: 25px; font-weight: 700;">{{explode(' ',$val)[1]}}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        <!--condition end-->

                        <!--size start-->
                        <div class="form-group">
                            <label for="size" style=" margin-bottom: 2px;"><span class="f-w-light">Memory: </span><span
                                        id="sizeValueLabel">{{$activeSize}}</span></label><br>
                            <div id="sizeValueDiv">
                                @foreach($sizeList as $key=> $val)
                                    <label onclick="getProductJson('size_id','{{$val}}')"
                                           id="{{str_replace(' ','_',$val)}}"
                                           class="btn condition-opt {{($activeSize==$val?'active-condition':'')}} "
                                           style="margin-top: 0px;  padding: 3px 9px;">
                                        <b style="font-size:17px;">{{$val}}</b>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        <!--size end-->
                        <!--color start-->
                        <div class="form-group">
                            <label for="size" style=" margin-bottom: 2px;"><span class="f-w-light">Color: </span><span
                                        id="colorValueLabel">{{$activeColor}}</span></label><br>
                            <div id="colorValueDiv">
                                @foreach($colorList as $key=> $val)
                                    <a onclick="getProductJson('color_id','{{$val['color']}}')" class="activeImg ">
                                        <img id="{{str_replace(' ','_',$val['color'])}}"
                                             class="{{($activeColor==$val['color']?'aacc':'')}} "
                                             src="{{url('public/uploads/assets/frontend/images/products')}}/{{$val['color_img']}}"
                                             alt="test">
                                    </a>
                                @endforeach
                            </div>
                        </div>
                        <!--color end-->

                        <!--price start-->
                        <div class="form-group">
                            <label for="wholesale" style=" margin-bottom: 2px;"><span
                                        class="f-w-light">Wholesale Price (Piece):</span><span
                                        id="priceValuelabel">  ${{$prdctInfo[0]->hasSinglePrice->price}}</span></label><br>
                            <div id="wholesaleDiv">
                                @include('includes.wholesale',['priceInfo'=>$prdctInfo[0]->hasPriceList,'qty'=>1])
                            </div>

                        </div>
                        <!--price end-->


                        <!--quantity start-->
                        <div class="form-group">
                            <label for="quantity" style=" margin-bottom: 2px;"><span class="f-w-light">Quantity: </span></label>
                            <input min="1" onblur="chk(this.id)" onchange="chk(this.id)" onkeyup="chk(this.id)"
                                   class="form-control" type="number" name="quantity" id="quantity" value="1"
                                   style="font-weight: 700; font-size:17px;">
                        </div>
                        <!--quantity end-->
                        <!--Carrier start-->
                        <div class="row">
                            <div class="col-md-12">
                                @if($prdctInfo[0]->carrier_details=='')
                                @else
                                    <table class="table table-bordered" style="margin-top:8px;">
                                        <thead>
                                        <tr>
                                            <th>Carrier</th>
                                            <th>Compatibility Rating</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php
                                        $tmpCarrier=json_decode($prdctInfo[0]->carrier_details);
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
                        <!--Carrier end-->

                        <input type="hidden" name="product_id" id="pro_id" value="{{$prdctInfo[0]->id}}">
                        <input type="hidden" name="group_id" id="group_id" value="{{$prdctInfo[0]->group_name}}">
                        <input type="hidden" name="size_id" id="size_id" value="{{$prdctInfo[0]->size}}">
                        <input type="hidden" name="cond_id" id="cond_id" value="{{$prdctInfo[0]->product_condition}}">
                        <input type="hidden" name="color_id" id="color_id" value="{{$prdctInfo[0]->color}}">
                        <input type="submit" value="Add to Cart" class="form-control btn btn-lg btn-info"
                               style="margin-top: 8px;">
                        <div id="msg_div" class="mt-10" style="z-index: 5"></div>
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
                                    <i>${{$val[0]->hasSinglePrice->price}} </i>&nbsp;
                                    ${{$val[0]->discount_price}}
                                @else
                                    ${{$val[0]->hasSinglePrice->price}}
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
        document.addEventListener("DOMContentLoaded", function (event) {

            // changeWhole();
        });

        function rmvArrow()
        {
            var clas = document.getElementsByClassName('ele-div');
            if (clas.length <= 3) {
                var arrow = document.getElementsByClassName('jssora073');
                for (var i = 0; i < arrow.length; i++) {
                    // console.log(arrow[i]);
                    arrow[i].remove();
                }
                for (var i = 0; i < arrow.length; i++) {
                    // console.log(arrow[i]);
                    arrow[i].remove();
                }
            }
        }
        function choice(element) {
            var clas = document.getElementsByClassName('ele-div');
            for (var i = 0; i < clas.length; i++) {

                clas[i].classList.remove("active-ele");
            }
            var ele = document.getElementById(element.id);
            ele.classList.add("active-ele");
        }

        function changeWhole() {
             rmvArrow();
             var clas = document.getElementsByClassName('ele-div');
             var wholeEle=document.getElementById('wholeSale');
             if(clas.length==1)
             {
                clas[0].closest('#wholeSale > div').style.left=0;
             }
             else if(clas.length==2)
             {
               clas[0].closest('#wholeSale > div').style.left=0;
               clas[1].closest('#wholeSale > div').style.left=clas[0].offsetWidth;
             }
             else if(clas.length==3)
             {
                clas[0].closest('#wholeSale > div').style.left=0;
                clas[1].closest('#wholeSale > div').style.left=clas[0].offsetWidth;
                clas[2].closest('#wholeSale > div').style.left=clas[0].offsetWidth+clas[1].offsetWidth;
             }

            var check=0;
            for (var i = 0; i < clas.length; i++) {
                if(clas[i].classList.contains("active-ele"))
                {
                    check=1;
                }
            }

            if(check==0)
            {
               var firstEle= wholeEle.children[0].children[1];
               firstEle.classList.add("active-ele");
            }

        }
        function getProductJson(iid, val) {
            console.log('iid=' + iid);
            if (iid == 'qty') {
                var wise = 'cond';

            } else {
                $('#' + iid).val(val);
                var wise = iid.split('_')[0];
            }
            var grp = $('#group_id').val();
            var cnd = $('#cond_id').val();
            var size = $('#size_id').val();
            var color = $('#color_id').val();
            var qty = $('#quantity').val();
            console.log(grp+cnd+size+color+qty);
            $.ajax({
                url: '{{url("getProductJson")}}',
                data: {
                    grp: grp,
                    cnd: cnd,
                    size: size,
                    color: color,
                    wise: wise,
                    qty: qty
                }, success: function (res) {
                    console.log(res);
                    var res_data=res.prdctInfo;
                    var tempData='';
                    $.each(res_data,function(i,v){
                        tempData=v;
                    });
                    console.log(tempData);
                     $('#pro_id').val(tempData.id);
                    $('#group_id').val(tempData.group_name);
                    $('#cond_id').val(tempData.product_condition);
                    $('#size_id').val(tempData.size);
                    $('#color_id').val(tempData.color);

                    $('#productPrice').text('$' + tempData.has_single_price.price);
                    $('#priceValuelabel').text('$' + tempData.has_single_price.price);
                    if (tempData.has_price.length!=0 && tempData.has_price[0].price) {
                        $('#productPrice').text('$' + tempData.has_price[0].price);
                        $('#priceValuelabel').text('$' + tempData.has_price[0].price);
                    }

                    $('#productName').text(tempData.name + ' - ' + tempData.color + ' " ' + tempData.size + ' "');

                    $('#colorValueLabel').text(tempData.color);
                    $('#sizeValueLabel').text(tempData.size);
                    $('#gradeValueLabel').text(tempData.product_condition);

                    $('#gradeValueDiv').find('label').removeClass('active-condition');
                    var tmp = tempData.product_condition.replace(' ', '_');
                    $('#' + tmp).addClass('active-condition');

                    $('#sizeValueDiv').find('label').removeClass('active-condition');
                    var tmp = tempData.size.replace(' ', '_');
                    $('#' + tmp).addClass('active-condition');

                    $('#colorValueDiv').find('img').removeClass('aacc');
                    var tmp = tempData.color.replace(' ', '_');
                    $('#' + tmp).addClass('aacc');

                    var zmImg = tempData.has_image[0].zoom_img;
                    console.log(zmImg);
                    var mainImg = tempData.has_image[0].main_img;
                    changeZoom(zmImg, mainImg);

                    $('#p_thum_div').children().remove();

                    $.each(tempData.has_image, function (key, value) {
                        //console.log(value['id']);
                        var zi = '"' + value['zoom_img'] + '"';
                        var mi = '"' + value['main_img'] + '"';
                        $('#p_thum_div').append(
                                "<a onclick='changeZoom(" + zi + "," + mi + ")'>" +
                                "<img src='" + s_rc + value['thum_img'] + "'>" +
                                "</a>"
                        );
                    });
                    var priceInfo = JSON.stringify(tempData.has_price_list);
                    $('#wholesaleDiv').load('{{url("getPriceListLoad")}}', {"priceInfo[]": priceInfo, "qty": qty});
                    /*
                    $('#pro_id').val(res.prdctInfo[0].id);
                    $('#group_id').val(res.prdctInfo[0].group_name);
                    $('#cond_id').val(res.prdctInfo[0].product_condition);
                    $('#size_id').val(res.prdctInfo[0].size);
                    $('#color_id').val(res.prdctInfo[0].color);

                    $('#productPrice').text('$' + res.prdctInfo[0].has_single_price.price);
                    $('#priceValuelabel').text('$' + res.prdctInfo[0].has_single_price.price);
                    if (res.prdctInfo[0].has_price.length!=0 && res.prdctInfo[0].has_price[0].price) {
                        $('#productPrice').text('$' + res.prdctInfo[0].has_price[0].price);
                        $('#priceValuelabel').text('$' + res.prdctInfo[0].has_price[0].price);
                    }

                    $('#productName').text(res.prdctInfo[0].name + ' - ' + res.prdctInfo[0].color + ' " ' + res.prdctInfo[0].size + ' "');

                    $('#colorValueLabel').text(res.prdctInfo[0].color);
                    $('#sizeValueLabel').text(res.prdctInfo[0].size);
                    $('#gradeValueLabel').text(res.prdctInfo[0].product_condition);

                    $('#gradeValueDiv').find('label').removeClass('active-condition');
                    var tmp = res.prdctInfo[0].product_condition.replace(' ', '_');
                    $('#' + tmp).addClass('active-condition');

                    $('#sizeValueDiv').find('label').removeClass('active-condition');
                    var tmp = res.prdctInfo[0].size.replace(' ', '_');
                    $('#' + tmp).addClass('active-condition');

                    $('#colorValueDiv').find('img').removeClass('aacc');
                    var tmp = res.prdctInfo[0].color.replace(' ', '_');
                    $('#' + tmp).addClass('aacc');

                    var zmImg = res.prdctInfo[0].has_image[0].zoom_img;
                    console.log(zmImg);
                    var mainImg = res.prdctInfo[0].has_image[0].main_img;
                    changeZoom(zmImg, mainImg);

                    $('#p_thum_div').children().remove();

                    $.each(res.prdctInfo[0].has_image, function (key, value) {
                        //console.log(value['id']);
                        var zi = '"' + value['zoom_img'] + '"';
                        var mi = '"' + value['main_img'] + '"';
                        $('#p_thum_div').append(
                                "<a onclick='changeZoom(" + zi + "," + mi + ")'>" +
                                "<img src='" + s_rc + value['thum_img'] + "'>" +
                                "</a>"
                        );
                    });
                    var priceInfo = JSON.stringify(res.prdctInfo[0].has_price_list);
                    $('#wholesaleDiv').load('{{url("getPriceListLoad")}}', {"priceInfo[]": priceInfo, "qty": qty});*/
                }
            });
            // changeWhole();
        }
    </script>
    <script>
        var s_rc = '{{url("public/uploads/assets/frontend/images/products")}}/';

        function changeZoom(zmImg, mainImg) {
            var zoom = document.getElementById('zoom');
            MagicZoom.update('zoom', s_rc + zmImg, s_rc + mainImg);
        }
        $(document).ready(function () {
            if ($(window).width() < 700) {
                $('#wer').appendTo('.qqq');
            }
        });



        $("#addToCartForm").submit(function (event) {

            // Stop form from submitting normally
            event.preventDefault();

            // Get some values from elements on the page:
            var $form = $(this),
                    term = $form.find("input[name='product_id']").val(),
                    url = $form.attr("action");
            $.get(url, $form.serialize()).done(function (data) {
//                console.log(data);
                var res = $.parseJSON(data);
                $('#cartTotal').text(res['count']);
                $('#msg_div').html('<div id="msg" class="alert alert-success"><p>' + res['message'] + '</p></div>').show();
                setTimeout(function () {
                    $("#msg").fadeOut();
                }, 3000);
            });

        });

        $(function(argument) {
            $(".mypops").popover({ trigger: "hover" });
        });

        function chk(e) {
            var val = $('#' + e).val();
            var a = 1;
            if (val < a) {
                $('#' + e).val(a);
            }
//            getProductJson('qty','');
        }


    </script>
@endsection
@section('customCss')
    <link rel="stylesheet" href="{{url('resources/assets/frontend')}}/magiczoom/magiczoom.css">
    <style>
        .aacc {
            border: 1px solid;
        }
    </style>
@endsection