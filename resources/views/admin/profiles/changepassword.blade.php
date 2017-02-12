@extends('layouts.app')

@section('content')
<div class="container">
    <div class="col-sm-offset-2 col-sm-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                Change password
            </div>

            <div class="panel-body">
                <!-- Display Validation Errors -->
                @include('common.errors')

                <!-- New Task Form -->
                {!! Form::open([
                    'url' => 'profiles/change-password/', 
                    'class' => 'form',
                    'files' => true ]) !!}
                    
                    <div class="form-group">
                        {!! Form::label('Old password') !!}
                        {!! Form::password('password_old',
                            array('required', 
                                  'class'=>'form-control', 
                                  'placeholder'=>'Password')) !!}
                    </div>
                    
                    <div class="form-group">
                        {!! Form::label('New password') !!}
                        {!! Form::password('password_new',
                            array('required', 
                                  'class'=>'form-control', 
                                  'placeholder'=>'Password')) !!}
                    </div>
                    
                    <div class="form-group">
                        {!! Form::label('Verify password') !!}
                        {!! Form::password('password_re',
                            array('required', 
                                  'class'=>'form-control', 
                                  'placeholder'=>'Password')) !!}
                    </div>
                    
                    <!-- Add Task Button -->
                    <div class="form-group">
                        <div class="col-sm-offset-5 col-sm-6">
                            <button type="submit" class="btn btn-default">
                                <i class="fa fa-btn fa-pencil"></i>Save
                            </button>
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function(){
        
    });
</script>
@endsection