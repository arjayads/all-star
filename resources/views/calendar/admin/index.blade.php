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
                            <h4>Calendar</h4>
                            <div id="notif" class="alert-danger alert hidden">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <span></span>
                            </div>
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
              <form id="form" method="POST" action="/admin/calendar/store">
                <div class="modal-body">
                   <input type="hidden" name="_token" value="{{ csrf_token() }}">
                   <input type="hidden" id="date" name="date" value="">

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
                 month: '{{\Carbon\Carbon::now()->month}}',
                 year: '{{\Carbon\Carbon::now()->year}}',
                 action: function () {
                     return dateClicked(this.id);
                 }
             });

            function dateClicked(id) {
                var d = $("#" + id).data("date");
                var date = new Date(d);

                $('#cal-modal-title').text($.datepicker.formatDate("MM d, yy", date));
                $('#date').val(d);

                $("#cal-modal").modal("show");
                return true;
            }

            $( "#form" ).submit(function( e ) {
                e.preventDefault();

                var postData = {
                    '_token': '{{csrf_token()}}',
                    'title': $('#title').val(),
                    'description': $('#description').val(),
                    'date': $('#date').val()
                }

                $.post("/admin/calendar/store", postData, function(data) {

                    $('#notif span').text(data.message);
                    if (data.error) {
                        $('#notif').removeClass().addClass('alert alert-danger');

                        if (data.hasOwnProperty('messages')) {
                            try {
                                var el = '<ul>';
                                for (var property in data.messages) {
                                    if (data.messages.hasOwnProperty(property)) {
                                        el = el + '<li>' + data.messages[property] + '</li>';
                                    }
                                }
                                el += '</ul>';

                                $('#notif span').html(el);
                            } catch (e) {
                                console.log(e);
                            }
                        }
                    } else {
                        $('#notif').removeClass().addClass('alert alert-success');
                        $('#notif').fadeOut(15000,function() {
                            $('#notif').addClass('hidden');
                            $('#notif span').text('');
                        });

                        $('#title').val('');
                        $('#description').val('');
                    }
                }).fail(function(data, a) {
                    $('#notif').removeClass().addClass('alert alert-danger');
                    $('#notif span').text('Something went wrong!');
                });

                $("#cal-modal").modal("hide");
            });
        });
    </script>
@stop