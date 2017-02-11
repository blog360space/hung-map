@if (count($errors) > 0)   
    <!-- Form Error List -->
    <div class="alert alert-danger alert-dismissable">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
        <strong>Whoops! Something went wrong!</strong>

        <br><br>

        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        
    </div>
@endif
@if (Session::has('errorMessage'))
    <div class="alert alert-danger alert-dismissable">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
        {{ Session::get('errorMessage') }}
    </div>
@endif

@if (Session::has('successMessage'))
    <div class="alert alert-info alert-dismissable">{{ Session::get('successMessage') }}
    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
    </div>
@endif