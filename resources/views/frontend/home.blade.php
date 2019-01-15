@extends('layouts.front')

@section('title',$title)

@section('content')


        <!--product container-->
<div class="container sspImg">
    <div class="row" id="backup">
        @foreach($products as $key=>$val)
            <a href="{{url(str_replace(' ','_',$val[0]->name).'/details/'.$val[0]->group_name)}}">
                <div class="col-md-3 col-xs-6 imageBox leave_img">
                    <div class="imageBox box leave_img">
                         <div class="loader"></div>
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
                                @if($val[0]->is_discount==1)
                                    <i>${{$val[0]->hasPrice[0]->price}} </i>&nbsp;
                                    ${{$val[0]->discount_price}}
                                @else
                                    ${{$val[0]->hasPrice[0]->price}}
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
</div>
<!--product container end-->

<!--accessories-->
<div class="container sspImg">
    <div class="row" id="backup2">
        @foreach($accessories as $key=>$val)
            <a href="{{url(str_replace(' ','_',$val[0]->name).'/details/'.$val[0]->group_name)}}">
                <div class="col-md-3 col-xs-6 imageBox leave_img">
                    <div class="imageBox box leave_img">
                         <div class="loader"></div>
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
    <script>
        $(document).ready(function () {

            $('#backup').mouseenter(function () {
                clearTimeout(myAni);
                console.log('call backup');
            });
            $('#backup2').mouseenter(function () {
                clearTimeout(myAni);
                console.log('call backup');
            });
            $('.leave_img').mouseleave(function () {
                clearTimeout(myAni);
            });
        });
        var myAni = '';
        function getProduct(grp, id) {
            $.ajax({
                type: 'post',
                url: baseUrl + '/getProduct',
                data: {
                    group: grp
                }, success: function (res) {
                    var tmp = [];
                    $.each(res, function (i, v) {
                        var newSrc = '{{url('public/uploads/assets/frontend/images/products/')}}/' + v['main_image'];
                        tmp.push(newSrc);
                    });
                    //console.log(tmp);
                    console.log(tmp.length);
                    if (tmp.length == 1) {
                    } else {
                        var i = 0;
                        console.log('in');
                        $("#" + id).fadeOut(40, function () {
                                $(this).attr('src', tmp[tmp.length-1])
                                        .fadeIn(40);
                            });
                       /* myAni = setInterval(function () {
                            console.log(i);
                            $("#" + id).fadeOut(40, function () {
                                $(this).attr('src', tmp[i])
                                        .fadeIn(40);
                            });
                            i++;
                            if (i >= tmp.length) {
                                i = 0;
                                clearTimeout(myAni);
                            }
                        }, 300);*/
                    }
                }
            });
        }
        function rmvPrdct(id, src) {
            clearTimeout(myAni);
            $('#'+id).attr('src', src);
        }


    </script>
@endsection
