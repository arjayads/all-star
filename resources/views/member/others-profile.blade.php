@extends('layout.app')

@section('content')
    <div class="container-fluid  top-buffer">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @if(isset($notFound))
                    <div class="alert alert-danger">
                        Member you are looking for is not available!
                    </div>
                @else
                    <h3>Member Profile</h3>
                <hr/>
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-md-9" style="padding-top: 7px !important;">
                                    <div><h3 class="panel-title">Basic Information</h3></div>
                                </div>
                                <div class="col-md-3">
                                    @if (isset($request))
                                        <div class="pull-right"><button id="cancel" class="btn btn-success">Cancel request</button></div>
                                    @else
                                        <div class="pull-right"><button id="add" class="btn btn-default">Add</button></div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <p>
                                <img style="float: left; margin-right: 10px;" src="{{$member->avatar}}" class="avatar img-rounded" width="48" height="48">
                                <b>Name:</b> {{$member->name}} <br/>
                                <b>Email:</b> {{$member->email}}
                            </p>
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
            if (data.success) {
                window.location.reload();
            }
        });
    });

    $('#cancel').on('click', function() {
        $.post( "/member/requestCancel", { userId: $userId, '_token': '{{csrf_token()}}'}).done(function( data ) {
            if (data.success) {
                window.location.reload();
            }
        });
    });
</script>
@stop