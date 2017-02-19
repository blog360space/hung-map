@extends('layouts.iframe')

@section('content')
@include('common.errors')
<div class="row">
    <div class="col-sm-3 col-xs-3 col-md-2">
        {!! Form::open([
        'url' => '/admin/upload/' . $endpoint, 
        'class' => 'form',
        'files' => true ]) !!}

        <div class="form-group text-center">
        <p>{!! Form::file('file', ['multiple'=>true, 'class' => 'form-control']) !!}</p>
        
        <p>
        {!! Form::submit('Upload', 
          ['class'=>'btn btn-primary btn-xs']) !!}</p>

    </div>
    {!! Form::close() !!}    
    </div>
    @if (count($files) > 0)
    @foreach ($files as $file)
    <div class="col-sm-3 col-xs-3 col-md-2">
        <div class="thumbnail hideOverflow">
            <img src="{{ url('/files/' . $endpoint . '/' . $file)  }}" title="{{ $file }}" alt="{{ $file }}">
            
            <div class="caption text-right">
                <form action="{{url('/admin/upload/' .$endpoint)}}" method="POST" style="margin: 0px!important">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    {{ Form::hidden('fileName', $file) }} 

                    <button type="submit" class="btn btn-danger btn-xs">
                        <i class="fa fa-btn fa-trash"></i>Delete
                    </button>
                </form>
            </div>
        </div>
        
    </div>
    @endforeach
</div>

@endif
@endsection