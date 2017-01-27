@extends('layouts.app')

@section('content')

<!-- Current Posts -->

<div class="container">
    <div class="col-sm-offset-2 col-sm-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                <form id="filterFrm" name="filterFrm" method="GET">
                <div class="pull-left">Products</div>
                <div class="pull-right">
                    <a class="btn btn-primary btn-xs" href="{{ url('/products/create/') }}">
                    <i class="fa fa-btn fa-plus"></i>New</a></div>
                    <br class="clearfix"/>
                </form>
            </div>

            <div class="panel-body">
                @if (count($products) > 0)
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
                @endif
                <p> @if (count($products) > 0) {{ $products->links() }} @endif</p>
            </div>
        </div>
      
    </div>
</div>


@endsection


@section('script')
<script>
    $(document).ready(function(){
        
        
    });
</script>
@endsection