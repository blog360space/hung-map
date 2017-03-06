@extends('layouts.frontend')

@section('content')
@if(isset($category) && $category->id > 0)
    <h2 class="page-title">Category {{$category->title}}</h2>
@endif

@if(isset($tag) && $tag->id > 0)
    <h2 class="page-title">Tag {{$tag->title}}</h2>
@endif

@if(count($posts) > 0)
@foreach ($posts as $k => $post)

@if($k > 0) 
<hr>
@endif
<div class="post-preview">
    <h2>{{ the_permalink($post) }}</h2>    
    <p class="post-meta">Posted by {{ the_user($post) }} {{ the_date($post) }}</p>
    <div class="post-subtitle">
        {!! the_excerpt($post->content) !!}
    </div>
</div>
@endforeach

@else 

<p><em>Chưa có bài viết</em></p>

@endif

<p> @if (count($posts) > 0) {{ $posts->links() }} @endif</p>
@endsection
