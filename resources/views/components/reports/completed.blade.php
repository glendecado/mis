<div class="bg-white shadow-xl rounded-xl overflow-hidden h-full">
    <div class="px-6 py-5 border-b border-gray-100">
        <h2 class="text-2xl font-semibold text-gray-800">Completed Tasks For This Month</h2>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Task ID</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Concerns</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Categories</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Completed At</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($this->requests() as $req)
                <tr class="hover:bg-gray-50 transition-colors duration-150">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800">#{{ $req->id }}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $req->concerns }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($req->categories->pluck('category.name')->filter()->count() > 0 || $req->categories->pluck('ifOthers')->filter()->count() > 0)
                        <div class="flex flex-wrap gap-2">
                            @foreach($req->categories->pluck('category.name')->filter() as $category)
                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800">{{ $category }}</span>
                            @endforeach

                            @foreach($req->categories->pluck('ifOthers')->filter() as $custom)
                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-purple-100 text-purple-800">{{ $custom }}</span>
                            @endforeach
                        </div>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ \Carbon\Carbon::parse($req->updated_at)->format('M d, Y h:i A') }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>