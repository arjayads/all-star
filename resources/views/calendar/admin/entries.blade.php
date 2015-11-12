@if(count($entries) > 0)
    <table class="table table-bordered table-responsive table-striped">
        <thead>
        <th>Title</th>
        <th width="20%">Date</th>
        <th width="50%">Description</th>
        </thead>
        <tbody>
        @foreach($entries as $entry)
            <tr>
                <td>{{$entry->title}}</td>
                <td>{{(new DateTime($entry->date))->format('M d, Y')}}</td>
                <td>{{$entry->description}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@else
    <div class="alert-info alert">No entries for this date</div>
@endif