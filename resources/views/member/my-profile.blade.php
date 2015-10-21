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
                    <h3>My Profile</h3>
                <hr/>
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Basic Information</h3>
                        </div>
                        <div class="panel-body">
                            <p>
                                <img style="float: left; margin-right: 10px;" src="{{$member->avatar}}" class="avatar img-rounded" width="48" height="48">
                                <b>Name:</b> {{$member->name}} <br/>
                                <b>Email:</b> {{$member->email}}
                            </p>
                        </div>
                    </div>

                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">My Network</h3>
                        </div>
                        <div class="panel-body">
                            My connected members
                        </div>
                    </div>

                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Requests</h3>
                        </div>
                        <div class="panel-body">
                            Pending requests here!
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@stop


@section('js')
<script>
    var $userId = '{{$member->id}}';
    $('#add').on('click', function() {
        $.post( "/member/requestAdd", { userId: $userId, '_token': '{{csrf_token()}}'}).done(function( data ) {
            console.log( "Data Loaded: " + data );
        });
    });
</script>
@stop