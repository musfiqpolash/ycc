@extends('backend.layouts.app')

@section('content')
    <form action="" method="POST" enctype="multipart/form-data" id="category_add_form">
        {{ csrf_field() }}
        <div class="panel panel-default">
            <div class="panel-heading">Add Cetegory</div>
            <div class="panel-body">
                <div class="form-group {{$errors->has('name')?'has-error':''}}">
                    <label for="category_name" class="control-label">Category Name</label>
                    <div class="input-group">
                        <input type="text" name="name" id="category_name" class="form-control" value="{{old('name')}}">
                        <span class="input-group-btn"><button class="btn btn-info" type="submit">Add</button></span>
                    </div>
                    @if ($errors->has('name'))
                        <span id="name-error" class="help-block">{{$errors->first('name')}}</span>
                    @endif
                </div>
            </div>
        </div>
    </form>

    <div class="panel panel-default">
        <div class="panel-heading">Categories</div>
        <div class="table-responsive">
            <table class="table table-bordered" style="background: white;">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $k=>$item)
                        <tr>
                            <td>{{++$k}}</td>
                            <td>{{$item->name}}</td>
                            <td>
                                <a class="label label-info" href="{{ url('admin/category/'.$item->id.'/sub_category') }}">View Sub Category</a>
                                <a href="" onclick="event.preventDefault(); openCategoryEditModal('{{$item->id}}','{{$item->name}}')" class="label label-warning">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div id="category_edit_modal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Edit Category</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="cat_name" class="control-label">Category Name</label>
                        <input type="text" name="name" id="cat_name" class="form-control">
                        <input type="hidden" name="id" id="cat_id" class="form-control">
                    </div>
                    <div id="cat_err"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="cat_edit_btn" class="btn btn-primary">Update</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection

@section('customJs')
    <script>
        function openCategoryEditModal(id,name) {
            $('#cat_id').val(id);
            $('#cat_name').val(name);
            $('#category_edit_modal').modal();
        }

        $('#cat_edit_btn').on('click',function(){
            $.ajax({
                url:"{{url('admin/category/update')}}",
                data:{id:$('#cat_id').val(),name:$('#cat_name').val()},
                type:'post',
                success:function(json){
                    location.reload();
                },
                error:function(err){
                    console.error(err);
                    let msg = "";
                    if (err.status === 422) {
                        let error = err.responseJSON.errors;

                        $.each(error, function (k, v) {
                            msg += `<li>${v[0]}</li>`

                        });

                    }else{
                        msg="<li>These credentials do not match our records.</li>"
                    }
                    $('#cat_err').html(
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
@endsection