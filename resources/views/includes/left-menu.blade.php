<div class="bs-example">
    <div class="list-group">
        @if(in_array('Admin', Auth::user()->groups()))
            <a href="/admin" class="list-group-item {{Request::segment(1)=='admin' && Request::segment(2)==''?'active':''}}">
                <span class="glyphicon glyphicon-home"></span> Home
            </a>

            <a href="/admin/videos" class="list-group-item {{Request::segment(2)=='videos'?'active':''}}">
                <span class="glyphicon glyphicon-camera"></span> Training Videos
            </a>

            <a href="/events" class="list-group-item {{Request::segment(2)=='events'?'active':''}}">
                <span class="glyphicon glyphicon-film"></span> Events
            </a>


            <a href="/calendar" class="list-group-item {{Request::segment(2)=='calendar'?'active':''}}">
                <span class="glyphicon glyphicon-calendar"></span> Calendar
            </a>
        @else
            <a href="/videos" class="list-group-item {{Request::segment(1)=='videos'?'active':''}}">
                <span class="glyphicon glyphicon-camera"></span> Training Videos
            </a>

            <a href="/events" class="list-group-item {{Request::segment(1)=='events'?'active':''}}">
                <span class="glyphicon glyphicon-film"></span> Events
            </a>

            <a href="/calendar" class="list-group-item {{Request::segment(1)=='calendar'?'active':''}}">
                <span class="glyphicon glyphicon-calendar"></span> Calendar
            </a>
        @endif

        <a href="/announcements" class="list-group-item">
            <span class="glyphicon glyphicon-blackboard"></span> Announcements
        </a>
        <a href="/profile" class="list-group-item {{Request::segment(1)=='profile'?'active':''}}">
            <span class="glyphicon glyphicon-user"></span> Profile
        </a>
    </div>
</div>
