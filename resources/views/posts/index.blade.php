@extends('layouts.app')

@section('content')

<!-- Current Posts -->
@if (count($posts) > 0)
<div class="container">
    <div class="col-sm-offset-2 col-sm-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                <form id="filterFrm" name="filterFrm" method="GET">
                <div class="pull-left">Posts</div>
                <div class="pull-right">
                    <select name="category" id="categorySl">
                    <option value=""> -- Category -- </option>
                    {!! $categoryFilter !!}</select>
                    {{ Form::select('statusSl', [
                        1 => 'Active',
                        2 => 'Draft',
                        0 => 'Trash'
                    ], null, ['id' => 'categorySl']) }}
                   
                    
                    <a class="btn btn-primary btn-xs" href="{{ url('/posts/create/') }}">
                    <i class="fa fa-btn fa-plus"></i>New</a></div>
                    <br class="clearfix"/>
                </form>
            </div>

            <div class="panel-body">
                <table class="table table-striped task-table">
                    <thead>
                        <th>Title</th>
                        <th>&nbsp;</th>
                    </thead>
                    <tbody>
                        @foreach ($posts as $post)
                            <tr>
                                <td class="table-text"><div>
                                        <a href="{{ url('/posts/edit/') }}/{{ $post->id }}/{{ $post->slug }}">
                                            {{ $post->title }}</a></div></td>

                                <!-- Task Delete Button -->
                                <td class="text-right">
                                    <form action="{{url('posts/destroy/' . $post->id)}}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}

                                        <button type="submit" id="delete-task-{{ $post->id }}" class="btn btn-danger btn-xs">
                                            <i class="fa fa-btn fa-trash"></i>Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                
                <p>{{ $posts->links() }}</p>
            </div>
        </div>
      
    </div>
</div>
@endif

@endsection


@section('script')
<script>
    $(document).ready(function(){
        
        Post.initIndex();
    });
</script>
@endsection