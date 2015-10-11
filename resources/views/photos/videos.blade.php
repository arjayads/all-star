@extends('layout.app')

@section('content')


    <div class="form-group">
        {!! Form::label('type','Type:') !!}
        {!! Form::select('type', ['public' => 'Public', 'private' => 'Private'],  'Public', ['class' => 'form-control col-xs-3' ]) !!}
    </div>

    @foreach($videos as $video)
        <div class="col-md-4" data-type="{!! $video->type !!}">
            <label for="{{$video->title}}"> {{$video->title}}</label>
            <video width="320" height="240" controls>
                <source src="{!! URL::to('/files/videos/'. $video->id ) !!}.mp4" type="video/mp4">
            </video>
            <a href="{!! URL::to('/admin/videos/'.$video->id) !!}/edit" >Edit</a>
            <a href="" >Delete</a>
        </div>
    @endforeach

@stop