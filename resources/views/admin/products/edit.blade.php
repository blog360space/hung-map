@extends('layouts.app')

@section('content')
<div class="container">
    <div class="col-sm-offset-2 col-sm-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                Edit {{$product->title}}
            </div>
            <div class="panel-body">
                <!-- Display Validation Errors -->
                @include('common.errors')

                {!! Form::model($product, [
                    'url' => '/admin/products/update/' . $product->id, 
                    'class' => 'form']) !!}
                    
                <div class="form-group">
                    {!! Form::label('Title') !!}
                    {!! Form::text('title', null, 
                        array('required', 
                              'class'=>'form-control', 
                              'placeholder'=>'Title')) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('Price') !!}
                    {!! Form::text('price', null, 
                        array('required', 
                              'class'=>'form-control', 
                              'placeholder'=>'Price')) !!}
                </div>
                
                <div class="form-group">
                    {!! Form::label('Description') !!}
                    {!! Form::textarea('description', null, 
                        array(
                              'class'=>'form-control', 
                              'placeholder'=>'Description')) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('Category') !!}
                    <div class="col-sm-12">
                        {!! $tree !!}                        
                    </div>
                </div>
                
                <div class="form-group">
                    {!! Form::label('Tags') !!}
                    {!! Form::text('tag', null, 
                        array(
                              'class'=>'form-control', 
                              'placeholder'=>'Tag',
                              'id' => 'product-tags')) !!}
                </div>  
                <div class="form-group">
                    {!! Form::label('Branches') !!}
                    {!! Form::text('branch', null, 
                        array(
                              'class'=>'form-control', 
                              'placeholder'=>'Branch',
                              'id' => 'product-branches')) !!}
                </div>
                    
                <div class="form-group">
                    {!! Form::label('Vehicles') !!}
                    {!! Form::text('vehicle', null, 
                        array(
                              'class'=>'form-control', 
                              'placeholder'=>'Vehicle',
                              'id' => 'product-vehicles')) !!}
                </div>
                    
                <div class="form-group"><div class="col-sm-offset-5 col-sm-6">
                    {!! Form::submit('Save', 
                      ['class'=>'btn btn-primary']) !!}
                </div></div>
                    
                  
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function(){        
        Product.initTags();        
        Product.initBranches();
        Product.initVehicles();
    });
</script>
@endsection