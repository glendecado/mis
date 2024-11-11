<div class="request-parent">
    <button class="button mb-2" @click="$wire.deleteRequest({{$req->id}}); Livewire.navigate('/request/status=all')">Delete Request</button>
    <div class="request-containder">

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
            <div class="input h-80 break-all">{{$req->concerns}}</div>
        </div>

        <div>

            <div class="input">
                <div
                    class="bg-blue-700 rounded-full px-2 text-white"
                    style="width: {{$req->progress}}%" ;>
                    {{$req->progress}}%
                </div>
            </div>

        </div>
        
        @if($req->progress == 100)
        <div class="flex justify-end gap-2">
            <button class="button" @click="$dispatch('open-modal','feedback-modal')">Feed Back</button>
            <button class="button" @click="$dispatch('open-modal','rate')">Rate</button>
            <button class="button">Close</button>
        </div>
        @endif
    </div>


    <livewire:rate />
    <livewire:feedback />
</div>