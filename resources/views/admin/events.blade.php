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
                            <a href="/admin/events/add" class="btn btn-primary">Add Event</a>
                        </div>
                        @foreach($events as $event)
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