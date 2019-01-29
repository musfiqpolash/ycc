@extends('layouts.auth_app')

@section('content')
    <section class="body-sign">
        <div class="center-sign">
            <a href="/" class="logo pull-left">
                <img src="{{url('public/logo.png')}}" height="70" alt="logo"/>
            </a>

            <div class="panel panel-sign">
                <div class="panel-title-sign mt-xl text-right">
                    <h2 class="title text-uppercase text-weight-bold m-none"><i class="fa fa-user mr-xs"></i> Sign In
                    </h2>
                </div>
                <div class="panel-body">
                    @include('includes.flashMessage')
                    <form action="{{url('login')}}" method="post">
                        {{csrf_field()}}
                        <div class="form-group mb-lg {{ $errors->has('email') ? ' has-error' : '' }}">
                            <label>Username</label>
                            <div class="input-group input-group-icon">
                                <input name="email" type="text" class="form-control input-lg"/>
									<span class="input-group-addon">
										<span class="icon icon-lg">
											<i class="fa fa-user"></i>
										</span>
									</span>
                            </div>
                            @if ($errors->has('email'))
                                <span class="help-block">
                                        <strong>Email or Password Does not Match.</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="form-group mb-lg {{ $errors->has('password') ? ' has-error' : '' }}">
                            <div class="clearfix">
                                <label class="pull-left">Password</label>
                            </div>
                            <div class="input-group input-group-icon">
                                <input name="password" type="password" class="form-control input-lg"/>
									<span class="input-group-addon">
										<span class="icon icon-lg">
											<i class="fa fa-lock"></i>
										</span>
									</span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 text-right">
                                <button type="submit" class="btn btn-primary hidden-xs">Sign In</button>
                                <button type="submit" class="btn btn-primary btn-block btn-lg visible-xs mt-lg">Sign
                                    In
                                </button>
                            </div>
                        </div>
							<span class="mt-lg mb-lg line-thru text-center text-uppercase">
								<span>-</span>
							</span>
                        {{--<p class="text-center">Don't Remember Password? <a href="#">Lost Password!</a>--}}

                    </form>
                </div>
            </div>
            @include('includes.authFooter')
        </div>
    </section>
@endsection
