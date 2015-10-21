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
                            @if($requests)
                                <table class="table table-responsive table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <td>Requested by</td>
                                        <td width="30%">Action</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($requests as $request)
                                        <tr>
                                            <td>{{$request->name}}</td>
                                            <td>
                                                <a data-userId="{{$request->requested_by_user_id}}" class="response" style="cursor: pointer">Approve</a> |
                                                <a data-userId="{{$request->requested_by_user_id}}" class="response" style="cursor: pointer">Disapprove</a>
                                            </td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            @else
                                No pending requests!
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@stop


@section('js')
<script>

    $('.response').on('click', function(e) {
        e.preventDefault();

        var command = $(this).text();
        var $userId = $(this).data('userid');


        $.post( "/member/requestProcess", {command: command, userId: $userId, '_token': '{{csrf_token()}}'}).done(function( data ) {
            console.log(data);
            if (data.success) {
                
            }
        });
    });
</script>
@stop