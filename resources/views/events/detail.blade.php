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
                        <div class="alert-info alert"><h4 style="margin: 0"><b>Event:</b> {{$event->title}}</h4></div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-2">
                                    <label class="input-label"><b>Location</b></label>
                                </div>
                                <div class="col-md-9">
                                    <label class="input-label">{{$event->location}}</label>

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2">
                                    <label class="input-label"><b>Date</b></label>
                                </div>
                                <div class="col-md-9">
                                    <label class="input-label">{{(new DateTime($event->date))->format('M d, Y')}}</label>

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2">
                                    <label class="input-label"><b>Description</b></label>
                                </div>
                                <div class="col-md-9">
                                    <p style="padding-top: 6px;">{{$event->description}}</p>

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2">
                                    <label class="input-label"><b>Images</b></label>
                                </div>
                                <div class="col-md-10">

                                    @if(count($images))
                                            @foreach($images as $image)
                                            <div class="col-md-4" style="padding-left: 0;">
                                                <a title="{{$image->original_filename}}"
                                                   href="/admin/events/image/{{$event->id}}/{{$image->id}}">
                                                    <div title="{{$image->original_filename}}"
                                                         class="jumbotron embed-responsive embed-responsive-4by3"
                                                         style="background-size: cover; background-image: url('/admin/events/image/{{$event->id}}/{{$image->id}}')">

                                                    </div>
                                                </a>
                                            </div>
                                            @endforeach
                                    @else
                                        <label class="input-label">No attached images</label>
                                    @endif
                                </div>
                            </div>

                                {{--<img style="width: 50%;"--}}
                                     {{--src="/admin/events/image/{{$image->id}}"--}}
                                     {{--alt="{{$image->original_filename}}"/>--}}
                            <hr/>
                            <div class="row">
                                <div class="col-md-8">
                                </div>
                                <div class="col-md-4 text-right">
                                    <a href="/admin/events/{{$event->id}}/edit" style="cursor: pointer">Edit</a> |
                                    <a style="cursor: pointer">Delete</a>
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