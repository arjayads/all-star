@extends('layout.app')

@section('css')
@stop

@section('content')
    <div class="container-fluid  top-buffer">
        <div class="row">
            <div class="col-md-10 col-md-offset-1 no-padding">
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
                                    @elseif (isset($available) && $available)
                                        <div class="pull-right"><button id="add" class="btn btn-default">Add</button></div>
                                    @elseif (isset($myMember) && $myMember)
                                        <div class="pull-right"><button id="remove" class="btn btn-danger">Remove from your team</button></div>
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
                            <h3 class="panel-title">Team</h3>
                        </div>
                        <div class="panel-body">
                            <script type="text/javascript" src="https://www.google.com/jsapi?autoload={'modules':[{'name':'visualization','version':'1.1','packages':['orgchart']}]}"></script>
                            <div id="chart_div"></div>
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
    var $nyMame = '{{$member->name}}';
    var $nyEmail = '{{$member->email}}';

    google.setOnLoadCallback(drawChart);
    function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Name');
        data.addColumn('string', 'Upline');


        $.get( "/ajax/find/downlines?parentUserId="+$userId).done(function( d ) {
            if (d.length == 0) {
                $('#chart_div').addClass('alert alert-info').text("No team members yet!");
            } else {
                var rows = [
                    [{v:$userId, f:$nyMame + '<div class="member" style="font-style:italic">' + $nyEmail + '</div>'}, '']
                ];
                for(var idx=0; idx<d.length; idx++) {
                    var member = [{v: d[idx].id, f: d[idx].name + '<div class="' + (d[idx].social_id != '' ? 'member' : 'non-member') +'" style="font-style:italic">' +  d[idx].email +'</div>'}, $userId]
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

    $('#add').on('click', function() {
        $.post( "/member/requestAdd", { userId: $userId, '_token': '{{csrf_token()}}'}).done(function( data ) {
            if (data.success) {
                if (data.isFbMember) {
                    window.location.reload();
                } else {
                    window.location = "/profile";
                }
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

    $('#remove').on('click', function() {
        $.post( "/member/removeTeamMember", { userId: $userId, '_token': '{{csrf_token()}}'}).done(function( data ) {
            if (data.success) {
                window.location.reload();
            }
        });
    });


</script>
@stop