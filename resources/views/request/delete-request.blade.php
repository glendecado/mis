
<button @click="if (confirm('Are you sure you want to delete this user?')) $dispatch('request-delete', { id: '{{$request->id ?? ''}}' })">Delete</button>