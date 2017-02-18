<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel Quickstart - Intermediate</title>

    <!-- Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>

    <!-- Styles -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">    
    <script src="{{ url('/') }}/components/angular/angular.min.js"></script>    
    <link href="{{ url('/') }}/components/aehlke-tag-it/css/jquery.tagit.css" rel="stylesheet" type="text/css">
    <link href="{{ url('/') }}/components/aehlke-tag-it/css/tagit.ui-zendesk.css" rel="stylesheet" type="text/css">
    <link href="{{ url('/') }}/components/md/dist/simplemde.min.css" rel="stylesheet" type="text/css">
    <link href="{{ url('/') }}/css/admin.css" rel="stylesheet" type="text/css">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}

    <style>
        body {
            font-family: 'Lato';
        }

        .fa-btn {
            margin-right: 6px;
        }
    </style>    
</head>
<body id="app-layout">
    <nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" 
                        data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    Task List
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                </ul>

                <!-- Right Side Of Navbar -->
               
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                     <ul class="nav navbar-nav navbar-right">
                        <li><a href="{{ url('/login') }}">Login</a></li>
                        <li><a href="{{ url('/register') }}">Register</a></li>
                     </ul>
                    @else
                    {{ display_menu() }}
                    @endif
                </ul>
            </div>
        </div>
    </nav>    
    @yield('content')
    
    <!-- JavaScripts -->
    <script>
    BASE_URL = '{{url("/")}}';</script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>    
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="{{ url('/') }}/components/aehlke-tag-it/js/tag-it.min.js"></script>
<!--    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script> -->
    <script src="{{ url('/') }}/components/md/dist/simplemde.min.js"></script>
    <script src="{{ url('/') }}/js/admin.js"></script>
    @yield('script')
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
</body>
</html>
