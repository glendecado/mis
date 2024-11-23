<div class="request-parent flex gap-4 flex-col">



    <div class="w-full">
        <a href="/request?status=all" wire:navigate.hover>
            <div class="float-right border rounded-full size-8 flex-center">
                <x-icons.arrow direction="left" />
            </div>
        </a>

    </div>

    <div class="request-containder">

        <div class="w-full flex  justify-between items-center">

            <div class="x items-center gap-2">
                {{--img name status--}}

                {{--img--}}
                <img src="{{asset('storage/'.$req->faculty->user->img)}}" alt="" class="size-16 rounded-full">

                <div class="y">
                    {{--name--}}
                    <span class="text-lg font-bold">{{$req->faculty->user->name}}</span>
                    {{--Date--}}
                    <span class="text-sm">
                        Date: <span class="font-bold">{{$req->created_at->format('Y-m-d')}}</span>
                        Time: <span class="font-bold">{{$req->created_at->format('h:i A')}}</span>
                    </span>
                </div>
            </div>

            <div>
                status: <span class="font-bold">{{$req->status}}</span>
            </div>

        </div>

        <div class="y mt-2 gap-4">

            <div class="x justify-between ">

                <div>
                    Category: <span class="font-bold">{{$req->category->name}}</span>
                </div>


            </div>

            <fieldset class="border p-2 rounded-md">
                <legend>Location</legend>
                <div class="x gap-5 rounded-md">

                    <div>
                        College:
                        <span class="font-bold">{{$req->faculty->college}}</span>

                    </div>

                    <div>
                        Building:
                        <span class="font-bold">{{$req->faculty->building}}</span>
                    </div>

                    <div>
                        Room:
                        <span class="font-bold">{{$req->faculty->room}}</span>
                    </div>

                </div>
            </fieldset>



            @if($req->progress == 100)
            <fieldset class="border rounded-md p-2">
                <legend>Assigned To:</legend>
                <livewire:rate />
            </fieldset>
            <span class="text-[12px] font-thin -translate-y-3">
                "The request is completed. You can now rate the technical staff based on their performance."
            </span>

            @else
            <fieldset class="border rounded-md p-2">
                <legend>Assigned To:</legend>
                <livewire:task />
            </fieldset>
            @endif


            <div>
                Concern(s):
                <div class=" border p-3 shadow-lg h-56 overflow-auto rounded-md">
                    {{$req->concerns}}
                </div>
            </div>

        </div>

    </div>

    {{--task--}}
    <div class="request-containder">




        @if($req->progress == 100)
        <div class="gap-2">
            Share your feed back
            <livewire:feedback />
        </div>
        @else
        <div class="input">
            <div
                class="bg-blue-700 rounded-full px-2 text-white"
                style="width: {{$req->progress}}%" ;>
                {{$req->progress}}%
            </div>
        </div>
        @endif
    </div>





</div>