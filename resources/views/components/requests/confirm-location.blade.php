<div>
    <div class="y mb-2" x-data="{
        cl: false,
        site: @entangle('site'),
        officeOrBuilding: @entangle('officeOrBuilding'),
        room: @entangle('room')
    }">
        <fieldset class="border p-4 rounded-md flex justify-between items-center">
            <legend>Location</legend>
            <div>Site: <span x-text="site" class="font-bold"></span></div>
            <div>Office/Building: <span x-text="officeOrBuilding" class="font-bold"></span></div>
            <button @click="$dispatch('open-modal','edit-loc')">
                <x-icons.edit class="size-6"/>

            </button>
        </fieldset>
    </div>

</div>
