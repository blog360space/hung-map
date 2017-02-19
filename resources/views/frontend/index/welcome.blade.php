@extends('layouts.frontend')

@section('content')
@if(count($posts) > 0)
@foreach ($posts as $k => $post)

@if($k > 0) 
<hr>
@endif
<div class="post-preview">
    <a href="{{ url('/post/') }}/{{ $post->id }}/{{ $post->slug }}">
        <h2 class="post-title" title="{{ $post->title }}">
            {{ $post->title }}
        </h2>
        <h3 class="post-subtitle">
            {!! the_excerpt($post->content) !!}
        </h3>
    </a>
    <p class="post-meta">Posted by {{ the_user($post) }} {{ the_date($post) }}</p>
</div>
@endforeach
@endif

<p> @if (count($posts) > 0) {{ $posts->links() }} @endif</p>
@endsection
