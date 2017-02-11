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
            Thumbs: <br/>
            <label for="rs-sm">Sm</label> {{ Form::checkbox('resize[]', 'sm', true, ['id' => 'rs-sm']) }}
            <label for="rs-md">Md</label> {{ Form::checkbox('resize[]', 'md', true, ['id' => 'rs-md']) }}
            <label for="rs-lg">Lg</label> {{ Form::checkbox('resize[]', 'lg', true, ['id' => 'rs-lg']) }}
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