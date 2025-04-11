<table class="min-w-full h-full border border-gray-200 shadow-sm rounded-lg overflow-hidden bg-white">
    <thead class="bg-gray-100 text-gray-600 text-sm uppercase tracking-wider">
        <tr>
            <th class="px-6 py-3 text-left">Category</th>
            <th class="px-6 py-3 text-left">Total Assigned</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-gray-100 text-gray-700 text-sm">
        @foreach($this->categories as $name => $count)
        <tr class="hover:bg-gray-50 transition">
            <td class="px-6 py-4 font-medium">{{ $name }}</td>
            <td class="px-6 py-4">{{ $count }}</td>
        </tr>
        @endforeach
    </tbody>
</table>