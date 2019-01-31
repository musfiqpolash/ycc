@extends('layouts.master')
@section('title', '| Additional')

@section('content')
<ol class="breadcrumb">
    <li class="breadcrumb-item active">
        <a href="">Additional</a>
    </li>
</ol>
<div class="row">
    <div class="col-12 mb-2 text-right">
        <button class="btn btn-info" onclick="openAddModal()">Add</button>
    </div>
    @foreach ($page_data as $item)
    <div class="col-12 mb-2">
        <div class="card">
            <div class="card-header bg-white">{{$item->title}}
                <span class="float-right">
                    {{-- <a href="" class="text-warning"><i class="fa fa-edit"></i></a> --}}
                    <a href="{{ route('additional.destroy', ['id'=>$item->id]) }}" onclick="event.preventDefault(); deleteItem('item_{{$item->id}}')" class="text-danger"><i class="fa fa-trash"></i></a>
                    <form id="item_{{$item->id}}" style="display: none;" action="{{ route('additional.destroy', ['id'=>$item->id]) }}" method="post">
                        @csrf
                        @method("DELETE")
                    </form>
                </span>
            </div>
            <div class="card-body text-justify">
                <?=$item->description?>
            </div>
        </div>
    </div>
    @endforeach
    <div class="col-12 text-right">
        {{ $page_data->links() }}
    </div>
</div>
<div id="addModal" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addForm" action="{{route('additional.store')}}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="title">Title <span class="red">*</span></label>
                        <input required type="text" class="form-control modal-input" id="title" name="title">
                    </div>

                    <div class="form-group">
                        <label for="description">Description <span class="red">*</span></label>
                        <textarea required class="form-control modal-input" id="description" name="description"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="priority">Priority</label>
                        <input type="number" min="0" class="form-control modal-input" id="priority" name="priority">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <input type="submit" form="addForm" class="btn btn-primary" value="Submit">
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.ckeditor.com/4.11.1/basic/ckeditor.js"></script>
<script>
    function openAddModal() {
        $('#addModal').modal();
    }

    // $('#description').on('focus', cc_create());
    let editor = null;

    function cc_create() {
        CKEDITOR.replace('description');
    }

    function cc_dectroy() {
        CKEDITOR.instances.description.destroy();
    }

    function deleteItem(id) {
        Swal({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            reverseButtons: true,
        }).then((result) => {
            if (result.value) {
                $('#'+id).submit();
            }
        })
    }
</script>
@endsection

@section('css')
<style>
    .red{
        color:red;
    }
</style>
@endsection
