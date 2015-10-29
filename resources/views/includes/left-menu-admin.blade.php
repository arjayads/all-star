<div class="bs-example">
    <div class="list-group">
        <a href="/admin" class="list-group-item {{Request::segment(2)==''?'active':''}}">
            <span class="glyphicon glyphicon-home"></span> Home
        </a>
        <a href="/admin/videos" class="list-group-item {{Request::segment(2)=='videos'?'active':''}}">
            <span class="glyphicon glyphicon-camera"></span> Training Videos
        </a>
        <a href="#" class="list-group-item">
            <span class="glyphicon glyphicon-calendar"></span> Calendar
        </a>
        <a href="#" class="list-group-item">
            <span class="glyphicon glyphicon-film"></span> Events
        </a>
        <a href="#" class="list-group-item">
            <span class="glyphicon glyphicon-blackboard"></span> Announcements
        </a>
    </div>
</div>