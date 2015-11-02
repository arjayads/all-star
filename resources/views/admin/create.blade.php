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
                            <h4>Upload new video</h4>
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
                                    <label for="category">Category:</label>
                                    <select required="" class="form-control col-xs-3" id="category" name="category_id">
                                        <option value="">Select category</option>
                                        @foreach ($categories as $key => $cat)
                                            <option value="{{$key}}">{{$cat}}</option>
                                        @endforeach
                                    </select>
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

        });
    </script>
@stop