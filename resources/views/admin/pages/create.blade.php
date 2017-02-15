@extends('layouts.app')

@section('content')
<div class="container">
    <div class="col-sm-offset-2 col-sm-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                New Page
            </div>

            <div class="panel-body">
                <!-- Display Validation Errors -->
                @include('common.errors')

                <!-- New Task Form -->
                <form action="{{ url('/admin/pages/store') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="post-title" class="col-sm-3 control-label">Title</label>
                        <div class="col-sm-12">
                            <input type="text" name="title" id="post-title" class="form-control" 
                                   value="{{old('title')}}">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="post-slug" class="col-sm-3 control-label">Slug</label>
                        <div class="col-sm-12">
                            <input type="text" name="slug" id="post-slug" class="form-control" 
                                   value="{{old('slug')}}">
                        </div>
                    </div>

                    <div class="form-group clearfix">
                        <label for="post-content" class="col-sm-3 control-label">Content</label>
                        <div class="col-sm-12">
                            <textarea name="content" id="post-content"
                            rows="10"
                            class="form-control">{{old('content')}}</textarea>                            
                        </div>
                    </div>
                    
                    <div class="form-group clearfix">
                        <label for="post-status" class="col-sm-3 control-label">Status</label>
                        <div class="col-sm-12">
                            <select class="form-control" name="status">
                            <option value="1"
                                @if(old('status') == 1)selected="selected"@endif>Publish</option>
                                <option value="2" 
                                @if(old('status') == 2)selected="selected"@endif>Draft</option>
                            </select>
                        </div>
                    </div>
                    
                    <!-- Add Task Button -->
                    <div class="form-group">
                        <div class="col-sm-offset-5 col-sm-6">
                            <button type="submit" class="btn btn-default">
                                <i class="fa fa-btn fa-plus"></i>Add</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function(){
        Post.initSlug();        
        Post.initTinymce();
    });
</script>
@endsection