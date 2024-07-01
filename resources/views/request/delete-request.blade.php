@php
$id = $req['id'];
@endphp
<button @click="if (confirm('Are you sure you want to delete this user?')) $dispatch('request-delete', { id: '{{$id}}' })">Delete</button>