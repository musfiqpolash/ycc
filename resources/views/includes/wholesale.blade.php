<script src="{{asset('resources/assets/frontend/js/jssor.slider-27.4.0.min.js')}}" type="text/javascript"></script>
<script type="text/javascript">
    jssor_1_slider_init = function () {

        var jssor_1_options = {
            $AutoPlay: 0,
            $AutoPlaySteps: 3,
            $SlideDuration: 160,
            $SlideWidth: 260,
            $SlideSpacing: 3,
            $Left:0,
            $ArrowNavigatorOptions: {
                $Class: $JssorArrowNavigator$,
                $Steps: 3
            },
            $BulletNavigatorOptions: {
                $Class: $JssorBulletNavigator$
            },
        };

        var jssor_1_slider = new $JssorSlider$("jssor_1", jssor_1_options);

        /*#region responsive code begin*/

        var MAX_WIDTH = 980;

        function ScaleSlider() {
            var containerElement = jssor_1_slider.$Elmt.parentNode;
            var containerWidth = containerElement.clientWidth;

            if (containerWidth) {

                var expectedWidth = Math.min(MAX_WIDTH || containerWidth, containerWidth);

                jssor_1_slider.$ScaleWidth(expectedWidth);
            }
            else {
                window.setTimeout(ScaleSlider, 30);
            }
        }

        ScaleSlider();

        $Jssor$.$AddEvent(window, "load", ScaleSlider);
        $Jssor$.$AddEvent(window, "resize", ScaleSlider);
        $Jssor$.$AddEvent(window, "orientationchange", ScaleSlider);
        /*#endregion responsive code end*/
    };
</script>
<style>
    /*jssor slider loading skin spin css*/

    #jssor_1 {
        /*box-shadow: 1px 1px 1px 1px #d4d4d4;*/
    }

    .jssorl-009-spin img {
        animation-name: jssorl-009-spin;
        animation-duration: 1.6s;
        animation-iteration-count: infinite;
        animation-timing-function: linear;
    }

    @keyframes jssorl-009-spin {
        from {
            transform: rotate(0deg);
        }
        to {
            transform: rotate(360deg);
        }
    }

    /*jssor slider bullet skin 057 css*/
    .jssorb057 {
        display: none !important;
    }

    .jssorb057 .i {
        position: absolute;
        cursor: pointer;
    }

    .jssorb057 .i .b {
        fill: none;
        stroke: #fff;
        stroke-width: 2000;
        stroke-miterlimit: 10;
        stroke-opacity: 0.4;
    }

    .jssorb057 .i:hover .b {
        stroke-opacity: .7;
    }

    .jssorb057 .iav .b {
        stroke-opacity: 1;
    }

    .jssorb057 .i.idn {
        opacity: .3;
    }

    /*jssor slider arrow skin 073 css*/
    .jssora073 {
        display: block;
        position: absolute;
        cursor: pointer;
    }

    .jssora073 .a {
        fill: #ddd;
        fill-opacity: .7;
        stroke: #000;
        stroke-width: 160;
        stroke-miterlimit: 10;
        stroke-opacity: .7;
    }

    .jssora073:hover {
        opacity: .8;
    }

    .jssora073.jssora073dn {
        opacity: .4;
    }

    .jssora073.jssora073ds {
        opacity: .3;
        pointer-events: none;
    }

    .ele-div {
        background-color: #effbff;
        font-size: 25px;
        font-weight: 700;
        border-right: 1px solid #a2c0c9;
        border-left: 1px solid #b1d0da;
        text-align: left;
        cursor: pointer;
        padding: 25px 20px;
        color: #3b3b3b;
    }

    .ele-div:hover, .ele-div:active {
        background-color: #ade7fb;
    }

    .ele-div h3 {
        border-bottom: 1px solid #939393;
    }

    .active-ele, .active-ele:hover, .active-ele:active {
        background-color: #0797d4;
        color: white;
    }

    .active-ele h3 {
        border-bottom: 1px solid white;
    }
</style>
@if(sizeof($priceInfo)<=3)
<div class="row" style="margin-left: 0px; margin-right: 0px;">
    @foreach($priceInfo as $key=>$val)
            <div class="ele-div @if($val->min_quantity<=$qty && $val->max_quantity>=$qty){{'active-ele'}}@endif" style="width:26.5%; height:62px; float:left; padding: 10px 10px;" onclick="">
                <!-- <img data-u="image" src="img/001.jpg" /> -->
                <div>
                    <label style="cursor:pointer; margin-top:0px;">
                        <input type="radio" name="wholesale" style="display: none;">
                        <h3 class="am-ount" style=" font-size: 14px; margin-bottom: 0px;"><b> {{ $val->min_quantity }} @if($key!=0)
                                   + @endif</b></h3>
                        <span style="font-size: 20px;"> ${{ $val->price }}</span>
                    </label>
                </div>
            </div>
        @endforeach
    </div>
