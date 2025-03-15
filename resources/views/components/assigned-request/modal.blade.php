<x-modal name="assign-task-modal">
    <div class="table-container">
    <table class="w-full">
    <thead class="table-header" style="color: white; background-color: #2e5e91; font-size: 16px;">
    <tr>
        <th class="table-header-cell">Name</th>
        <th class="table-header-cell">Actions</th>
    </tr>
    </thead>
    <tbody>
    @foreach($this->viewTechStaff() as $tech)
    <tr>
        <td class="table-row-cell" style="font-size: 16px;">{{ $tech->user->name }}</td>
        <td class="table-row-cell">
            <div wire:loading.class="hidden">
                @if(!in_array($tech->technicalStaff_id, $this->viewAssigned()))
                <button class="button" style="color: white; background-color: #2e5e91; font-size: 16px;"
                    wire:click.prevent="assignTask('{{$tech->user->id}}')">Assign</button>
                @else
                <button class="button" style="color: white; background-color: #2e5e91; font-size: 16px;"
                    wire:click.prevent="removeTask('{{$tech->user->id}}')">Remove</button>
                @endif
            </div>

            <div wire:loading class="text-blue-900">
                @if(!in_array($tech->technicalStaff_id, $this->viewAssigned()))
                <button disabled class="button" style="color: white; background-color: #2e5e91; font-size: 16px;">Assign</button>
                @else
                <button disabled class="button" style="color: white; background-color: #2e5e91; font-size: 16px;">Remove</button>
                @endif
            </div>
        </td>
    </tr>
    @endforeach
    </tbody>
    </table>

    </div>
</x-modal>