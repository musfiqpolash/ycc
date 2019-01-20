<script src="{{url('resources/assets/backend')}}/vendor/jquery/jquery.js"></script>
<script src="{{url('resources/assets/backend')}}/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
<script src="{{url('resources/assets/backend')}}/vendor/bootstrap/js/bootstrap.js"></script>
<script src="{{url('resources/assets/backend')}}/vendor/nanoscroller/nanoscroller.js"></script>
<script src="{{url('resources/assets/backend')}}/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="{{url('resources/assets/backend')}}/vendor/magnific-popup/magnific-popup.js"></script>
<script src="{{url('resources/assets/backend')}}/vendor/jquery-placeholder/jquery.placeholder.js"></script>

<!-- Specific Page Vendor -->
<script src="{{url('resources/assets/backend')}}/vendor/jquery-validation/jquery.validate.js"></script>
@yield('customJs')
<!-- Theme Base, Components and Settings -->
<script src="{{url('resources/assets/backend')}}/javascripts/theme.js"></script>

<!-- Theme Custom -->
<script src="{{url('resources/assets/backend')}}/javascripts/theme.custom.js"></script>

<!-- Theme Initialization Files -->
<script src="{{url('resources/assets/backend')}}/javascripts/theme.init.js"></script>


<!-- Examples -->
<script src="{{url('resources/assets/backend')}}/javascripts/forms/examples.validation.js"></script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(function(){

        $('#resetPassword').validate({
            rules:{
                password:{
                    required : true,
                    minlength:6
                },
                password_confirmation:{
                    equalTo: "#password"
                }

            },

            highlight: function (element) {
                $(element).parent().addClass('has-error')
            },
            unhighlight: function (element) {
                $(element).parent().removeClass('has-error')
            }
        });
    });
</script>