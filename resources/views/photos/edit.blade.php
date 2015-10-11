@extends('layout.app')

@section('content')

    <div class="col-xs-6">
        {!! Form::model($video, ['method' => 'PATCH', 'enctype' => 'multipart/form-data', 'files' => true, 'action' => ['AdminController@update', $video->id]]) !!}

        <div class="form-group ">
            {!! Form::label('title','Video title:') !!}
            {!! Form::text('title', null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('type','Type:') !!}
            {!! Form::select('type', ['public' => 'Public', 'private' => 'Private'],  'Public', ['class' => 'form-control col-xs-3' ]) !!}
        </div>

        <div class="form-group">
            {!! Form::label('filename','Video:') !!}
            {!! Form::file('filename') !!}
        </div>

        <div class="form-group">
            {!! Form::submit('Upload', ['class' => 'btn btn-primary form-control']) !!}
        </div>

        {!! Form::close() !!}

        @if($errors->any())
            <ul class="alert-danger">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

    </div>

@stop