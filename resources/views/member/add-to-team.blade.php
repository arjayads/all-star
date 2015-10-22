@extends('layout.app')

@section('content')
    <div class="container-fluid  top-buffer">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <h3>Add team member</h3>
                <hr/>
                <form method="post" action="/member/addToTeam">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <div class="row">
                        <div class="col-md-1">
                            <label for="name" class="input-label">Name:</label>
                        </div>
                        <div class="col-md-5">
                            <input required="" type="text" class="form-control" placeholder="Enter name" id="name" name="name">
                        </div>
                        <div class="col-md-6">
                            <label id="message" class="red input-label hidden">Error Message</label>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 10px;">
                        <div class="col-md-1">
                            <label for="email" class="input-label">Email:</label>
                        </div>
                        <div class="col-md-5">
                            <input type="text" class="form-control" placeholder="Enter email" id="email" name="email">
                        </div>
                    </div>
                    <div class="row" style="margin-top: 10px;">
                        <div class="col-md-1">
                        </div>
                        <div class="col-md-5">
                            <button class="btn btn-primary" type="submit">Add</button>
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