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

    var owl = $('.owl-carousel');
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
    $(window).on('load',fixOwlMargin)
    $(window).resize(fixOwlMargin)

    function fixOwlMargin(){
        $outer=$('.owl-stage-outer');
        $inner=$('.owl-stage');
        if ($outer.width()>$inner.width()) {
            let len= $outer.width()-$inner.width();
            $inner.css({'margin-left':len/2})
        }
        // console.log($inner.width(),$outer.width());
        
    }
</script>
@yield('customJs')
{{--<script type="text/javascript" src="magiczoom/magiczoom.js"></script>--}}