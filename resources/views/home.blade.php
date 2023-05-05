<x-app-layout>
    <div class="py-2 sm:py-6">
        {{-- <div class="sm:max-w-2xl md:max-w-3xl lg:max-w-4xl mx-0 sm:mx-auto sm:px-6 lg:px-8"> --}}
        <div class="max-w-xl mx-0 sm:mx-auto sm:px-6 lg:px-8">
            {{-- <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div> --}}

            {{-- <div class="mt-2 bg-white dark:bg-black dark:text-white border-b border-t sm:border-x border-neutral-300 dark:border-neutral-800">
                <form method="post" action="/post">
                    <div class="p-2 pt-4 sm:p-4 px-4 sm:px-6 flex justify-start border-neutral-300 dark:border-neutral-800">
                        <figure class="mr-3 sm:mr-4 w-10 h-10 sm:w-14 sm:h-14 bg-black border-white object-scale-down overflow-hidden rounded-full shrink-0 flex flex-col justify-center select-none">
                            <img src="{{ route('profile_pic', Auth::id()) }}" class="max-h-20 object-contain" alt="" longdesc="">
                        </figure>
                        <div class="max-w-[85%] grow">
                            <div class="text-md sm:text-lg cursor-default break-words ">
                                <label for="tuit-input" class="hidden">Scrivi un tuit:</label>
                                <textarea
                                    id="tuit-input"
                                    name="content"
                                    placeholder="A cosa stai pensando?"
                                    rows="4"
                                    class="w-[100%] h-[80px] p-2 border border-neutral-300"
                                    required></textarea>
                            </div>
                            <div class="flex gap-4 mt-4 justify-between text-gray-500 font-light">
                                <label for="image-upload" class="hidden">
                                    Upload image
                                </label>
                                <input id="image-upload" name="image-upload" type="file" class=""/>
                                <button type="submit" class="py-2 px-4 border border-neutral-300 font-bold">Pubblica</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div> --}}
            @if (isset($showPublish) && $showPublish)
                <x-publish-post></x-publish-post>
            @endif



            @foreach ($posts as $post_id)
                <x-post :id="$post_id" :isEditPost="$isEditPost"></x-post>
            @endforeach
        </div>
    </div>
</x-app-layout>
