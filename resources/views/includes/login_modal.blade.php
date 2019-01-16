<div id="client_login_modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: var(--nav-color); color:#fff;">
                {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> --}}
                <h4 class="modal-title">Login</h4>
            </div>
            <div class="modal-body">
                <form action="{{url('client/login')}}" method="post" id="client_login_form" class="modal-form">
                    {{csrf_field()}}
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="log_email" class="control-label">Email</label>
                            <input type="email" name="email" id="log_email" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="log_password" class="control-label">Password</label>
                            <input type="password" name="password" id="log_password" class="form-control">
                        </div>

                    </div>
                </form>
                <div id="log_err"></div>
            </div>
            <div class="modal-footer">
                <button type="submit" id="client_login_btn" form="client_login_form" class="btn btn-primary"><i class="fa fa-sign-in"> Login</i></button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


@push('loginJs')
<script>
    $('#client_login_btn').on('click', function (e) {
        e.preventDefault();
        $.ajax({
            url: "{{url('client/loginVerify')}}",
            type: 'post',
            data: $('#client_login_form').serialize(),
            success: function (json) {
                $('#client_login_form').submit();
            },
            error: function (err) {
                // console.log(err);
                let msg = "";
                if (err.status === 422) {
                    let error = err.responseJSON.errors;

                    $.each(error, function (k, v) {
                        msg += `<li>${v[0]}</li>`

                    });

                }else{
                    msg="<li>These credentials do not match our records.</li>"
                }
                $('#log_err').html(
                    `<div class="alert alert-danger alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <ul>
                        ${msg}
                    </ul>
                </div>`
                )
            }
        })
    })
</script>
@endpush