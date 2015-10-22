@extends('layout.app')

@section('content')
    <div class="container-fluid  top-buffer">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
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
                        <div class="row">
                            <div class="col-md-9" style="padding-top: 7px !important;">
                                <div><h3 class="panel-title">My Team</h3></div>
                            </div>
                            <div class="col-md-3">
                                <div class="pull-right"><a href="/member/addToTeam" class="btn btn-success">Add member</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        @if($team && count($team) > 0)
                            <div id="notif-team" class="hidden">
                                notif-team
                            </div>

                            <table id="requests-table" class="table table-responsive table-bordered table-striped">
                                <thead>
                                <tr>
                                    <td>Name</td>
                                    <td width="15%"></td>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($team as $person)
                                    <tr>
                                        <td><img src="{{$person->avatar}}" alt=""  class="avatar img-rounded" width="36" height="36"> {{$person->name}}</td>
                                        <td style="padding-top: 15px;">
                                            <a href="/member/profile?id={{$person->id}}" style="cursor: pointer">View</a> |
                                            <a data-userid="{{$person->id}}" class="remove-member" style="cursor: pointer">Remove</a>
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        @else
                            No team members yet!
                        @endif
                    </div>
                </div>

                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Requests</h3>
                    </div>
                    <div class="panel-body">
                        @if($requests)
                            <div id="notif-request" class="hidden">
                                Notifs here!
                            </div>

                            <table id="requests-table" class="table table-responsive table-bordered table-striped">
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
            </div>
        </div>
    </div>
@stop


@section('js')
<script>

    $('.response').on('click', function(e) {
        e.preventDefault();

        var row = $(this).closest('tr');
        var command = $(this).text();
        var $userId = $(this).data('userid');


        $.post( "/member/requestProcess", {command: command, userId: $userId, '_token': '{{csrf_token()}}'}).done(function( data ) {
            $('#notif-request').removeClass();
            $('#notif-request').addClass('alert');
            $('#notif-request').text(data.message);

            if (data.success) {
                $('#notif-request').addClass('alert-success');
                row.remove();
            } else {
                $('#notif-request').addClass('alert-danger');
            }
        });
    });

    $('.remove-member').on('click', function(e) {
        e.preventDefault();

        var row = $(this).closest('tr');
        var $userId = $(this).data('userid');

        $.post( "/member/removeTeamMember", {userId: $userId, '_token': '{{csrf_token()}}'}).done(function( data ) {
            $('#notif-team').removeClass();
            $('#notif-team').addClass('alert');
            $('#notif-team').text(data.message);

            if (data.success) {
                $('#notif-team').addClass('alert-success');
                row.remove();
            } else {
                $('#notif-team').addClass('alert-danger');
            }
        });
    });

</script>
@stop