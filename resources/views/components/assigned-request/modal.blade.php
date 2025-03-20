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
                @if(!in_array($tech->technicalStaff_id, $this->viewAssigned()))
                <tr>
                    <td class="table-row-cell" style="font-size: 16px;">{{ $tech->user->name }}</td>
                    <td class="table-row-cell">
                        <div wire:loading.attr="disabled">

                            <button class="button" style="color: white; background-color: #2e5e91; font-size: 16px;"
                                wire:click.prevent="assignTask('{{$tech->user->id}}')">Assign</button>


                        </div>

                    </td>
                </tr>
                @endif
                @endforeach
            </tbody>
        </table>

    </div>
</x-modal>