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
                            <div class="alert alert-info margin-bottom-10">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                {{Session::get('notif')}}
                            </div>
                        @endif
 
                        @if(count($events) > 0)
                        <div class="row">
                            @foreach($events as $event)
                                <div class="col-md-12">
                                    <div class="alert-info alert">Up coming events</div>
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                            <div class="row">
                                                <h4 style="padding-left: 10px;" class="panel-title">{{$event->title}}&nbsp;-&nbsp;{{(new DateTime($event->date))->format('M d, Y')}}</h4>
                                            </div>
                                        </div>
                                        <div class="panel-body" id="panel-{{$event->id}}">
                                            <div class="col-md-12 no-padding">
                                                <b>Location:</b> {{$event->location}}
                                            </div>
                                            <div id="images" class="col-md-12 no-padding">
                                                <p style="padding-top: 10px;"><b>Images:</b></p>
                                            </div>
                                            <div class="col-md-12  no-padding">
                                                <p><b>Description:</b></p>
                                                <p style="text-indent: 20px;">{{$event->description}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                             @endforeach
                        </div>
                        @else
                            <div class="alert-info alert">No up coming events</div>
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
            var events = '<?php echo json_encode($events) ?>';
            events = $.parseJSON(events);

            if (events.length) {
                events.forEach(function(ev) {
                    var eventId = ev.id;
                    $.get("/events/" + eventId + "/images", function(data){
                        if(data.length > 0) {
                            data.forEach(function(image) {
                            var imgUrl = "/events/image/"+eventId+"/"+image.file_id;
                            var imgUrlTh = imgUrl + "/thumb";
                                var box = "<div class='col-md-4' style='padding-left: 0;'>" +
                                           "<a target='_blank' title='" +image.original_filename+"' href='" +imgUrl+ "'> " +
                                               " <div title=''  class='jumbotron embed-responsive embed-responsive-4by3' " +
                                                   " style='background-size: cover; background-image: url("+imgUrlTh+")'> " +
                                               " </div> " +
                                           "</a> " +
                                        " </div>";

                                $(box).appendTo($('#panel-' + eventId + ' #images'));
                            })
                         }
                    });
                });
            }
        });
    </script>
@stop