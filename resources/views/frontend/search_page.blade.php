@extends('layouts.front')

@section('title','Search')

@section('content')
<div class="container-fluid">
    <div class="p-title">
        <h3>Search Result</h3>
        <div class="p-title-line"></div>
    </div>
</div>
 <!--product container-fluid-->
<div class="container-fluid sspImg">
    <div class="row" id="backup">
            @if ($products->count('id')==0)
            <div class="col-md-12">
                <div class="alert alert-info">
                    <h4>Product Not Found</h4>
                </div>

            </div>
            @endif

            @foreach($products as $key=>$val)
                <a href="{{url(str_replace(' ','_',$val->name).'/details/'.$val->group_name)}}">
                    <div class="col-md-3 col-sm-6 col-xs-12 imageBox leave_img">
                        <div class="imageBox box leave_img">
                             <div class="loader"></div>
                            <img id="prdct{{$val->id}}" class="img-thumbnail leave_img"
                                 src="{{url('public/uploads/assets/frontend/images/products/')}}/{{$val->main_image}}"
                                 alt="1">
    
    
                            <div class="textBox text-center">
                                <a href="{{url(str_replace(' ','_',$val->name).'/details/'.$val->group_name)}}">VIEW</a>
                            </div>
                            @if($val->label!='')
                                <div class="textBoxTop {{$val->label_css}}">
                                    <p>{{$val->label}}</p>
                                </div>
                            @endif
                        </div>
                        <div class="sspText">
                            <div class="txtUpper">
                                <p>{{$val->name}}</p>
                            </div>
                            <hr>
                            <div class="txtLower">
                                <p>
                                    @if($val->is_discount==1)
                                        <i>${{$val->hasPrice[0]->price}} </i>&nbsp;
                                        ${{$val->discount_price}}
                                    @else
                                        ${{$val->hasPrice[0]->price}}
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
    
    </div>
</div>
<!--product container-fluid end-->
@endsection

@section('customCss')
    <style>
        .p-title{
            display: flex;
        }
        .p-title h3{
            margin: 15px 0;
        }
        .p-title-line{
            position: relative;
            flex-grow: 100;
        }
        .p-title-line::after{
            position: absolute;
            content:"";
            top: 50%;
            left: 15px;
            right: 0;
            height: 1px;
            background: #ccc;
        }
    </style>
@endsection