@extends('layout.app')

@section('content')
    <div class="container-fluid top-buffer">
        <div class="row">
            <div class="col-md-10 col-md-offset-1 no-padding">
                <h3>Change Password</h3>
                <hr/>
                <form method="post" action="/admin/changePassword">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <div class="row">
                        <div class="col-md-2">
                            <label for="current" class="input-label">Current password:</label>
                        </div>
                        <div class="col-md-5">
                            <input required="" type="password" class="form-control" placeholder="Enter current password" id="current" name="current_password">
                        </div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-md-2">
                            <label for="new" class="input-label">New Password:</label>
                        </div>
                        <div class="col-md-5">
                            <input required="" type="password" class="form-control" placeholder="Enter new password" id="new" name="password">
                        </div>
                    </div>
                    <div class="row" style="margin-top: 10px;">
                        <div class="col-md-2">
                            <label for="repeat" class="input-label">Repeat New Password:</label>
                        </div>
                        <div class="col-md-5">
                            <input type="password" class="form-control" placeholder="Repeat new password" id="repeat" name="password_confirmation">
                        </div>
                    </div>
                    <div class="row" style="margin-top: 10px;">
                        <div class="col-md-2">
                        </div>
                        <div class="col-md-5">
                            <button class="btn btn-primary" type="submit">Submit</button>
                            <a class="btn btn-default" href="/profile">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop


@section('js')
<script>

    $('form').submit(function(event) {
        event.preventDefault();

        var formData = {
            'name'  : $('input[name=name]').val(),
            'email'  : $('input[name=email]').val(),
            '_token' : $('input[name=_token]').val()
        };

        // process the form
        $.ajax({
            type        : 'POST',
            url         : '/member/addToTeam',
            data        : formData,
            encode      : true
        }).done(function(data) {
            if (data.success) {
                window.location = "/profile"
            } else {
                $('#message').removeClass('hidden').text(data.message);
            }
        });
    });

</script>
@stop