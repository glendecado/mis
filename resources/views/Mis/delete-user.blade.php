
        <button @click="if (confirm('Are you sure you want to delete this user?')) $dispatch('user-delete', { id: '{{$user->id}}' })">{{$user->id}}</button>