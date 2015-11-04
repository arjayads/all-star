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
                        <div class="col-md-7">
                            <h4>Add new event</h4>
                            @if($errors->any())
                                <div class="alert-danger alert">
                                    <ul>
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form method="POST" enctype="multipart/form-data" action="/admin/videos/store">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="form-group ">
                                    <label for="title">Video title:</label>
                                    <input required="" class="form-control" name="title" type="text" id="title">
                                </div>

                                <div class="form-group">
                                    <label for="type" style="padding-top: 10px;">Type:</label>
                                    <select required="" class="form-control col-xs-3" id="type" name="type">
                                        <option value="Public">Public</option>
                                        <option value="Private">Private</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="filename" style="padding-top: 10px;">Video:</label>
                                    <input required="" name="video" type="file" id="filename">
                                </div>

                                <div class="form-group">
                                    <input class="btn btn-primary" type="submit" value="Upload">
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