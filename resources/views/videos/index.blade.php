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
                        @foreach($categories as $key => $cat)
                            <div class="col-md-4">
                                <a href="/videos/cat/{{$key}}">
                                    <div class="jumbotron embed-responsive embed-responsive-4by3">
                                        <div style="margin-top: 60%" class="text-center">
                                            {{$cat}}
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
	</div>

	<div style="margin-bottom:100px"></div>
@stop