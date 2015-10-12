@extends('app')

@section('content')
	<div class="page">
		<nav role="navigation" class="navbar"></nav>
		<!-- HOME BANNER -->

		<div class="home-banner">
			<h2 class="wow bounceInDown">We Build Business and We Build People</h2>
			<h3 class="wow bounceInDown">Allstar Innovators</h3>
		</div>
	</div>

    <div class="container-fluid  top-buffer">
		<div class="row">
			<div class="col-md-7 col-md-offset-2">
				@foreach($videos as $video)
					<div class="col-md-4">
						<div><h5 for="{{$video->title}}"> {{$video->title}}</h5></div>

						<div align="center" class="embed-responsive embed-responsive-4by3">
							<video controls class="embed-responsive-item">
								<source src="{!! URL::to('/files/videos/'. $video->id ) !!}.mp4" type="video/mp4">
							</video>
						</div>

					</div>
				@endforeach
			</div>
		</div>
	</div>

@stop