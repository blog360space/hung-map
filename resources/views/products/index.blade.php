@extends('layouts.app')

@section('content')

<!-- Current Posts -->

<div class="container">
    <div class="col-sm-offset-2 col-sm-8">
        
        <div class="panel panel-default">
            <div class="panel-heading">
                
                <div class="pull-left">Fillter</div>
                
                    <br class="clearfix"/>
               
            </div>
            
            <div class="panel-body">
                <form id="filterFrm" name="filterFrm" method="GET">
                <div class="col-sm-2">
                    <select name="category" id="categorySl">
                    <option value=""> -- Category -- </option>
                    {!! $categoryFilter !!}</select>
                </div>
                <div class="col-sm-2">
                    {{ Form::select('branch', 
                        $branches, 
                        app('request')->input('branch'), ['id' => 'branchSl']) }}
                </div>
                
                <div class="col-sm-2">
                    {{ Form::select('vehicle', 
                        $vehicles, 
                        app('request')->input('vehicle'), ['id' => 'vehicleSl']) }}
                </div>
                
                <div class="col-sm-2">
                    <button class="btn btn-default btn-sm">Search</button>
                </div>
                </form>
            </div>
        </div>
        
        <div class="panel panel-default">
            <div class="panel-heading">
                <form id="filterFrm" name="filterFrm" method="GET">
                <div class="pull-left">Products</div>
                <div class="pull-right">
                    <a class="btn btn-primary btn-xs" href="{{ url('/products/create/') }}">
                    <i class="fa fa-btn fa-plus"></i>New</a></div>
                    <br class="clearfix"/>
                </form>
            </div>

            <div class="panel-body">
                @if (count($products) > 0)
                <table class="table table-striped task-table">
                    <thead>
                        <th class="col-sm-10">Title</th>
                        <th class="col-sm-2">Price</th>
                        <th>&nbsp;</th>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td class="table-text"><div>
                                    <a href="{{ url('/products/edit/') }}/{{ $product->id }}/{{ $product->title }}">
                                        {{ $product->title }}</a></div></td>
                                <td class="table-text"><div>
                                    {{ $product->price }}</td>

                                <!-- Task Delete Button -->
                                <td class="text-right">
                                    <form action="{{url('products/destroy/' . $product->id)}}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}

                                        <button type="submit" id="delete-task-{{ $product->id }}" class="btn btn-danger btn-xs">
                                            <i class="fa fa-btn fa-trash"></i>Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
                <p> @if (count($products) > 0) {{ $products->links() }} @endif</p>
            </div>
        </div>
      
    </div>
</div>


@endsection


@section('script')
<script>
    $(document).ready(function(){
        Product.initIndex();
    });
</script>
@endsection