@else
<div id="jssor_1"
     style="position:relative;margin:0 auto;top:0px;left:0px;width:980px;height:130px;overflow:hidden;visibility:hidden;">
    <!-- Loading Screen -->
    <div data-u="loading" class="jssorl-009-spin"
         style="position:absolute;top:0px;left:0px;width:100%;height:100%;text-align:center;background-color:rgba(0,0,0,0.7);">
        <img style="margin-top:-19px;position:relative;top:50%;width:38px;height:38px;"
             src="{{asset('resources/assets/frontend/images/spin.svg')}}"/>
    </div>
    <div data-u="slides" id="wholeSale"
         style="cursor:default;position:relative;top:0px;left:0px;width:980px;height:130px;overflow:hidden; background-color: #effbff; ">
        @foreach($priceInfo as $key=>$val)
            <div class="ele-div @if($val->min_quantity<=$qty && $val->max_quantity>=$qty){{'active-ele'}}@endif" onclick="">
                <!-- <img data-u="image" src="img/001.jpg" /> -->
                <div>
                    <label style="cursor:pointer; margin-top:0px;">
                        <input type="radio" name="wholesale" style="display: none;">
                        <h3 class="am-ount" style=""><b> {{ $val->min_quantity }} @if($key!=0)
                                    +@endif</b></h3>
                        <span style="font-size: 35px;"> ${{ $val->price }}</span>
                    </label>
                </div>
            </div>
        @endforeach
    </div>
    <!-- Bullet Navigator -->
    <div data-u="navigator" class="jssorb057" style="position:absolute;bottom:12px;right:12px;" data-autocenter="1"
         data-scale="0.5" data-scale-bottom="0.75">
        <div data-u="prototype" class="i" style="width:16px;height:16px;">
            <svg viewbox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
                <circle class="b" cx="8000" cy="8000" r="5000"></circle>
            </svg>
        </div>
    </div>
    <!-- Arrow Navigator -->
    <div data-u="arrowleft" class="jssora073" style="width:50px;height:50px;top:0px;left:30px;" data-autocenter="2"
         data-scale="0.75" data-scale-left="0.75">
        <svg viewbox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
            <path class="a"
                  d="M4037.7,8357.3l5891.8,5891.8c100.6,100.6,219.7,150.9,357.3,150.9s256.7-50.3,357.3-150.9 l1318.1-1318.1c100.6-100.6,150.9-219.7,150.9-357.3c0-137.6-50.3-256.7-150.9-357.3L7745.9,8000l4216.4-4216.4 c100.6-100.6,150.9-219.7,150.9-357.3c0-137.6-50.3-256.7-150.9-357.3l-1318.1-1318.1c-100.6-100.6-219.7-150.9-357.3-150.9 s-256.7,50.3-357.3,150.9L4037.7,7642.7c-100.6,100.6-150.9,219.7-150.9,357.3C3886.8,8137.6,3937.1,8256.7,4037.7,8357.3 L4037.7,8357.3z"></path>
        </svg>
    </div>
    <div data-u="arrowright" class="jssora073" style="width:50px;height:50px;top:0px;right:30px;" data-autocenter="2"
         data-scale="0.75" data-scale-right="0.75">
        <svg viewbox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
            <path class="a"
                  d="M11962.3,8357.3l-5891.8,5891.8c-100.6,100.6-219.7,150.9-357.3,150.9s-256.7-50.3-357.3-150.9 L4037.7,12931c-100.6-100.6-150.9-219.7-150.9-357.3c0-137.6,50.3-256.7,150.9-357.3L8254.1,8000L4037.7,3783.6 c-100.6-100.6-150.9-219.7-150.9-357.3c0-137.6,50.3-256.7,150.9-357.3l1318.1-1318.1c100.6-100.6,219.7-150.9,357.3-150.9 s256.7,50.3,357.3,150.9l5891.8,5891.8c100.6,100.6,150.9,219.7,150.9,357.3C12113.2,8137.6,12062.9,8256.7,11962.3,8357.3 L11962.3,8357.3z"></path>
        </svg>
    </div>
</div>
@endif
<script type="text/javascript">
    @if(sizeof($priceInfo)>3)
    jssor_1_slider_init();
    @endif

</script>
<!-- #endregion Jssor Slider End -->