@extends('layouts.iframe')

@section('content')
@include('common.errors')
<div class="row">
    <div class="col-sm-3 col-xs-3 col-md-2">
        {!! Form::open([
        'url' => 'upload/' . $endpoint, 
        'class' => 'form',
        'files' => true ]) !!}

        <div class="form-group text-center">
        <p>{!! Form::file('file', ['multiple'=>true, 'class' => 'form-control']) !!}</p>
        <p class="text-left">            
            {{ Form::checkbox('sizes[]', 'sq', true, ['id' => 'rs-sq']) }}<label for="rs-sq" title="Square 150x150">Square</label><br />
            {{ Form::checkbox('sizes[]', 'sm', true, ['id' => 'rs-sm']) }}<label for="rs-sm" title="Small 320x214">Small</label><br />
            {{ Form::checkbox('sizes[]', 'md', true, ['id' => 'rs-md']) }}<label for="rs-md" title="Medium 640x428">Medium</label><br />            
        </p>
        <p>
        {!! Form::submit('Save', 
          ['class'=>'btn btn-primary btn-xs']) !!}</p>

    </div>
    {!! Form::close() !!}    
    </div>
    @if (count($files) > 0)
    @foreach ($files as $file)
    <div class="col-sm-3 col-xs-3 col-md-2">
        <div class="thumbnail hideOverflow">
            <img src="{{ url('/files/' . $endpoint . '/' . $file)  }}" title="{{ $file }}" alt="{{ $file }}">
        </div>
        <div class="caption">
            <form action="{{url('upload/' .$endpoint)}}" method="POST">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                {{ Form::hidden('fileName', $file) }} 

                <button type="submit" class="btn btn-danger btn-xs">
                    <i class="fa fa-btn fa-trash"></i>Delete
                </button>
            </form>
        </div>
    </div>
    @endforeach
</div>

@endif
@endsection