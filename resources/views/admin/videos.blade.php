@extends('layout.app')

@section('content')
    <div class="container-fluid top-buffer">
    <div class="row">
        <div class="col-md-7 col-md-offset-2">      
            @foreach($videos as $video)
                <div class="col-md-4">                  
                    <div><a href="/admin/videos/{{$video->id}}"><h5 for="{{$video->title}}"> {{$video->title}}</h5></a></div>
                    <div align="center" class="embed-responsive embed-responsive-4by3">
                        <video controls class="embed-responsive-item">
                            <source src="/admin/videos/{{$video->id}}" type="{{$video->mime_type}}">
                        </video>
                    </div>
                    <div>
                        <label><a href="{!! URL::to('/admin/videos/'.$video->id) !!}/edit" >Edit</a></label> | <label><a href="" class="delete" data-title="{!! $video->title !!}" data-id="{!! $video->id !!}" >Delete</a></label>
                    </div>

                </div>
                 
            @endforeach
            
        </div>
    </div>
</div>

@stop

@section('js')
    <script>
        $(function() {
            $('.delete').on('click', function(e) {
                e.preventDefault();

                var $data =  $(this).data();

                var res = confirm("You are about to delete a video: " + $data.title + '. Do you want to continue?');
                if (res) {

                    $.post("/admin/videos/delete/" + $data.id, { '_token': '{{csrf_token()}}' }, function(data){
                        if (data.error) {
                            alert(data.message);
                        } else {
                            window.location.reload();
                        }
                    }).fail(function() {
                        alert( "Something went wrong!" );
                    });
                }
            });
        });
    </script>
@stop