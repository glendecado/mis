<div>
    <table border="1">
        <thead>
            <tr>
                <th>Faculty ID</th>
                <th>Category</th>
                <th>Concerns</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($requestList as $srs)
            <tr>
                <td>{{$srs['faculty_id']}}</td>
                <td>{{$srs['category']}}</td>
                <td>{{$srs['concerns']}}</td>
                <td>{{$srs['status']}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @include('request.add-request')
</div>