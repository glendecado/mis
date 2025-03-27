@if($req->status == 'declined')
<h1 class="text-red-500">Request Declined</h1>
@elseif($req->status == 'waiting')
<h1 class="text-red-500">Waiting your request to accept</h1>
@elseif($req->status == 'pending')


<p class="mb-2 text-blue text-[18px]">Task Progress</p>

<div class="rounded-md">

    <div
        class="rounded-md p-2 text-white text-sm bg-[#3E7B27]" style="width: {{$req->progress}}%" ;>
        {{$req->progress}}%
    </div>

    @if($req->progress == 100)

    @if($req->rate == null )
    <div class="w-full">
        <button class="button w-40 float-right mt-4 text-white bg-blue text-[16px]" @click="$dispatch('open-modal', 'rateFeedback')">Rate & Feedback</button>
    </div>

    <x-modal name="rateFeedback">

        <div class="p-4">
            <div class="mb-4">
                <h1 class="text-center text-3xl font-semibold text-blue">We value your feedback 🌟</h1> <!-- Made h1 blue -->
            </div>

            <div class="space-y-6"> <!-- Added space-y for consistent vertical spacing between sections -->
                <div>
                    <h2 class="font-bold text-lg text-[#578FCA]">Rate our service</h2>
                    <div x-data="{ rating: 0, feedback : '', hoverRating: 0 }">
                        <div class="flex w-full justify-start gap-10 mt-2 rounded-md p-2 border-1 border-[#1e40af80]">
                            <!-- Loop through 5 stars and set the rating -->
                            <template x-for="star in [1, 2, 3, 4, 5]" :key="star">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-10 cursor-pointer text-center"
                                    :class="{
                                    'text-yellow': star <= (hoverRating || rating),
                                    'text-gray-300': star > (hoverRating || rating)
                                }"
                                    fill="currentColor" viewBox="0 0 20 20"
                                    @click="rating = star"
                                    @mouseover="hoverRating = star"
                                    @mouseleave="hoverRating = 0">
                                    <path d="M10 15.27l4.15 2.18a1 1 0 0 0 1.45-1.05l-.79-4.93 3.58-3.49a1 1 0 0 0-.55-1.71l-4.97-.72-2.22-4.5a1 1 0 0 0-1.8 0l-2.22 4.5-4.97.72a1 1 0 0 0-.55 1.71l3.58 3.49-.79 4.93a1 1 0 0 0 1.45 1.05L10 15.27z" />
                                </svg>
                            </template>
                        </div>

                        <div class="y space-y-2 mt-[30px]"> <!-- Added space-y for consistent vertical spacing -->
                            <label class="font-bold text-lg text-[#578FCA]">Write your feedback here</label>
                            <textarea name="feedback" id="feedback" class="input mt-2 w-full text-black text-[16px] font-[500]" x-model="feedback"></textarea>
                        </div>

                        <button class="w-full button mt-4 mb-4 p-2 rounded-md bg-blue text-white text-[16px]"
                            :disabled="rating === 0 || feedback === ''"
                            @click="$wire.feedbackAndRate(rating, feedback)">
                            Submit
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </x-modal>
    @endif
    @endif
</div>
@endif