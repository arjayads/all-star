@extends('app')

@section('content')


    <div class="container-fluid">
        <div class="row">
            <div class="col-md-7 col-md-offset-2">

                {!! Form::open(['enctype' => 'multipart/form-data', 'files' => true, 'action' => ['AdminController@store']]) !!}

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
                    {!! Form::submit('Upload', ['class' => 'btn btn-default btn-lg btn-primary']) !!}
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
        </div>
    </div>

@stop
