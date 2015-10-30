<div class="bs-example">
    <div class="list-group">
        <a href="/videos" class="list-group-item {{Request::segment(1)=='videos'?'active':''}}">
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
        <a href="/profile" class="list-group-item {{Request::segment(1)=='profile'?'active':''}}">
            <span class="glyphicon glyphicon-user"></span> Profile
        </a>
    </div>
</div>