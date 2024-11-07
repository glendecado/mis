@include('livewire.admin.sidebar-admin')
<div class="request-containder">

    <div class="">
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
                <div class="input">{{$req->created_at->format('h:i A')}}</label>
                </div>
            </div>
        </div>



        <div class="y md:x gap-2">
            <div class="y w-full">
                <label for="">College</label>
                <div class="input">{{$req->faculty->college}}</div>
            </div>

            <div class="y w-full">
                <label for="">Building:</label>
                <div class="input">{{$req->faculty->building}}</div>
            </div>

            <div class="y w-full">
                <label for="">Room</label>
                <div class="input">{{$req->faculty->room}}</label>
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
            <div class="y w-full cursor-pointer">


                <label for="">Priority Level:</label>
                <select name="" id="" class='input' wire:change="priorityLevelUpdate($event.target.value)">
                    <option class="bg-blue-500" value="1" @if($req->priorityLevel == 1) selected @endif>Level 1</option>
                    <option class="bg-blue-500" value="2" @if($req->priorityLevel == 2) selected @endif>Level 2</option>
                    <option class="bg-blue-500" value="3" @if($req->priorityLevel == 3) selected @endif>Level 3</option>
                </select>

            </div>
        </div>







        <div>
            <label for="">Name:</label>
            <div class="input">{{$req->faculty->user->name}}</div>
        </div>



        <div>
            <label for="">Concern</label>
            <div class="input h-80">{{$req->concerns}}</div>
        </div>

   

        @switch($req->status)

            @case('waiting')
            <div class="float-right mt-2">
                <button class="button" wire:click="updateStatus('declined')">Decline</button>
                <button class="button" wire:click="updateStatus('pending')">Accept</button>
            </div>
            @break

            
            @case('pending')
                <div>
                    <label for="">Assigned To</label>
                    <div class="input ">

                        <livewire:task />
                    </div>
                </div>
            @break


            @case('resolved')
                <h1>Request Resoled</h1>
            @break


            @case('declined')
                <h1>Request Declined</h1>
            @break

        @endswitch

    </div>
</div>