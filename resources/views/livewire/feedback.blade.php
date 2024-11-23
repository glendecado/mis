<?php

use App\Events\RequestEvent;
use App\Models\Feedback;
use App\Models\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Route;

use function Livewire\Volt\{mount, state};

state('id');
state('feedback');

$addFeedback = function () {
    $task = Task::where('request_id', session('requestId'))->get();
    

    foreach($task as $t){

        RequestEvent::dispatch($t->technicalStaff_id);
    }


    $feedback = Feedback::create([

        'request_id' => session('requestId'),
        'feedBack' => $this->feedback

    ]);

    $this->reset();
    $this->dispatch('success', 'feedback sent');

};


$viewFeedback = function () {
    return Feedback::where('request_id', session('requestId'))->orderBy('created_at', 'desc')->get();
};


$deleteFeedback = function () {};


?>

<div x-data="{feedback : @entangle('feedback')}">


        <div class="h-full w-full relative flex flex-col items-end rounded-md gap-2">

            <div class="flex flex-col w-full justify-end max-h-96 overflow-y-auto rounded-md">
                <div class="overflow-x-auto flex flex-col-reverse gap-5">
                    @foreach($this->viewFeedback() as $feedback)
                    <div class="mr-2 text-right break-words bg-slate-200 shadow-lg h-fit rounded-lg p-5 text-wrap">
                        <p>{{ $feedback->feedBack }}</p>
                        <span class="font-thin text-sm">{{ $feedback->created_at }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            @if(Auth::user()->role == 'Faculty')
            <div class="w-full flex">
                <textarea
                    type="text"
                    class="resize-none h-fit max-h-54 px-4 py-2 input basis-full break-words text-left overflow-y-auto"
                    x-model="feedback"
                    x-ref="textarea"
                    x-on:input="$refs.textarea.style.height = 'auto'; $refs.textarea.style.height = $refs.textarea.scrollHeight + 'px';"
                    placeholder="Enter your feedback here..."></textarea>
                <button @click="$wire.addFeedback()" class="w-10 flex items-center justify-center">

                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                        <path d="M3.478 2.404a.75.75 0 0 0-.926.941l2.432 7.905H13.5a.75.75 0 0 1 0 1.5H4.984l-2.432 7.905a.75.75 0 0 0 .926.94 60.519 60.519 0 0 0 18.445-8.986.75.75 0 0 0 0-1.218A60.517 60.517 0 0 0 3.478 2.404Z" />
                    </svg>


                </button>
            </div>

            @endif
        </div>
        <div
        x-init="Echo.private('request-channel.{{session('user')['id']}}')
            .listen('RequestEvent', (e) => {
                $wire.$refresh();
                console.log('connected');
            });
     ">

    </div>



</div>