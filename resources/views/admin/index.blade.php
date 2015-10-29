@extends('layout.app')

@section('content')
    <div class="container-fluid  top-buffer">
        <div class="row">
            <div class="col-md-10 col-md-offset-1 no-padding">
                <div class="row">
                    <div class="col-md-3">
                        @include('includes.left-menu-admin')
                    </div>
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="panel panel-default mg-b-10 bg-danger">
                                    <div class="panel-heading bg-transparent panel-heading-bdr-danger">
                                        <div class="panel-title text-white">Members</div>
                                    </div>
                                    <div class="panel-body">
                                        <div style="text-align: center; font-size: 65px;" class="ng-binding">348,034</div>
                                    </div>
                                    <div class="panel-footer bg-transparent bd-none panel-heading-bdr-danger">
                                        <ul class="list-inline mg-b-0">
                                            <li class="block clearfix"><span>This month:&nbsp;</span>
                                                <span class="pull-right ng-binding">624</span></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="panel panel-default mg-b-10 bg-info">
                                    <div class="panel-heading bg-transparent panel-heading-bdr-info">
                                        <div class="panel-title text-white">Videos</div>
                                    </div>
                                    <div class="panel-body">
                                        <div style="text-align: center; font-size: 65px;" class="ng-binding">723</div>
                                    </div>
                                    <div class="panel-footer bg-transparent bd-none panel-heading-bdr-info">
                                        <ul class="list-inline mg-b-0">
                                            <li class="block clearfix"><span>Public:&nbsp;</span>
                                                <span class="pull-right ng-binding">500</span></li>
                                            <li class="block clearfix"><span>Private:&nbsp;</span>
                                                <span class="pull-right ng-binding">224</span></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="panel panel-default mg-b-10 bg-success">
                                    <div class="panel-heading bg-transparent panel-heading-bdr-success">
                                        <div class="panel-title text-white">Upcoming Events</div>
                                    </div>
                                    <div class="panel-body">
                                        <div style="text-align: center; font-size: 65px;" class="ng-binding">3</div>
                                    </div>
                                    <div class="panel-footer bg-transparent bd-none panel-heading-bdr-success">
                                        <ul class="list-inline mg-b-0">
                                            <li class="block clearfix"><span>Previous events:&nbsp;</span>
                                                <span class="pull-right ng-binding">15</span></li>
                                        </ul>
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