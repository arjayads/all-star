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
                            <h4>Edit: {{$event->title}}</h4>
                            @if($errors->any())
                                <div class="alert-danger alert">
                                    <ul>
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form method="POST" enctype="multipart/form-data" action="/admin/events/update/{{$event->id}}}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                <div class="form-group">
                                    <label for="date">Date:</label><br/>
                                    <input required="" class="datepicker"
                                           type="text"  placeholder="Enter event date"
                                           value="{{ Input::old('date')}}"
                                           class="input-sm form-control" id="date" name="date">
                                </div>
                                <div class="form-group ">
                                    <label for="title">Event title:</label>
                                    <input required="" class="form-control"
                                           value="{{ Input::old('title')  ?: $event->title }}"
                                           name="title" type="text" id="title">
                                </div>
                                <div class="form-group ">
                                    <label for="location">Location:</label>
                                    <input required="" class="form-control"
                                           value="{{ Input::old('location') ?: $event->location }}"
                                           name="location" type="text" id="location">
                                </div>
                                <div class="form-group ">
                                    <label for="description">Description:</label><br/>
                                    <textarea required="" rows="5" style="width: 100%"
                                              id="description" name="description">{{ Input::old('description') ?: $event->description }}</textarea>
                                </div>

                                @if(count($images))
                                    <div class="form-group ">
                                        <label for="description">Images:</label><br/>
                                        <ul style="padding-top: 6px; white-space: nowrap;" class="list-unstyled">
                                            @foreach($images as $image)
                                                <div class="col-md-4" style="padding-left: 0; margin-top: 10px;">
                                                    <a href="/admin/events/image/{{$event->id}}/{{$image->id}}">
                                                        <div title="{{$image->original_filename}}"
                                                             class="jumbotron embed-responsive embed-responsive-4by3"
                                                             style="margin-bottom: 5px !important; background-size: cover; background-image: url('/admin/events/image/{{$event->id}}/{{$image->id}}')">
                                                        </div>
                                                    </a>
                                                    <div><label><a class="remove-image" href="">Remove</a></label></div>
                                                </div>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <div class="form-group ">
                                    <label for="description">Add images: <span class="red">Images larger than 5 mb will not be saved</span></label><br/>
                                    <input type="file" id="file" name="files[]" multiple="multiple" accept="image/*" />
                                </div>

                                <div class="form-group">
                                    <input class="btn btn-primary" type="submit" value="Update">
                                    <input id="reset" class="btn btn-default" type="reset" value="Reset">
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

            var oldDate = "{{ Input::old('date') ?: $event->date }}";

            $('.datepicker').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true,
                format: "mm/dd/yyyy"
            });

            var date = new Date();
            if (oldDate != '') {
                var d = oldDate.split("/");
                if (d.length > 1) {
                    date = new Date(d[2],d[0]-1,d[1]); // it works
                } else {
                    d = oldDate.split("-"); // for mysql format date
                    date = new Date(d[0], d[1]-1, d[2]); // it works
                }
            }
            $('.datepicker').datepicker('setDate', date);
            $('.datepicker').datepicker('update');


            $('#reset').click(function(){
                window.location.reload();
            });


            $('.remove-image').click(function(e){
                e.preventDefault();
            });
        });
    </script>
@stop