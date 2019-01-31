<!-- Bootstrap core JavaScript-->
<script src="{{ url('public') }}/vendor/jquery/jquery.min.js"></script>
<script src="{{ url('public') }}/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="{{ url('public') }}/vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="{{ url('public') }}/js/sb-admin.min.js"></script>

<script src="{{url('public')}}/js/sweetalert2.all.min.js"></script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    let success = "{{session('success')}}";
    if (!$.isEmptyObject(success)) {
        Swal({
            type: 'success',
            title: success,
        })
    }

</script>
