@extends('layouts.master')
@section('title', '| Dashboard')
@section('content')
<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item active">
        <a href="">Dashboard</a>
    </li>
</ol>

<!-- Icon Cards-->
<div class="row">
    <div class="col-xl-3 col-sm-6 mb-3">
        <div class="card text-white bg-primary o-hidden h-100">
            <div class="card-body">
                <div class="card-body-icon">
                    <i class="fas fa-fw fa-receipt"></i>
                </div>
                <div class="mr-5">{{$req}} Product Request</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="{{url('/requests')}}">
                <span class="float-left">View</span>
                <span class="float-right">
                    <i class="fas fa-angle-right"></i>
                </span>
            </a>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-3">
        <div class="card text-white bg-warning o-hidden h-100">
            <div class="card-body">
                <div class="card-body-icon">
                    <i class="fas fa-fw fa-images"></i>
                </div>
                <div class="mr-5">{{$slider}} Sliders</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="{{url('/sliders')}}">
                <span class="float-left">View</span>
                <span class="float-right">
                    <i class="fas fa-angle-right"></i>
                </span>
            </a>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-3">
        <div class="card text-white bg-success o-hidden h-100">
            <div class="card-body">
                <div class="card-body-icon">
                    <i class="fas fa-fw fa-info"></i>
                </div>
                <div class="mr-5">Information</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="{{url('/information')}}">
                <span class="float-left">View</span>
                <span class="float-right">
                    <i class="fas fa-angle-right"></i>
                </span>
            </a>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-3">
        <div class="card text-white bg-danger o-hidden h-100">
            <div class="card-body">
                <div class="card-body-icon">
                    <i class="fas fa-fw fa-list"></i>
                </div>
                <div class="mr-5">Additional</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="{{url('/additional')}}">
                <span class="float-left">View</span>
                <span class="float-right">
                    <i class="fas fa-angle-right"></i>
                </span>
            </a>
        </div>
    </div>
</div>
@endsection
