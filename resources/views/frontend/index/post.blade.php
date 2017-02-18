@extends('layouts.frontend')

@section('content')
<h2 class="post-title" title="{{ $post->title }}">
    {{ $post->title }}
</h2>
<p class="post-meta">Posted by <a href="#">Start Bootstrap</a> {{ the_date($post->created_at) }}</p>

{{ the_content($post->content) }}
@endsection
