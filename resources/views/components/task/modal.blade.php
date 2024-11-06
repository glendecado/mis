<x-modal name="assign-task-modal">
    <div class="table-container">
        <table class="w-full">
            <thead class="table-header">
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

                        @if(!in_array($tech->technicalStaff_id, $this->viewAssigned()))
                        <button class="button" wire:click.prevent="assignTask('{{$tech->user->id}}')">Assign</button>
                        @else
                        <button class="button" wire:click.prevent="removeTask('{{$tech->user->id}}')">Remove</button>
                        @endif
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>
</x-modal>