@extends('layout.app')

@section('content')
    <div class="container-fluid  top-buffer">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <h3>Add team member</h3>
                <hr/>
            </div>
        </div>
    </div>
@stop


@section('js')
<script>
    $('#add').on('click', function() {
        $.post( "/member/requestAdd", {'_token': '{{csrf_token()}}'}).done(function( data ) {
            if (data.success) {
                window.location.reload();
            }
        });
    });

</script>
@stop