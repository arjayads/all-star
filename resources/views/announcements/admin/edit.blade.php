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
                            <h4>Edit: {{$announcement->title}}</h4>
                            @if($errors->any())
                                <div class="alert-danger alert">
                                    <ul>
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form id="form" method="POST" enctype="multipart/form-data" action="/announcements/update/{{$announcement->id}}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                               
                                <div class="form-group ">
                                    <label for="description">Description:</label><br/>
                                    <textarea required="" rows="5" style="width: 100%"
                                              id="description" name="description">{{ Input::old('description') ?: $announcement->description }}</textarea>
                                </div>

                                @if(count($images))
                                    <div class="form-group ">
                                        <label for="description">Current Images:</label><br/>
                                        <ul style="padding-top: 6px; white-space: nowrap;" class="list-unstyled">
                                            @foreach($images as $image)
                                                <div class="col-md-4" style="padding-left: 0; margin-top: 10px;">
                                                    <a href="/admin/events/image/{{$announcement->id}}/{{$image->id}}">
                                                        <div title="{{$image->original_filename}}"
                                                             class="jumbotron embed-responsive embed-responsive-4by3"
                                                             style="margin-bottom: 5px !important; background-size: cover; background-image: url('/admin/events/image/{{$announcement->id}}/{{$image->id}}/thumb')">
                                                        </div>
                                                    </a>
                                                    <div class="remove-image" data-imageid="{{$image->id}}" ><label><a href="">Remove</a></label></div>
                                                </div>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <div class="form-group ">
                                    <label for="description">Add images: <span class="red">Images larger than 5 mb will not be saved</span></label><br/>
                                    <input type="file" id="file" name="files[]" multiple="multiple" accept="image/*" />
                                </div>

                                <div class="form-group">
                                    <input class="btn btn-primary" type="submit" value="Update">
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

            var oldDate = "{{ Input::old('date') ?: $announcement->date }}";
            var imagesRemoved = [];
            var images = '<?php echo json_encode($images) ?>';
            images = $.parseJSON(images);

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
                if (d.length > 1) {
                    date = new Date(d[2],d[0]-1,d[1]); // it works
                } else {
                    d = oldDate.split("-"); // for mysql format date
                    date = new Date(d[0], d[1]-1, d[2]); // it works
                }
            }
            $('.datepicker').datepicker('setDate', date);
            $('.datepicker').datepicker('update');


            $('#reset').click(function(){
                window.location.reload();
            });


            $('.remove-image').click(function(e){
                e.preventDefault();

                var imageid = $(this).data('imageid');

                // remove from list
                for(var x=0; x<images.length; x++) {
                    if (images[x].id == imageid) {

                        var pdiv = $(this).parent('div');
                        pdiv.fadeOut(500,function(){
                            pdiv.remove();
                        });

                        imagesRemoved.push(images[x]);
                        images.splice(x, 1);
                        return;
                    }
                }
            });

            $( "#form" ).submit(function( e ) {
                if (imagesRemoved.length > 0) {
                    imagesRemoved.forEach(function(image) {
                    // append removed images
                    var el = $('<input />').attr('type', 'hidden')
                              .attr('name', "rem_files[]")
                              .attr('value', image.id);
                        el.appendTo($('#form'));
                    });
                }

                return true;
            });
        });
    </script>
@stop