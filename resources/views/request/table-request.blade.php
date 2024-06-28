<table>
    <thead>
        <tr>
            <th>category</th>
            <th>concerns</th>
            <th>date</th>
            <th>time</th>
            <th>status</th>
            <th>action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($requests as $req)
        <tr>
            @php
            $created = explode(' ', $req->created_at);
            @endphp
            <td>{{$req->category}}</td>
            <td>{{$req->concerns}}</td>
            <td>{{$created[0]}}</td>
            <td>{{$created[1]}}</td>
            <td>{{$req->status}}</td>
            <td>view</td>
        </tr>
        @endforeach
    </tbody>
</table>