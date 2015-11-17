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
                        <div class="col-md-12" id="entries">

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
              <form id="form" method="POST" action="/calendar/store">
                <div class="modal-body">
                   <input type="hidden" name="_token" value="{{ csrf_token() }}">
                   <input type="hidden" id="calId" name="calId" value="">
                   <input type="hidden" id="date" name="date" value="">
                   <input type="hidden" id="user_id" name="user_id" value="{{ Auth::user()->id }}">
                   

                   <div class="form-group ">
                       <label for="title">Title:</label>
                       <input required="" class="form-control" value="" name="title" type="text" id="title">
                       <input required="" class="form-control" value="" name="date" type="hidden" id="date">
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

        <!-- Modal -->
        <div id="view-cal-modal" class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="cal-modal-title"></h4>
              </div>
              <form id="form" method="POST" action="/calendar/store">
                <div class="modal-body" id="view-entries">
                   
                   

                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>                    
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
            var today = '{{\Carbon\Carbon::today()}}';
            var month = '{{\Carbon\Carbon::now()->month}}';
            var year = '{{\Carbon\Carbon::now()->year}}';


             $("#my-calendar").zabuto_calendar({
                 cell_border: true,
                 weekstartson: 0,
                 month: month,
                 year: year,
                 action: function () {
                     return dateClicked(this.id);
                 },
                 action_nav: function () {
                     $('#entries').html('');
                 },
                 ajax: {
                     url: "/calendar/data"
                 }
             });

            function dateClicked(id) {
                var d = $("#" + id).data("date");
                $("#date").val(d);
                $.get("/calendar/entries?date="+d, function(data) {
                    if(data.status == 0)
                    {                        
                      $("#cal-modal").modal("show");
                    }else{
                      
                      var el = '<div>';
                      $.each(data.entries, function(val, row){
                            el += '<div class="form-group "><label>Date : '+row.date+ ' </label></div>';
                            el += '<div class="form-group "><label>Title :'+row.title+'</label></div>';
                            el += '<div class="form-group "><label>'+row.description+'</label></div>';
                            if(row.user_id == $("#user_id").val()){
                              el += '<div class="form-group "><label><a href="#" class="delete" data-id="'+row.id+'">Delete</a></label></div>';
                            }
                            el += '<div class="form-group "><hr /></div>';
                                

                        });
                      el += '</div>';
                      $("#view-entries").html(el);
                      $("#view-cal-modal").modal("show");                      
                    }
                });
            }

           
            $( "#view-entries" ).delegate( ".delete", "click", function(e) {
                e.preventDefault();

                var $data =  $(this).data();

                var res = confirm("You are about to delete schedule: " + '. Do you want to continue?');
                if (res) {

                    $.post("/calendar/delete/" + $data.id, { '_token': '{{csrf_token()}}' }, function(data){
                        if (data.error) {
                            alert(data.message);
                        } else {
                            window.location = '/calendar';
                        }
                    }).fail(function() {
                        alert( "Something went wrong!" );
                    });
                }
            });

            $( "#form" ).submit(function( e ) {
                e.preventDefault();

                var postData = {
                    '_token': '{{csrf_token()}}',
                    'title': $('#title').val(),
                    'description': $('#description').val(),
                    'date': $('#date').val(),
                    'calId': $('#calId').val()
                }

                $.post("/calendar/store", postData, function(data) {

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