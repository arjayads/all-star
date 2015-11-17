@if(count($entries) > 0)
    <table class="table table-bordered table-responsive table-striped">
        <thead>
        <th>Title</th>
        <th width="20%">Date</th>
        <th width="40%">Description</th>
        <th width="10%">Action</th>
        </thead>
        <tbody>
        @foreach($entries as $entry)
            <tr>
                <td>{{$entry->title}}</td>
                <td>{{(new DateTime($entry->date))->format('M d, Y')}}</td>
                <td>{{$entry->description}}</td>
                <td><a href="#" data-id="{{$entry->id}}">Edit</a> | <a href="#" data-id="{{$entry->id}}">Delete</a></td>
            </tr>
        @endforeach
        </tbody>
    </table>
@else
    <div class="alert-info alert">No entries for this date</div>
@endif