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
                        <div class="alert-info alert"><h4 style="margin: 0"><b>Event:</b> {{$announcement->title}}</h4></div>
                        <div class="col-md-12">
                            
                            <div class="row">
                                <div class="col-md-2">
                                    <label class="input-label"><b>Date</b></label>
                                </div>
                                <div class="col-md-9">
                                    <label class="input-label">{{(new DateTime($announcement->created_at))->format('M d, Y')}}</label>

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2">
                                    <label class="input-label"><b>Description</b></label>
                                </div>
                                <div class="col-md-9">
                                    <p style="padding-top: 6px;">{{$announcement->description}}</p>

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
                                                   href="/announcements/image/{{$announcement->id}}/{{$image->file_id}}">
                                                    <div title="{{$image->original_filename}}"
                                                         class="jumbotron embed-responsive embed-responsive-4by3"
                                                         style="background-size: cover; background-image: url('/announcements/image/{{$announcement->id}}/{{$image->file_id}}/thumb')">

                                                    </div>
                                                </a>
                                            </div>
                                            @endforeach
                                    @else
                                        <label class="input-label">No attached images</label>
                                    @endif
                                </div>
                            </div>
                            <hr/>
                            @if(Auth::id() == $announcement->user_id)
                            <div class="row">
                                <div class="col-md-8"></div>
                                <div class="col-md-4 text-right">
                                    <a href="/announcements/{{$announcement->id}}/edit" style="cursor: pointer">Edit</a> |
                                    <a style="cursor: pointer" class="delete" data-title="{!! $announcement->description !!}" data-id="{!! $announcement->id !!}">Delete</a>
                                </div>
                            </div>
                            @endif
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
            $('.delete').on('click', function(e) {
                e.preventDefault();

                var $data =  $(this).data();

                var res = confirm("You are about to delete announcement: " + $data.title + '. Do you want to continue?');
                if (res) {

                    $.post("/announcements/delete/" + $data.id, { '_token': '{{csrf_token()}}' }, function(data){
                        if (data.error) {
                            alert(data.message);
                        } else {
                            window.location = '/announcements';
                        }
                    }).fail(function() {
                        alert( "Something went wrong!" );
                    });
                }
            });
        });
    </script>
@stop