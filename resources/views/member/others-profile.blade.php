@extends('layout.app')

@section('css')
    <style>
        .google-visualization-orgchart-table {
            border-collapse: inherit !important;
            width: 100% !important;
        }

        .google-visualization-orgchart-connrow-medium {
            height: 25px !important;
        }
    </style>
@stop

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
                                    @elseif (isset($available) && $available)
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

    google.setOnLoadCallback(drawChart);
    function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Name');
        data.addColumn('string', 'Manager');
        data.addColumn('string', 'ToolTip');


        var array = [
            [{v:'Mike', f:'Mike<div style="color:red; font-style:italic">President</div>'}, '', 'The President'],
            [{v:'Jim', f:'Jim<div style="color:red; font-style:italic">Vice President</div>'}, 'Mike', 'VP'],
            [{v:'Jim1', f:'Jim<div style="color:red; font-style:italic">Vice President</div>'}, 'Mike', 'VP'],
            [{v:'Jim2', f:'Jim<div style="color:red; font-style:italic">Vice President</div>'}, 'Mike', 'VP']
        ];

        data.addRows(array);
        var chart = new google.visualization.OrgChart(document.getElementById('chart_div'));
        chart.draw(data, {allowHtml:true});


        if (array.length <= 2) {
            $('.google-visualization-orgchart-table').css('max-width', "30%");
        } else
        if (array.length <= 3) {
            $('.google-visualization-orgchart-table').css('max-width', "50%");
        }
    }

    var $userId = '{{$member->id}}';
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


</script>
@stop