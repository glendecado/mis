<center class="h-[450px]">
    <table  >
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
                <td>{{$req->category}}</td>
                <td>{{$req->concerns}}</td>
                <td>{{date('m/d/Y', strtotime($req->created_at))}}</td>
                <td>{{date('h:i:s a     ', strtotime($req->created_at))}}</td>
                <td>{{$req->status}}</td>
                <td>view</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </center>


    {{$requests->links('vendor.pagination.mis') }}