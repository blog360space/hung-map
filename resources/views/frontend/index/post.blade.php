@extends('layouts.frontend')

@section('content')
<h2 class="post-title" title="{{ $post->title }}">
    {{ $post->title }}
</h2>
<p class="post-meta">Posted by {{ the_user($post) }} {{ the_date($post) }}</p>

{{ the_content($post->content) }}
@endsection
