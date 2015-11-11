@extends('layout.app')

@section('css')
    <link href="/plugins/zabuto/zabuto_calendar.min.css" rel="stylesheet">
    <style>
        .modal-backdrop {
            z-index: 0 !important;
        }
    </style>
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
                        <div class="col-md-12">
                            <h4>Setup Calendar</h4>
                            @if($errors->any())
                                <div class="alert-danger alert">
                                    <ul>
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div id="my-calendar"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div id="cal-modal" class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="cal-modal-title"></h4>
              </div>
              <form id="form" method="POST" enctype="multipart/form-data" action="/admin/calendar/add">
                <div class="modal-body">
                   <input type="hidden" name="_token" value="{{ csrf_token() }}">

                   <div class="form-group ">
                       <label for="title">Title:</label>
                       <input required="" class="form-control"
                              value=""
                              name="title" type="text" id="title">
                   </div>

                   <div class="form-group ">
                       <label for="description">Description:</label><br/>
                       <textarea required="" rows="5" style="width: 100%" id="description" name="description"></textarea>
                   </div>

                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input class="btn btn-primary" type="submit" value="Save">
                  </div>
              </form>
            </div>
          </div>
        </div>

    </div>
@stop

@section('js')
    <script type="text/javascript" src="/plugins/zabuto/zabuto_calendar.min.js"></script>
    <script>
        $(function() {

             $("#my-calendar").zabuto_calendar({
                 cell_border: true,
                 today: true,
                 weekstartson: 0,
                 action: function () {
                     return dateClicked(this.id);
                 }
             });

            function dateClicked(id) {
                var d = $("#" + id).data("date");
                var date = new Date(d);

                $('#cal-modal-title').text($.datepicker.formatDate("MM d, yy", date));

                $("#cal-modal").modal("show");
                return true;
            }
        });
    </script>
@stop