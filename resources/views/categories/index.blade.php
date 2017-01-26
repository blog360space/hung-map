@extends('layouts.app')

@section('content')
<div class="container">
    <div class="col-sm-offset-2 col-sm-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="pull-left">Categories</div>
                <div class="pull-right"><a class="btn btn-primary btn-xs" href="{{ url('/categories/create/') }}">
                <i class="fa fa-btn fa-plus"></i>New</a></div>
                <br class="clearfix"/> </div>

            <div class="panel-body">
                <!-- Display Validation Errors -->
                @include('common.errors')

                {!! $tree !!}
            </div>
        </div>
    </div>
</div>

@endsection