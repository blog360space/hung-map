<!-- Stored in resources/views/child.blade.php -->

@extends('layouts.master')

@section('title', 'Page Title sssssssssssssssssss')

@section('sidebar')
    @parent

    <p>This is appended to the master sidebar.</p>
@endsection

@section('content')
    <p>This is my body content.</p>
    <p>
        Hello {{ $name }}
    </p>
@endsection