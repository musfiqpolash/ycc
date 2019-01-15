@extends('backend.layouts.app')

@section('content')
    <form action="" method="POST" enctype="multipart/form-data" id="product_add_form">
        <div class="panel">
            <div class="panel-body">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="p_name" class="control-label">Product Name</label>
                        <input type="text" name="product_name" id="p_name" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="p_cat" class="control-label">Product Category</label>
                        <select name="product_category" id="p_cat" class="form-control">
                            <option value="">Select a category</option>
                            <option value="1">Category 1</option>
                            <option value="2">Category 2</option>
                        </select>
                    </div>
                </div>

            </div>
        </div>
    </form>
@endsection