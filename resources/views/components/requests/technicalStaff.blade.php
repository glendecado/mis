<div class="y mt-2 w-[600px] gap-2  bg-blue-500/90 p-3 rounded-md text-blue-50 basis-full flex-none">

    <div class="y md:x gap-2">

        <div class="y w-full">
            <label for="">Request id:</label>
            <div class="input">{{$req->id}}</div>
        </div>

        <div class="y w-full">
            <label for="">Date:</label>
            <div class="input">{{$req->created_at->format('Y-m-d')}}</div>
        </div>

        <div class="y w-full">
            <label for="">Time</label>
            <div class="input">{{$req->created_at->format('h:i A')}}
            </div>
        </div>

    </div>





    <div class="y md:x gap-2 w-full">
        <div class="y w-full">
            <label for="">Category</label>
            <div class="input">{{$req->category->name}}</div>
        </div>
        <div class="y w-full">
            <label for="">Status</label>
            <div class="input">{{$req->status}}</div>
        </div>
    </div>




    <div>
        <label for="">Assigned to:</label>
        <div class="input">
            <livewire:task />
        </div>
    </div>

    <div>
        <label for="">Concern</label>
        <div class="input h-80">{{$req->concerns}}</div>
    </div>

    @if($req->status != 'ongoing')
    <div class="w-full">
        <button class="button float-right" wire:click.prevent="updateStatus('ongoing') ">Begin</button>
    </div>
    @else
    <livewire:task-list :category="$req->category_id" />
    <div class="input">
        <div
            class="bg-blue-700 rounded-full px-2"
            style="width: {{$req->progress}}%";
            >
            {{$req->progress}}%
        </div>
    </div>
    @endif
</div>