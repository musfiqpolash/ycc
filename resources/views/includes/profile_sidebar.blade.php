@php
function active($str){
if (Route::currentRouteName()==$str) {
return 'active';
}
}
@endphp

<div class="col-md-3">
    <div class="panel panel-default">
        <div class="panel-heading bg-nav text-white h4" style="margin: 0;">{{auth('client')->user()->first_name.' '.auth('client')->user()->last_name}}</div>
        <div class="list-group">
            <a href="{{ url('client/dashboard') }}" class="list-group-item bold {{active('p_dashboard')}}">Dashboard</a>
            <a href="{{ url('client/profile') }}" class="list-group-item bold {{active('p_profile')}}">Profile</a>
            <a href="{{ url('client/orders') }}" class="list-group-item bold {{active('p_orders')}}">Orders</a>
            <a data-toggle="modal" data-target="#client_password_modal" class="list-group-item bold">Change Password</a>
            <a href="{{ url('client/logout') }}" class="list-group-item bold">Logout</a>
        </div>
    </div>
</div>


<div id="client_password_modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: var(--nav-color); color:#fff;">
                {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> --}}
                <h4 class="modal-title">Change Password</h4>
            </div>
            <div class="modal-body">
                <form action="{{url('client/changePassword')}}" method="post" class="modal-form" id="client_change_password_form">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="current_password" class="control-label">Current Password</label>
                        <input type="password" name="current_password" id="current_password" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="new_password" class="control-label">New Password</label>
                        <input type="password" name="new_password" id="new_password" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="new_password_confirmation" class="control-label">Confirm New Password</label>
                        <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control">
                    </div>
                </form>
                <div id="cng_err"></div>
            </div>
            <div class="modal-footer">
                <button type="submit" id="client_change_password_btn" form="client_change_password_form" class="btn btn-primary">Change Password</i></button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@push('passwordJs')
<script>
    
    $('#client_change_password_btn').on('click', function (e) {
        e.preventDefault();
        $.ajax({
            url: "{{url('client/changePasswordRequest')}}",
            type: 'post',
            data: $('#client_change_password_form').serialize(),
            success: function (json) {
                $('#client_change_password_form').submit();

            },
            error: function (err) {
    
                if (err.status === 422) {
                    let error = err.responseJSON.errors,
                        msg = "";

                    $.each(error, function (k, v) {
                        msg += `<li>${v[0]}</li>`

                    });

                    $('#cng_err').html(
                        `<div class="alert alert-danger alert-dismissible">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <ul>
                            ${msg}
                        </ul>
                    </div>`
                    )
                }
            }
        })
    })
</script>
@endpush