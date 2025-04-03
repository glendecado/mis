<div class="w-full">
    <button class="button float-right mt-4 px-6 py-3 rounded-lg text-white bg-blue-600 hover:bg-blue-700 transition-colors duration-200 text-[16px] font-medium shadow-md" 
            @click="$dispatch('open-modal', 'rateFeedback')">
        Rate & Feedback
    </button>
</div>

<x-modal name="rateFeedback" maxWidth="xl">
    <div class="p-4 w-full">
        <div class="text-center mb-4">
            <h1 class="text-2xl font-bold text-blue-600">Help us improve your experience <span class="mt-4 text-yellow-400 text-2xl">🌟</span></h1>
        </div>

        <div class="space-y-6 bg-white rounded-xl p-4 shadow-sm">
            <div x-data="{ rating: 0, feedback: '', hoverRating: 0 }">
                <!-- Rating Section -->
                <div class="mb-6">
                    <h2 class="font-bold text-[16px] text-blue-600">How would you rate our service?</h2>
                    <div class="flex justify-center gap-2 p-4 mt-2 bg-gray-100 rounded-md">
                        <template x-for="star in [1, 2, 3, 4, 5]" :key="star">
                            <svg xmlns="http://www.w3.org/2000/svg" 
                                 class="h-12 w-12 cursor-pointer transition-transform duration-100 hover:scale-110"
                                 :class="{
                                     'text-yellow-500': star <= (hoverRating || rating),
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
                </div>

                <!-- Feedback Section -->
                <div class="space-y-2">
                    <label class="font-bold text-[16px] text-blue-600">Share your thoughts  😊</label>
                    <textarea name="feedback" 
                              id="feedback" 
                              class="w-full text-[16px] font-thin px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                              placeholder="What did you like or how can we improve?"
                              rows="4"
                              x-model="feedback"></textarea>
                </div>

                <!-- Submit Button -->
                <button class="button w-full mt-6 py-3 rounded-lg text-[16px] text-white font-medium transition-colors duration-200 shadow-md"
                        :class="{ 'opacity-50 cursor-not-allowed': rating === 0 || feedback === '' }"
                        :disabled="rating === 0 || feedback === ''"
                        @click="$wire.feedbackAndRate(rating, feedback)">
                    Submit Feedback
                </button>
            </div>
        </div>
    </div>
</x-modal>