@extends('app')

@section('content')
  
   
<div class="container-fluid top-buffer">
    <div class="row">
        <div class="col-md-7 col-md-offset-2">      
            @foreach($videos as $video)
                <div class="col-md-4">                  
                    <div><h5 for="{{$video->title}}"> {{$video->title}}</h5></div>

                    <div align="center" class="embed-responsive embed-responsive-4by3">
                        <video controls class="embed-responsive-item">
                            <source src="/admin/videos/1" type="video/mp4">
                        </video>                    
                    </div>
                    <div>
                        <label><a href="{!! URL::to('/admin/videos/'.$video->id) !!}/edit" >Edit</a></label> | <label><a href="" class="delete" data-id="{!! $video->id !!}" >Delete</a></label>
                    </div>

                </div>
                 
            @endforeach
            
        </div>
    </div>
</div>

@stop