<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Test</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">


    <link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>

    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>


</head>
<body>
    <nav role="navigation" class="navbar">
        <div class="container">
            <div class="col-sm-6">
                <div class="navbar-header">
                    <a href="/" class="navbar-brand"><img border="0" height="50" alt="logo" src="{!! URL::to('/images/allstar.jpg') !!}" alt="AllStar Innovators" title="AllStar Innovators"></a>
                </div>
            </div>
            <div class="col-sm-6">
                <ul class="nav navbar-nav" style="float:right;">
                    @if (Auth::check())
                        @if($user->type == 'admin')
                            <li><a href="{!! URL::to('/admin/videos/create') !!}">Upload video</a></li>
                            <li><a href="#">Admin</a></li>
                        @else
                            <li><a href="#">{!! $user->name !!}</a></li>
                        @endif
                        <li><a href="{!! URL::to('/user/logout') !!}">Logout</a></li>
                    @else
                        <li><a href="{!! URL::to('/user/register') !!}">Register</a></li>
                        <li><a href="{!! URL::to('/user/login') !!}">Login</a></li>
                    @endif


                </ul>
            </div>
        </div>
    </nav>

    <div id="body">
        <div class="container" >
            @yield('content')
        </div>
    </div>

</body>
</html>