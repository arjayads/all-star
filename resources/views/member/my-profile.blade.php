@extends('layout.app')

@section('content')
    <div class="container-fluid  top-buffer">
        <div class="row">
            <div class="col-md-10 col-md-offset-1 no-padding">
                <div class="row">
                    <div class="col-md-3">
                        @include('includes.left-menu')
                    </div>
                    <div class="col-md-9">
                        <h3 style="margin-top: 0">My Profile</h3>
                        <hr/>
                        @if(Session::has('notif'))
                            <div class="alert alert-info">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                {{Session::get('notif')}}
                            </div>
                        @endif
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-md-9">
                                        <h3 class="panel-title">Basic Information</h3>
                                    </div>
                                    <div class="col-md-3">
                                        @if(in_array('Admin', Auth::user()->groups()))
                                            <a class="pull-right bordered-a " href="/admin/changePassword">Change password</a>
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
        </div>
    </div>

    <div style="margin-bottom:100px"></div>
@stop


@section('js')
    <script>

        var $myUserId = '{{$member->id}}';
        var $nyMame = '{{$member->name}}';
        var $myEmail = '{{$member->email}}';

        google.setOnLoadCallback(drawChart);
        function drawChart() {
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Name');
            data.addColumn('string', 'Upline');
            data.addColumn('string', 'ToolTip');


            $.get( "/ajax/find/downlines?parentUserId="+$myUserId).done(function( d ) {
                if (d.length == 0) {
                    $('#chart_div').addClass('alert alert-info').text("No team members yet!");
                } else {
                    var rows = [
                        [{v:$myUserId, f:$nyMame + ' <div class="member" style="font-style:italic">' + '' + '</div>'}, '', $myEmail]
                    ];
                    for(var idx=0; idx<d.length; idx++) {
                        var member = [{v: d[idx].id+"", f: d[idx].name + '<div class="' + (d[idx].social_id != null ? 'member' : 'non-member') +'"></div>'}, $myUserId,  d[idx].email];
                        rows.push(member);
                    }

                    data.addRows(rows);
                    var chart = new google.visualization.OrgChart(document.getElementById('chart_div'));
                    chart.draw(data, {allowHtml:true});


                    if (rows.length <= 2) {
                        $('.google-visualization-orgchart-table').css('max-width', "30%");
                    } else
                    if (rows.length <= 4) {
                        $('.google-visualization-orgchart-table').css('max-width', "70%");
                    } else {
                        $('.google-visualization-orgchart-table').css('max-width', "100%");
                    }

                    $('.member').closest('td').removeClass('google-visualization-orgchart-node').addClass('google-visualization-orgchart-node-red');
                    $('.non-member').closest('td').removeClass('google-visualization-orgchart-node').addClass('google-visualization-orgchart-node-blue');

                    google.visualization.events.addListener(chart, 'select', selectHandler);

                    function selectHandler(e) {
                        var selectedItem = chart.getSelection()[0];

                        if (selectedItem && selectedItem.row > 0) {
                            var key = data.getValue(selectedItem.row,0);
                            window.open('/member/profile?id=' + key, '_self').focus();
                        }
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