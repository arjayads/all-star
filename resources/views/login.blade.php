@extends('layout.app')

@section('content')
    <div class="container-fluid  top-buffer">
        <div class="row">
            <div class="col-md-10 col-md-offset-4 no-padding">
                <div class="row">
                    <div class="col-md-4">
                        <div class="alert alert-info">Login to gain access to page requested!</div>

                        @if (count($errors) > 0)
                            <div class="alert alert-danger fade in">
                                <ul style="list-style-type: none; padding-left: 5px;">
                                    @foreach ($errors->all() as $error)
                                        <li class="color-dark-red">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="/auth/login">
                            {!! csrf_field() !!}

                            <div class="input-group margin-bottom-10">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <input placeholder="Email" class="form-control" type="email" id="email" name="email" value="{{ old('email') }}">
                            </div>
                            <div class="input-group margin-bottom-10">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                <input placeholder="Password"  type="password" class="form-control" id="password" name="password">
                            </div>
                            <div class="checkbox text-center">
                                <label><input type="checkbox" name="remember"> Remember Me</label>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <button style="width: 100%" type="submit" class="btn btn-primary">Log In</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop