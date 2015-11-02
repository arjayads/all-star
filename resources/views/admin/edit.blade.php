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
                                    <input required="" class="form-control" name="title" type="text" id="title" value="{{$video->title}}">
                                </div>

                                <div class="form-group">
                                    <label for="category">Category:</label>
                                    <select required="" class="form-control col-xs-3" id="category" name="category_id">
                                        <option value="">Select category</option>
                                        @foreach ($categories as $key => $cat)
                                            <option {{$video->category_id == $key ? 'Selected' : ''}} value="{{$key}}">{{$cat}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="type" style="padding-top: 10px;">Type:</label>
                                    <select required="" class="form-control col-xs-3" id="type" name="type">
                                        <option value="Public" {{$video->type == 'Public' ? 'Selected' : ''}}>Public</option>
                                        <option value="Private" {{$video->type == 'Private' ? 'Selected' : ''}}>Private</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="filename" style="padding-top: 10px;">Video:</label>
                                    <input name="video" type="file" id="filename">
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