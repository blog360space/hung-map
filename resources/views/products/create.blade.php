@extends('layouts.app')

@section('content')
<div class="container">
    <div class="col-sm-offset-2 col-sm-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                New Post
            </div>

            <div class="panel-body">
                <!-- Display Validation Errors -->
                @include('common.errors')

                <!-- New Task Form -->
                <form action="{{ url('posts/store') }}" method="POST">
                    {{ csrf_field() }}
                    <?php echo Form::select('size', ['L' => 'Large', 'S' => 'Small']); ?>
                    <!-- Add Task Button -->
                    <div class="form-group">
                        <div class="col-sm-offset-5 col-sm-6">
                            <button type="submit" class="btn btn-default">
                                <i class="fa fa-btn fa-plus"></i>Add Post</button>
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
        Post.initTags();
        Post.initTinymce();
    });
</script>
@endsection