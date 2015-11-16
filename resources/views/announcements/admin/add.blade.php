@extends('layout.app')

@section('css')
    <link href="/plugins/datepicker/datepicker3.css" rel="stylesheet">
@stop
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
                            <h4>Announcements</h4>
                            @if($errors->any())
                                <div class="alert-danger alert">
                                    <ul>
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form method="POST" enctype="multipart/form-data" action="/announcements/store">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                               
                                <div class="form-group ">
                                    <textarea required="" rows="5" style="width: 100%"
                                              id="description" name="description">{{ Input::old('description') }}</textarea>
                                </div>

                                <div class="form-group ">
                                    <label for="description">Add images: <span class="red">Images larger than 5 mb will not be saved</span></label><br/>
                                    <input type="file" id="file" name="files[]" multiple="multiple" accept="image/*" />
                                </div>

                                <div class="form-group">
                                    <input class="btn btn-primary" type="submit" value="Add">
                                    <input id="reset" class="btn btn-default" type="reset" value="Reset">
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
    <script type="text/javascript" src="/plugins/datepicker/datepicker.js"></script>
    <script>
        $(function() {

            var oldDate = "{{ Input::old('date') }}";

            $('.datepicker').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true,
                format: "mm/dd/yyyy"
            });

            var date = new Date();
            if (oldDate != '') {
                var d = oldDate.split("/");
                date = new Date(d[2],d[0]-1,d[1]); // it works
            }
            $('.datepicker').datepicker('setDate', date);
            $('.datepicker').datepicker('update');


            $('#reset').click(function(){
                window.location.reload();
            });
        });
    </script>
@stop