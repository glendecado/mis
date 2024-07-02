<div>
    <table border="1">
        <thead>
            <tr>
                <th>Request ID</th>
                <th>Faculty ID</th>
                <th>Category</th>
                <th>Concerns</th>
                <th>Date</th>
                <th>Time</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reqs as $req)
            <tr>
                <td>{{$req['id']}}</td>
                <td>{{$req['faculty_id']}}</td>
                <td>{{$req['category']}}</td>
                <td>{{$req['concerns']}}</td>
                <td>{{date_format($req['created_at'], "Y/m/d")}}</td>
                <td>{{date_format($req['created_at'], "g:i a")}}</td>
                <td>{{$req['status']}}</td>
                <td>@include('request.view-request')</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
