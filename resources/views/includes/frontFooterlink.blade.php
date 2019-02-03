<script src="{{url('resources/assets/frontend')}}/js/jquery-3.3.1.min.js"></script>
<script src="{{url('resources/assets/frontend')}}/js/bootstrap.min.js"></script>
<script src="{{ url('/public/OwlCarousel/owl.carousel.min.js') }}"></script>
<script>


		$('img').on("load",function(){
            console.log($(this).siblings('.loader'));
            $(this).siblings('.loader').fadeOut('slow');
        });

        $('.ckout').click(function() {
            /* Act on the event */
            $('.wrapper').fadeIn(500);
            // setTimeout(function() {
            //     $('.wrapper').remove();
            // }, 510);
        });

         $(window).on("load",function(){
            $('.loader').fadeOut('slow');
        });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var baseUrl=$('#base_url').val();

    var owl = $('#menu-owl');
    owl.owlCarousel({
        // loop:true,
        autoWidth:true,
        responsiveClass:true,
        responsive:{
            0:{
                nav:true
            },
            600:{
                nav:false
            }
        }
    });
    $(window).on('load',function(){
        fixOwlMargin();
        positionFooter();
        relocateCaret();
    })
    $(window).resize(function(){
        positionFooter();
        fixOwlMargin();
        relocateCaret();
    })

    function fixOwlMargin(){
        $outer=$('#menu-owl .owl-stage-outer');
        $inner=$('#menu-owl .owl-stage');
        if ($outer.width()>$inner.width()) {
            let len= $outer.width()-$inner.width();
            $inner.css({'margin-left':len/2})
        }
        // console.log($inner.width(),$outer.width());
        
    }
    function positionFooter(){
        $footer=$("#footer");
        if ($("body").height()<$(window).height()) {
            $footer.css({position:'fixed',bottom:'0',left:'0',right:'0'});
        }else{
            $footer.css({position:'unset'});
        }
    }

    function relocateCaret() {
        
        $caret=$('#angel');
        
        $c_btn=$('#addon-btn');

        $caret.css({position:'absolute', right: `${$c_btn.width()+25}px`, top: '14px', 'z-index': '7', 'font-size': '18px', color:'#ccc'});
    }
</script>
@yield('customJs')
{{--<script type="text/javascript" src="magiczoom/magiczoom.js"></script>--}}