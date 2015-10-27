@extends('layout.app')

@section('content')
    <div class="container-fluid  top-buffer">
        <div class="row">
            <div class="col-md-10 col-md-offset-1 no-padding">
                <div class="row">
                    <div class="col-md-3">
                        <div class="bs-example">
                            <div class="list-group">
                                <a href="/videos" class="list-group-item active">
                                    <span class="glyphicon glyphicon-camera"></span> Training Videos
                                </a>
                                <a href="#" class="list-group-item">
                                    <span class="glyphicon glyphicon-calendar"></span> Calendar
                                </a>
                                <a href="#" class="list-group-item">
                                    <span class="glyphicon glyphicon-film"></span> Events
                                </a>
                                <a href="#" class="list-group-item">
                                    <span class="glyphicon glyphicon-blackboard"></span> Announcements
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        @foreach($videos as $video)
                            <div class="col-md-4">
                                <div><h5 for="{{$video->title}}"> {{$video->title}}</h5></div>

                                <div align="center" class="embed-responsive embed-responsive-4by3">
                                    <video controls class="embed-responsive-item">
                                        <source src="/admin/videos/{{$video->id}}" type="{{$video->mime_type}}" type="video/*">
                                    </video>
                                </div>

                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
	</div>

	<div style="margin-bottom:100px"></div>
@stop