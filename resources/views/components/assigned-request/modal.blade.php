<x-modal name="assign-task-modal">
    <div class="table-container">
        <table class="w-full">
            <thead class="table-header text-white bg-blue text-[16px]">
                <tr>
                    <th class="table-header-cell">Name</th>
                    <th class="table-header-cell">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($this->viewTechStaff() as $tech)
                @if(!in_array($tech->technicalStaff_id, $this->viewAssigned()))
                <tr>
                    <td class="table-row-cell text-[16px]">{{ $tech->user->name }}</td>
                    <td class="table-row-cell">
                        <div wire:loading.attr="disabled">

                            <button class="button text-white bg-blue text-[16px]"
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