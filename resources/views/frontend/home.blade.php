@extends('layouts.front')

@section('title',$title)

@section('content')

{{-- sliders --}}
<div class="container">
    <div class="slider owl-carousel owl-theme">
        @foreach ($banners as $item)
            
        <div class="slider-item">
            <img src="{{ url('public/uploads/banner/'.$item->name) }}" alt="{{$item->name}}">
        </div>
        @endforeach
    </div>
</div>
{{-- sliders end --}}
<div class="container">
    <ul class="nav nav-tabs">
      <li role="presentation" class="tab active"><a href="#" onclick="event.preventDefault(); showDiv('featured')">Featured</a></li>
      <li role="presentation" class="tab"><a href="#" onclick="event.preventDefault(); showDiv('new')">New Arrival</a></li>
      <li role="presentation" class="tab"><a href="#" onclick="event.preventDefault(); showDiv('top_sale')">Top Sales</a></li>
    </ul>
    <div class="sspImg" id="featured">
        <div class="row">
            @foreach($featured as $key=>$val)
                <a href="{{url(str_replace(' ','_',$val->name).'/details/'.$val->group_name)}}">
                    <div class="col-md-3 col-sm-6 col-xs-12 imageBox leave_img">
                        <div class="imageBox box leave_img">
                             <div class="loader"></div>
                            <img id="prdct{{$val->id}}" class="img-responsive leave_img" src="{{url('public/uploads/assets/frontend/images/products/')}}/{{$val->main_image}}" alt="1">
    
    
                            <div class="textBox text-center">
                                <a href="{{url(str_replace(' ','_',$val->name).'/details/'.$val->group_name)}}">VIEW</a>
                            </div>
                            @if($val->label!='')
                                <div class="textBoxTop {{$val->label_css}}">
                                    <p>{{$val->label}}</p>
                                </div>
                            @endif
                        </div>
                        <div class="sspText">
                            <div class="txtUpper">
                                <p>{{$val->name}}</p>
                            </div>
                            <hr>
                            <div class="txtLower">
                                <p>
                                    @if($val->is_discount==1)
                                        <i>${{$val->hasPrice[0]->price}} </i>&nbsp;
                                        ${{$val->discount_price}}
                                    @else
                                        ${{$val->hasPrice[0]->price}}
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
    <div class="sspImg" id="new" style="display: none;">
        <div class="row">
            @foreach($new as $key=>$val)
                <a href="{{url(str_replace(' ','_',$val->name).'/details/'.$val->group_name)}}">
                    <div class="col-md-3 col-sm-6 col-xs-12 imageBox leave_img">
                        <div class="imageBox box leave_img">
                             <div class="loader"></div>
                            <img id="prdct{{$val->id}}" class="img-responsive leave_img" src="{{url('public/uploads/assets/frontend/images/products/')}}/{{$val->main_image}}" alt="1">
    
    
                            <div class="textBox text-center">
                                <a href="{{url(str_replace(' ','_',$val->name).'/details/'.$val->group_name)}}">VIEW</a>
                            </div>
                            @if($val->label!='')
                                <div class="textBoxTop {{$val->label_css}}">
                                    <p>{{$val->label}}</p>
                                </div>
                            @endif
                        </div>
                        <div class="sspText">
                            <div class="txtUpper">
                                <p>{{$val->name}}</p>
                            </div>
                            <hr>
                            <div class="txtLower">
                                <p>
                                    @if($val->is_discount==1)
                                        <i>${{$val->hasPrice[0]->price}} </i>&nbsp;
                                        ${{$val->discount_price}}
                                    @else
                                        ${{$val->hasPrice[0]->price}}
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</div>

<div class="container mb-50">
    <h3 class="brands">Top Brands</h3>
    {{-- brands --}}
    <div class="brand owl-carousel owl-theme">
        @foreach ($brands as $item)
            
        <div class="brand-item">
            <img src="{{ url('public/uploads/banner/'.$item->name) }}" alt="{{$item->name}}">
        </div>
        @endforeach
    </div>
{{-- brands end --}}
</div>
        <!--product container-->
{{-- <div class="container sspImg">
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
                            <a href="{{url(str_replace(' ','_',$val[0]->name).'/details/'.$val[0]->group_name)}}">VIEW</a>
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
</div> --}}
<!--product container end-->
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

        $('.slider').owlCarousel({
            margin:10,
            loop:true,
            items:1,
            autoplay:true,
            autoplayTimeout:5000,
            autoplayHoverPause:true,
            animateOut: 'fadeOut'
        });

        $('.brand').owlCarousel({
            margin:10,
            loop:true,
            autoplay:true,
            autoplayTimeout:5000,
            // autoplayHoverPause:false,
            animateOut: 'fadeOut',
            responsiveClass:true,
            responsive : {
                // breakpoint from 0 up
                0 : {
                    items:2,
                },
                // breakpoint from 480 up
                480 : {
                    items:4,
                },
                // breakpoint from 768 up
                768 : {
                    items:6,
                }
            }
        })

        function showDiv(e) {
            $('.sspImg').hide();
            $('.tab').removeClass('active');
            $('#'+e).show();
            event.target.parentElement.classList.add('active');
        }
    </script>
@endsection

@section('customCss')
    <style>
        .brands{
            position:relative;
        }

        .brands::after{
            content:"";
            position:absolute;
            top:50%;
            bottom:50%;
            left: 129px;
            right:0;
            border-top:1px solid #ccc;
            overflow:hidden;
        }

        .brand-item{
            border: 1px solid #ccc;
        }
        .brand-item img{
            padding: 11px;
        }
    </style>
@endsection