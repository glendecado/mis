

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

            <livewire:task />

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

        <div class="input">
            <div
                class="bg-blue-700 rounded-full px-2 text-white"
                style="width: {{$req->progress}}%" ;>
                {{$req->progress}}%
            </div>
        </div>


        @if($req->progress == 100)
        <div class="flex justify-end gap-2">
            <button class="button" @click="$dispatch('open-modal','feedback-modal')">Feedback</button>
            <button class="button" @click="$dispatch('open-modal','rate')">Rate</button>
            <button class="button">Close</button>
        </div>
        @endif
    </div>
    <livewire:rate />
    <livewire:feedback />
</div>