@extends('layout.app')

@section('content')
    <div class="container-fluid  top-buffer">
        <div class="row">
            <div class="col-md-10 col-md-offset-1 no-padding">
                <div class="row">
                    <div class="col-md-3 col-sm-4">
                        @include('includes.left-menu')
                    </div>
                    <div class="col-md-9 col-sm-4">
                        <div class="row">
                            <div class="col-md-4 col-sm-3">
                                <div class="panel panel-default bg-danger">
                                    <div class="panel-heading bg-transparent panel-heading-bdr-danger">
                                        <div class="panel-title text-white">Members</div>
                                    </div>
                                    <div class="panel-body">
                                        <div style="text-align: center;font-size: 60px;" class="ng-binding">{{number_format($noOfMembers)}}</div>
                                    </div>
                                    <div class="panel-footer bg-transparent bd-none panel-heading-bdr-danger">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-3">
                                <div class="panel panel-default mg-b-10 bg-info">
                                    <div class="panel-heading bg-transparent panel-heading-bdr-info">
                                        <div class="panel-title text-white">Videos</div>
                                    </div>
                                    <div class="panel-body">
                                        <div style="text-align: center; font-size: 60px;" class="ng-binding">{{number_format($noOfVideos)}}</div>
                                    </div>
                                    <div class="panel-footer bg-transparent bd-none panel-heading-bdr-info">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-3">
                                <div class="panel panel-default mg-b-10 bg-success">
                                    <div class="panel-heading bg-transparent panel-heading-bdr-success">
                                        <div class="panel-title text-white">Upcoming Events</div>
                                    </div>
                                    <div class="panel-body">
                                        <div style="text-align: center; font-size: 60px;" class="ng-binding">{{number_format(0)}}</div>
                                    </div>
                                    <div class="panel-footer bg-transparent bd-none panel-heading-bdr-success">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@stop

@section('js')
    <script>
        $(function() {

        });
    </script>
@stop