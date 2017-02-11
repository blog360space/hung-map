@extends('layouts.iframe')

@section('content')

{!! Form::open([
    'url' => 'upload/' . $endpoint, 
    'class' => 'form',
    'files' => true ]) !!}

<div class="form-group">
    <div class="col-sm-2">{!! Form::file('file', ['multiple'=>true, 'class' => 'form-control']) !!}</div>
    <div class="col-sm-2">{!! Form::submit('Save', 
      ['class'=>'btn btn-primary']) !!}</div>
   
</div>
{!! Form::close() !!}
@include('common.errors')
@if (count($files) > 0)
<table class="table table-striped task-table">
    <tbody>
        @foreach ($files as $file)
            <tr>
                <td class="table-text">{{ $file }}</td>

                <!-- Task Delete Button -->
                <td class="text-right">
                    <form action="{{url('upload/' .$endpoint)}}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        {{ Form::hidden('fileName', $file) }} 

                        <button type="submit" class="btn btn-danger btn-xs">
                            <i class="fa fa-btn fa-trash"></i>Delete
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endif
@endsection