<div id="client_signup_modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: var(--nav-color); color:#fff;">
                {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> --}}
                <h4 class="modal-title">Sign Up</h4>
            </div>
            <div class="modal-body">
                <form action="{{url('client/create')}}" method="post" id="client_signup_form">
                    {{csrf_field()}}
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="reg_first_name" class="control-label">First Name</label>
                            <input type="text" name="first_name" id="reg_first_name" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="reg_last_name" class="control-label">Last Name</label>
                            <input type="text" name="last_name" id="reg_last_name" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="reg_email" class="control-label">Email</label>
                            <input type="email" name="email" id="reg_email" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="reg_phone" class="control-label">Phone</label>
                            <input type="tel" name="phone" id="reg_phone" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="reg_password" class="control-label">Password</label>
                            <input type="password" name="password" id="reg_password" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="reg_password_confirm" class="control-label">Confirm Password</label>
                            <input type="password" name="password_confirmation" id="reg_password_confirm" class="form-control">
                        </div>

                    </div>
                </form>
                <div id="reg_err"></div>
            </div>
            <div class="modal-footer">
                <button type="submit" id="client_signup_btn" form="client_signup_form" class="btn btn-primary">Sign Up</i></button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@push('signupJs')
    <script>
        $('#client_signup_btn').on('click',function(e){
            e.preventDefault();
            $.ajax({
                url:"{{url('client/verify')}}",
                type:'post',
                data:$('#client_signup_form').serialize(),
                success:validResponse,
                error:invalidResponse
            })
        })

        function validResponse(json) {
            $('#client_signup_form').submit();
        }

        function invalidResponse(err) {
            if (err.status===422) {
                let error=err.responseJSON.errors,
                    msg="";

                $.each(error, function(k,v) {
                    msg+=`<li>${v[0]}</li>`
                    
                });

                $('#reg_err').html(
                    `<div class="alert alert-danger alert-dismissible">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <ul>
                            ${msg}
                        </ul>
                    </div>`
                )
            }
            
        }
    </script>
@endpush