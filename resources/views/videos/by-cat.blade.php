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
                        <h4><b>{{$category->name}}</b> videos</h4>
                        @if($videos && count($videos) > 0)
                            @foreach($videos as $video)
                                <div class="col-md-4">
                                    <div><h5 for="{{$video->title}}"> {{$video->title}}</h5></div>
                                    <a href="/videos/prev/{{$video->id}}">
                                        <div align="center" class="embed-responsive embed-responsive-4by3">
                                            <video controls class="embed-responsive-item">
                                                <source src="/admin/videos/{{$video->id}}" type="{{$video->mime_type}}" type="video/*">
                                            </video>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        @else
                            <div class="alert alert-info">No videos available!</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div style="margin-bottom:100px"></div>
@stop