<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>All Star</title>

    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('/plugins/jquery-ui-1.11.4.custom/jquery-ui.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/plugins/jquery-ui-1.11.4.custom/jquery-ui.structure.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/plugins/jquery-ui-1.11.4.custom/jquery-ui.theme.min.css') }}" rel="stylesheet">

    <!-- Fonts -->
    <link href='{{ asset('/css/css.htm?family=Roboto:400,300') }}' rel='stylesheet' type='text/css'>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="{{ asset('/js/html5shiv.min.js') }}"></script>
    <script src="{{ asset('/js/html5shiv.min.js') }}"></script>
    <![endif]-->

    @yield('css')
</head>
<body>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-7 col-md-offset-2">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="/">Allstar</a>
                </div>

                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

                    <ul class="nav navbar-nav navbar-right">
                        @if (!Auth::guest())
                            <form class="navbar-form navbar-left" role="search">
                                <div class="form-group">
                                    <input id="search" type="text" class="form-control" placeholder="Search members">
                                </div>
                            </form>
                        @endif

                        @if (Auth::guest())
                            <li><a href="{{ url('/auth/login/github') }}">Login using Github</a></li>
                            <li><a href="{{ url('/auth/login/facebook') }}">Login using Facebook</a></li>
                        @else
                            @if(Auth::user()->type == 'admin')
                                <li><a href="{{ url('/admin/videos') }}">All Videos</a></li>
                                <li><a href="{{ url('/admin/videos/create') }}">Upload Video</a></li>
                            @endif

                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }}
                                    <img src="{{ Auth::user()->avatar }}" class="avatar img-circle" width="26" height="26">
                                    <span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="/profile">Profile</a></li>
                                    <li><a href="{{ url('/auth/logout') }}">Logout</a></li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>

@yield('content')
<!-- Scripts -->
<script src="{{ asset('/plugins/jquery-ui-1.11.4.custom/external/jquery/jquery.js') }}"></script>
<script src="{{ asset('/plugins/jquery-ui-1.11.4.custom/jquery-ui.min.js') }}"></script>
<script src="{{ asset('/js/bootstrap.min.js') }}"></script>

<!--Footer -->
<div style="margin-top: 100px;"></div>
<div class="navbar navbar-default navbar-fixed-bottom">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-7 col-md-offset-2">
                <div class="navbar-header">
                    <a class="navbar-brand" href="#">© Allstar Innovators <?=(date('Y'))?>.</a>
                </div>

                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $( "#search" ).autocomplete({
        source: "/ajax/find/members",
        minLength: 2,
        select: function( event, ui ) {
            if (ui.item) {
                window.location = '/member/profile?id='+ui.item.id;
            }
        }
    });
</script>
@yield('js')
</body>
</html>
