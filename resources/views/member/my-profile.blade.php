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
                        <script type="text/javascript" src="https://www.google.com/jsapi?autoload={'modules':[{'name':'visualization','version':'1.1','packages':['orgchart']}]}"></script>
                        <div id="chart_div"></div>
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

    var $myUserId = '{{$member->id}}';
    var $nyMame = '{{$member->name}}';
    var $nyEmail = '{{$member->email}}';

    google.setOnLoadCallback(drawChart);
    function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Name');
        data.addColumn('string', 'Upline');


        $.get( "/ajax/find/downlines?parentUserId="+$myUserId).done(function( d ) {
            if (d.length == 0) {
                $('#chart_div').addClass('alert alert-info').text("No team members yet!");
            } else {
                var rows = [
                    [{v:$myUserId, f:$nyMame + '<div style="color:blue; font-style:italic">' + $nyEmail + '</div>'}, '']
                ];
                for(var idx=0; idx<d.length; idx++) {
                    var member = [{v: d[idx].name, f: d[idx].name + '<div style="color:blue; font-style:italic">' +  d[idx].email +'</div>'}, $myUserId]
                    rows.push(member);
                }

                data.addRows(rows);
                var chart = new google.visualization.OrgChart(document.getElementById('chart_div'));
                chart.draw(data, {allowHtml:true});


                if (rows.length <= 2) {
                    $('.google-visualization-orgchart-table').css('max-width', "30%");
                } else
                if (rows.length <= 3) {
                    $('.google-visualization-orgchart-table').css('max-width', "50%");
                }
            }

        });
    }



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