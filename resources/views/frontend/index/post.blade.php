@extends('layouts.frontend')

@section('content')
<a href="{{ url('/post/') }}/{{ $post->id }}/{{ $post->slug }}"><h2 class="post-title" title="{{ $post->title }}">
   {{ $preview ? '[Preview]' : '' }} {{ $post->title }}
</h2></a>
<p class="post-meta">Posted by {{ the_user($post) }} {{ the_date($post) }}</p>

{{ the_content($post->content) }}
@endsection
