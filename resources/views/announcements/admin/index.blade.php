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
                        @if(Session::has('notif'))
                            <div class="alert alert-info">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                {{Session::get('notif')}}
                            </div>
                        @endif

                        <div class="row" style="padding-left: 20px;">
                            <a href="/announcements/add" class="btn btn-primary">Add Announcements</a>
                        </div>
                        <div class="margin-bottom-10"></div>
                        @if(count($announcements) > 0)
                            <table class="table table-bordered table-responsive table-striped">
                                <thead>
                                    <th>Date</th>
                                    <th width="40%">Description</th>
                                </thead>
                                <tbody>
                                    @foreach($announcements as $announcement)
                                    <tr>
                                        <td><a href="/announcements/{{$announcement->id}}">{{$announcement->description}}</a></td>
                                        <td>{{(new DateTime($announcement->date))->format('M d, Y')}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="alert-info alert">No up coming announcements</div>
                        @endif
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