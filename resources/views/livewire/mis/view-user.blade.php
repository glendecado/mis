<div>
    <center class="h-[565px]">
        {{--search--}}

        <div class="max-w-md mx-auto">
            <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only ">Search</label>
            <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-blue-900" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </div>
                <input type="search" id="default-search" class="block w-full p-4 ps-10 text-sm text-gray-900  border-blue-900 border-2 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"  wire:model.live="search" />
            </div>
        </div>
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
                        {{--if you want to delete user--}}
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