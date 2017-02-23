@extends('layouts.frontend')

@section('content')
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
@endif

<p> @if (count($posts) > 0) {{ $posts->links() }} @endif</p>
@endsection
