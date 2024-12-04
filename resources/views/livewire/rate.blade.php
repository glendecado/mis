<?php

use App\Models\AssignedRequest;
use App\Models\Rate;
use App\Models\Request;
use App\Models\TechnicalStaff;

use function Livewire\Volt\{mount, state};

//
state(['rate', 'tasks']);

mount(function () {
    $this->tasks = AssignedRequest::where('request_id', session('requestId'))->with('technicalStaff')->with('rate')->get();
});

$addRate = function ($id, $FacultyRate) {


    $rate = Rate::where('task_id', $id)->first();

    if (is_null($rate)) {
        $createRate = Rate::Create([
            "task_id" => $id,
            "rate" => $FacultyRate,
        ]);
        $this->dispatch('success', 'Your rating has been successfully recorded.');
    } else {

        $rate->update(["rate" => $FacultyRate]);
        $rate->save();
        $this->dispatch('success', 'Your rating has been successfully updated.');
    }
};

$viewRate = function () {




}
?>

<div>

    @foreach($tasks as $task)

    <div class="flex justify-between pr-24">
        {{$task->technicalStaff->user->name}}
        <div x-data="{ hovered: 0, rating: {{ json_encode($task->rate->rate ?? 0)  }} }" class="flex space-x-1">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-8 cursor-pointer"
                :class="{'text-yellow': hovered >= 1 || rating >= 1, 'text-gray-300': hovered < 1 && rating < 1}"
                @mouseover="hovered = 1" @mouseleave="hovered = 0" @click="rating = 1"
                wire:click="addRate({{$task->id}},1)">

                <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clip-rule="evenodd" />
            </svg>

            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-8 cursor-pointer"
                :class="{'text-yellow': hovered >= 2 || rating >= 2, 'text-gray-300': hovered < 2 && rating < 2}"
                @mouseover="hovered = 2" @mouseleave="hovered = 0" @click="rating = 2"
                wire:click="addRate({{$task->id}},2)">
                >
                <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clip-rule="evenodd" />
            </svg>

            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-8 cursor-pointer"
                :class="{'text-yellow': hovered >= 3 || rating >= 3, 'text-gray-300': hovered < 3 && rating < 3}"
                @mouseover="hovered = 3" @mouseleave="hovered = 0" @click="rating = 3"
                wire:click="addRate({{$task->id}},3)">
                >
                <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clip-rule="evenodd" />
            </svg>

            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-8 cursor-pointer"
                :class="{'text-yellow': hovered >= 4 || rating >= 4, 'text-gray-300': hovered < 4 && rating < 4}"
                @mouseover="hovered = 4" @mouseleave="hovered = 0" @click="rating = 4"
                wire:click="addRate({{$task->id}},4)">
                <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clip-rule="evenodd" />
            </svg>

            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-8 cursor-pointer"
                :class="{'text-yellow': hovered >= 5 || rating >= 5, 'text-gray-300': hovered < 5 && rating < 5}"
                @mouseover="hovered = 5" @mouseleave="hovered = 0" @click="rating = 5"
                wire:click="addRate({{$task->id}},5)">
                >
                <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clip-rule="evenodd" />
            </svg>
        </div>
    </div>
    @endforeach

</div>