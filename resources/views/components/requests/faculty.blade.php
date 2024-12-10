<div class="request-containder">

    <div class="input">
        <div
            class="bg-blue-700 rounded-md px-2 text-white"
            style="width: {{$req->progress}}%" ;>
            {{$req->progress}}%
        </div>
    </div>

    @if($req->progress == 100)



    @if($req->rate == null )
    <button class="button w-40" @click="$dispatch('open-modal', 'rateFeedback')">Rate & Feedback</button>
    <x-modal name="rateFeedback">

        <div class="text-center">
            <span class="text-lg font-bold">Provide feedback and ratings</span>
        </div>


        <div>
            <span>Rate our service</span>
            <div x-data="{ rating: 0, feedback : '' }">
                <div class="flex">
                    <!-- Loop through 5 stars and set the rating -->
                    <template x-for="star in [1, 2, 3, 4, 5]" :key="star">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 cursor-pointer"
                            :class="{'text-yellow': star <= rating, 'text-gray-300': star > rating}"
                            fill="currentColor" viewBox="0 0 20 20" @click="rating = star">
                            <path d="M10 15.27l4.15 2.18a1 1 0 0 0 1.45-1.05l-.79-4.93 3.58-3.49a1 1 0 0 0-.55-1.71l-4.97-.72-2.22-4.5a1 1 0 0 0-1.8 0l-2.22 4.5-4.97.72a1 1 0 0 0-.55 1.71l3.58 3.49-.79 4.93a1 1 0 0 0 1.45 1.05L10 15.27z" />
                        </svg>
                    </template>
                </div>


                <div class="y">
                    <label>Share your feedback!</label>
                    <textarea name="" id="" class="input" x-model="feedback"></textarea>
                </div>

                <button class="button mt-4"
                    :disabled="rating === 0 || feedback === ''"
                    @click="$wire.feedbackAndRate(rating, feedback)">
                    Submit
                </button>
            </div>
        </div>
    </x-modal>
    @endif
    @endif
</div>