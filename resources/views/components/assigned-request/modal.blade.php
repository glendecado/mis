<x-modal name="assign-task-modal">
    <div class="table-container">
        <table class="w-full">
            <thead class="table-header" style="color: white; background-color: #2e5e91; ">
                <tr>
                    <th class="table-header-cell">ID</th>
                    <th class="table-header-cell">Name</th>
                    <th class="table-header-cell">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($this->viewTechStaff() as $tech)
                <tr>
                    <td class="table-row-cell">{{ $tech->user->id }}</td>
                    <td class="table-row-cell">{{ $tech->user->name }}</td>
                    <td class="table-row-cell">

                        <div wire:loading.class="hidden">
                            @if(!in_array($tech->technicalStaff_id, $this->viewAssigned()))
                            <button class="button mt-4" style="color: white; background-color: #2e5e91; "wire:click.prevent="assignTask('{{$tech->user->id}}')">Assign</button>
                            @else
                            <button class="button mt-4" style="color: white; background-color: #2e5e91; " wire:click.prevent="removeTask('{{$tech->user->id}}')">Remove</button>
                            @endif
                        </div>

                        <div wire:loading class="text-blue-900">
                            @if(!in_array($tech->technicalStaff_id, $this->viewAssigned()))
                            <button disabled class="button mt-4" style="color: white; background-color: #2e5e91;">Assign</button>
                            @else
                            <button disabled class="button mt-4" style="color: white; background-color: #2e5e91;">Remove</button>
                            @endif
                        </div>


                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>
</x-modal>