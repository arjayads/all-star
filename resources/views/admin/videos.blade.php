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
                        @if(Session::has('notif'))
                            <div class="alert alert-info">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                {{Session::get('notif')}}
                            </div>
                        @endif

                        <div class="row" style="padding-left: 30px;">
                            <a href="/admin/videos/upload" class="btn btn-primary">Upload</a>
                        </div>
                        @foreach($videos as $video)
                            <div class="col-md-4">
                                <div><a href="/admin/videos/{{$video->id}}"><h5 for="{{$video->title}}"> {{$video->title}}</h5></a></div>
                                <div align="center" class="embed-responsive embed-responsive-4by3">
                                    <video controls class="embed-responsive-item">
                                        <source src="/admin/videos/{{$video->id}}" type="{{$video->mime_type}}">
                                    </video>
                                </div>
                                <div>
                                    <label><a href="{!! URL::to('/admin/videos/'.$video->id) !!}/edit" >Edit</a></label> | <label><a href="" class="delete" data-title="{!! $video->title !!}" data-id="{!! $video->id !!}" >Delete</a></label>
                                </div>
                            </div>
                        @endforeach
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