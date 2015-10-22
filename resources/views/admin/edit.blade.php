@extends('layout.app')

@section('content')



    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">

                <h2>Updating {{$video->title}}</h2>
                @if($errors->any())
                    <div class="alert-danger alert">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" enctype="multipart/form-data" action="/admin/videos/update/{{$video->id}}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group ">
                        <label for="title">Video title:</label>
                        <input class="form-control" name="title" type="text" id="title" value="{{$video->title}}">
                    </div>

                    <div class="form-group">
                        <label for="type">Type:</label>
                        <select class="form-control col-xs-3" id="type" name="type">
                            <option value="Public" {{$video->type == 'Public' ? 'Selected' : ''}}>Public</option>
                            <option value="Private" {{$video->type == 'Private' ? 'Selected' : ''}}>Private</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="filename">Video:</label>
                        <input name="video" type="file" id="filename">
                    </div>

                    <div class="form-group">
                        <input class="btn btn-default btn-lg btn-primary" type="submit" value="Upload">
                    </div>
                </form>
            </div>
        </div>
    </div>


@stop
