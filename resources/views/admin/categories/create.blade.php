@extends('layouts.app')

@section('content')
<div class="container">
    <div class="col-sm-offset-2 col-sm-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                New category </div>

            <div class="panel-body">
                <!-- Display Validation Errors -->
                @include('common.errors')

                <!-- New Task Form -->
                <form action="{{ url('/admin/categories/store') }}" 
                      method="POST">
                    {{ csrf_field() }}

                    <!-- Task Name -->
                    <div class="form-group">
                        <label for="parent_id" class="col-sm-3 control-label">Parent</label>
                        <div class="col-sm-12">
                            <input type="text" name="parent_id" id="parent_id" class="form-control" 
                                   value="{{old('parent_id')}}">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="category-title" class="col-sm-3 control-label">Title</label>
                        <div class="col-sm-12">
                            <input type="text" name="title" id="category-title" class="form-control" 
                                   value="{{old('title')}}">
                        </div>
                    </div>
                    
                    <div class="form-group clearfix">
                        <label for="category-slug" class="col-sm-3 control-label">Slug</label>
                        <div class="col-sm-12">
                            <input type="text" name="slug" id="category-slug" class="form-control" 
                                   value="{{old('slug')}}">
                        </div>
                    </div>
                    
                    <div class="form-group clearfix">
                        <label for="category-type" class="col-sm-3 control-label">Type</label>
                        <div class="col-sm-12">
                            <input type="text" name="type" id="category-type" class="form-control" 
                                   value="{{old('type')}}">
                        </div>
                    </div>
                    
                    <!-- Add Task Button -->
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-6">
                            <button type="submit" class="btn btn-default">
                                <i class="fa fa-btn fa-plus"></i>Add Category
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection