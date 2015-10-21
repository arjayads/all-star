@extends('layout.app')

@section('content')
    <div class="container-fluid  top-buffer">
        <div class="row">
            <div class="col-md-7 col-md-offset-2">
                @if(isset($notFound))
                    <div class="alert alert-danger">
                        Member you are looking for is not available!
                    </div>
                @else
                    <h3>Member Profile</h3>
                <hr/>
                    <p>
                        <img style="float: left; margin-right: 10px;" src="{{$member->avatar}}" class="avatar img-rounded" width="48" height="48">
                        <b>Name:</b> {{$member->name}} <br/>
                        <b>Email:</b> {{$member->email}}
                    </p>
                    <div style="margin-top: 30px;"></div>
                    <button class="btn btn-success">Add</button>
                @endif
            </div>
        </div>
    </div>
@stop