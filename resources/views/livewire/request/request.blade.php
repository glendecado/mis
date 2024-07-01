<div>
    <table border="1">
        <thead>
            <tr>
                <th>Request ID</th>
                <th>Faculty ID</th>
                <th>Category</th>
                <th>Concerns</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($request as $req)
            <tr>
                <td>{{$req['id']}}</td>
                <td>{{$req['faculty_id']}}</td>
                <td>{{$req['category']}}</td>
                <td>{{$req['concerns']}}</td>
                <td>{{$req['status']}}</td>
                <td>@include('request.delete-request')</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @include('request.add-request')
</div>