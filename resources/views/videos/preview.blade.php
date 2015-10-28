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
                        <h4><a href="/videos">Training Videos</a> > <a href="/videos/cat/{{$category->id}}">{{$category->name}}</a> > {{$video->title}}</h4>
                        <div class="embed-responsive embed-responsive-4by3">
                            <video controls class="embed-responsive-item" style="height: 83% !important;">
                                <source src="/admin/videos/{{$video->id}}" type="{{$video->mime_type}}">
                            </video>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div style="margin-bottom:100px"></div>
@stop