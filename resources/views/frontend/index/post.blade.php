@extends('layouts.frontend')

@section('content')
<h2 class="post-title" title="{{ $post->title }}">
   {{ $preview ? '[Preview]' : '' }} {{ the_permalink($post) }}
</h2>
</a>
<p class="post-meta">Posted by {{ the_user($post) }} {{ the_date($post) }}</p>

{{ the_content($post->content) }}


<p class="text-left">
    @if (isset($postsPn[0]))    
    <span class="glyphicon glyphicon-menu-left"> </span>{{ the_permalink($postsPn[0]) }}
    @endif
</p>
<p class="text-right">
@if (isset($postsPn[1]))   
    {{ the_permalink($postsPn[1]) }} <span class="glyphicon glyphicon-menu-right" > </span>
    @endif</p>
    
@endsection
