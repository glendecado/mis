<div>
    <center class="h-[565px]">
        {{--search--}}
        <label for="search">Search:</label>
        <input name="search" type="text" wire:model.live="search">
        <br>
        <br>
        <br>
        <table>

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Role</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{$user->id}}</td>
                    <td>{{$user->role}}</td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>
                        <button @click="if (confirm('Are you sure you want to delete this user?')) $dispatch('user-delete', { id: '{{$user->id}}' })">Delete</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>


    </center>
    <div>
        {{--pagination imported from vender/pagination/mis.blade.php--}}
        {{$users->links('vendor.pagination.mis') }}

    </div>
</div>