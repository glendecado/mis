
<button @click="if (confirm('Are you sure you want to delete this user?')) $dispatch('request-delete', { id: '{{$req->id}}' })">Delete</button>