<!-- start: header -->
<header class="header">
    <div class="logo-container">
        <a href="../" class="logo">
            <img src="{{url('public/images/sslogo.png')}}" height="40" alt="Porto Admin" />
        </a>
        <div class="visible-xs toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
            <i class="fa fa-bars" aria-label="Toggle sidebar"></i>
        </div>
    </div>

    <!-- start: search & user box -->
    <div class="header-right">
        <div id="userbox" class="userbox">
            <a href="#" data-toggle="dropdown">
                <figure class="profile-picture">
                    {{--<img src="{{url('public/images/sslogo.png')}}" alt="Joseph Doe" class="img-circle" data-lock-picture="{{url('public/images/sslogo.png')}}" />--}}
                </figure>
                <div class="profile-info">
                    <span class="name">{{\Illuminate\Support\Facades\Auth::user()->name}}</span>
                    <span class="role">{{\Illuminate\Support\Facades\Auth::user()->email}}</span>
                </div>

                <i class="fa custom-caret"></i>
            </a>

            <div class="dropdown-menu">
                <ul class="list-unstyled">
                    <li class="divider"></li>
                    {{--<li>--}}
                        {{--<a role="menuitem" tabindex="-1" href="pages-user-profile.html"><i class="fa fa-user"></i> My Profile</a>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                        {{--<a role="menuitem" tabindex="-1" href="#" data-lock-screen="true"><i class="fa fa-lock"></i> Lock Screen</a>--}}
                    {{--</li>--}}
                    <li>
                        <a style="cursor: pointer;" role="menuitem" data-toggle="modal" data-target="#resetModal" tabindex="-1"><i class="fa fa-key"></i> Reset Password</a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a role="menuitem" tabindex="-1" href="{{url('logout')}}"><i class="fa fa-power-off"></i> Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- end: search & user box -->
</header>
<!-- end: header -->
{{--modal--}}
<div id="resetModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Reset Password</h4>
            </div>

                <form id="resetPassword" action="{{url('admin/resetPassword')}}" method="post">
                    <div class="modal-body text-center">
                    <div class="row">
                        <label for="password" class="control-label col-sm-6 col-sm-offset-3">New Password
                            <input type="password" name="password" required id="password" class="form-control">
                        </label>
                        <label for="password_confirmation" class="control-label col-sm-6 col-sm-offset-3">Re-enter new Password
                            <input type="password" name="password_confirmation" required id="password_confirmation" class="form-control">
                        </label>
                    </div>
                    </div>
                    @csrf
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-success" name="submit" value="Reset Password">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </form>

        </div>

    </div>
</div>
{{--end modal--}}