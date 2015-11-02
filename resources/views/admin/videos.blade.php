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
                            <a href="/admin/videos/upload" class="btn btn-primary">Upload</a>
                        </div>
                        @foreach($videos as $video)
                            <div class="col-md-4" style="padding: 5px;">
                                <div class="jumbotron" style="padding: 15px;">
                                    <h5><a href="/admin/videos/{{$video->id}}">{{$video->title}}</a></h5>
                                    <div align="center" class="embed-responsive embed-responsive-4by3">
                                        <video controls class="embed-responsive-item">
                                            <source src="/admin/videos/{{$video->id}}" type="{{$video->mime_type}}">
                                        </video>
                                    </div>
                                    <div>
                                        <label><a href="{!! URL::to('/admin/videos/'.$video->id) !!}/edit" >Edit</a></label> | <label><a href="" class="delete" data-title="{!! $video->title !!}" data-id="{!! $video->id !!}" >Delete</a></label>
                                    </div>
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
            $('.delete').on('click', function(e) {
                e.preventDefault();

                var $data =  $(this).data();

                var res = confirm("You are about to delete a video: " + $data.title + '. Do you want to continue?');
                if (res) {

                    $.post("/admin/videos/delete/" + $data.id, { '_token': '{{csrf_token()}}' }, function(data){
                        if (data.error) {
                            alert(data.message);
                        } else {
                            window.location.reload();
                        }
                    }).fail(function() {
                        alert( "Something went wrong!" );
                    });
                }
            });
        });
    </script>
@stop