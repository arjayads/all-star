@extends('layout.app')

@section('css')
    <link href="/plugins/datepicker/datepicker3.css" rel="stylesheet">
@stop
@section('content')
    <div class="container-fluid  top-buffer">
        <div class="row">
            <div class="col-md-10 col-md-offset-1 no-padding">
                <div class="row">
                    <div class="col-md-3">
                        @include('includes.left-menu')
                    </div>
                    <div class="col-md-9">
                        <div class="col-md-7">
                            <h4>Add new event</h4>
                            @if($errors->any())
                                <div class="alert-danger alert">
                                    <ul>
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form method="POST" enctype="multipart/form-data" action="/admin/videos/store">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                <div class="form-group">
                                    <label for="date">Date:</label><br/>
                                    <input required="" class="datepicker"
                                           type="text"  placeholder="Enter event date"
                                           class="input-sm form-control" id="date">
                                </div>
                                <div class="form-group ">
                                    <label for="title">Event title:</label>
                                    <input required="" class="form-control" name="title" type="text" id="title">
                                </div>
                                <div class="form-group ">
                                    <label for="location">Location:</label>
                                    <input required="" class="form-control" name="location" type="text" id="location">
                                </div>
                                <div class="form-group ">
                                    <label for="description">Description:</label><br/>
                                    <textarea rows="5" style="width: 100%" id="description" name="description"></textarea>
                                </div>

                                <div class="form-group">
                                    <input class="btn btn-primary" type="submit" value="Add">
                                    <input class="btn btn-default" type="reset" value="Clear">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@stop

@section('js')
    <script type="text/javascript" src="/plugins/datepicker/datepicker.js"></script>
    <script>
        $(function() {
            $('.datepicker').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true,
                format: "mm/dd/yyyy"
            });

            $('.datepicker').datepicker('setDate', new Date());
            $('.datepicker').datepicker('update');
            $('.datepicker').val('');

        });
    </script>
@stop