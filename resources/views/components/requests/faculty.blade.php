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
    <div class="w-full">
        <button class="button w-40 float-right" @click="$dispatch('open-modal', 'rateFeedback')">Rate & Feedback</button>
    </div>

    <x-modal name="rateFeedback">

        <div class="p-4">
            <div class="mb-4">
            <h1 class="text-black text-3xl font-semibold">Provide feedback and rating :)</h1> <!-- Made h1 blue -->
        </div>

        <div class="space-y-6"> <!-- Added space-y for consistent vertical spacing between sections -->
            <div>
                <h2 class="font-bold text-lg">Rate our service</h2>
                <div x-data="{ rating: 0, feedback : '', hoverRating: 0 }">
                    <div class="flex w-full justify-start gap-10 mt-4">
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

                    <div class="y mt-12 space-y-4"> <!-- Added space-y for consistent vertical spacing -->
                        <label class="font-bold text-lg">Share your feedback</label>
                        <textarea name="feedback" id="feedback" class="input mt-4 w-full" x-model="feedback"></textarea>
                    </div>

                    <button class="button float-end mt-4 mb-4"
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
