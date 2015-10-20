@extends('layout.app')

@section('content')
    <div class="container-fluid  top-buffer">
        <div class="row">
            <div class="col-md-7 col-md-offset-2">
                @if(isset($notFound))
                    <div class="alert alert-danger">
                        Member you are looking for is not available!
                    </div>
                @else
                    Other member's page
                @endif
            </div>
        </div>
    </div>
@stop