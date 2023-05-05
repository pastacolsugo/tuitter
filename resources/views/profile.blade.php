<x-app-layout>
    <div class="py-2 sm:py-6">
        {{-- <div class="sm:max-w-2xl md:max-w-3xl lg:max-w-4xl mx-0 sm:mx-auto sm:px-6 lg:px-8"> --}}
        <div class="max-w-xl mx-0 sm:mx-auto sm:px-6 lg:px-8">
            {{-- <div class="sm:hidden color-white">less than SM</div>
            <div class="hidden sm:block md:hidden color-white">SM</div>
            <div class="hidden md:block lg:hidden color-white">MD</div>
            <div class="hidden lg:block color-white">LG</div> --}}
            <div class="bg-white dark:bg-black overflow-hidden sm:border border-neutral-300 dark:border-neutral-800">
                <div class="p-4 text-gray-900 flex dark:text-gray-300">
                    <figure class="mr-4 w-20 h-20 sm:w-32 sm:h-32 bg-black border-white object-scale-down overflow-hidden rounded-full shrink-0 flex flex-col justify-center select-none">
                        <img src="{{ route('profile_pic', $profile_id) }}" class="max-h-32 object-contain">
                    </figure>
                    <div class="flex flex-col grow">
                        <span class="text-xl sm:text-2xl font-bold cursor-default">{{ $name }}</span>
                        <span class="text-md sm:text-lg text-neutral-700 dark:text-neutral-500 cursor-default">&#64;{{ $username }}</span>
                        <span class="mt-2 sm:mt-0 grow cursor-default">{{ $bio }}</span>
                        <div class="mt-3 sm:m-0 flex justify-between sm:justify-evenly items-center font-bold">
                            <a href="{{ route('followers', $profile_id) }}" class="sm:hidden flex flex-col items-center text-sm">
                                <span class="cursor-default select-none">{{ $followers }}</span>
                                <span class="cursor-default select-none">Followers</span>
                            </a>
                            <a href="{{ route('following', $profile_id) }}" class="sm:hidden flex flex-col items-center text-sm">
                                <span class="cursor-default select-none">{{ $following }}</span>
                                <span class="cursor-default select-none">Following</span>
                            </a>
                            <a href="{{ route('followers', $profile_id) }}" class="hidden sm:block cursor-default select-none">{{ $followers }} Followers</a>
                            <a href="{{ route('following', $profile_id) }}" class="hidden sm:block cursor-default select-none">{{ $following }} Following</a>
                            <span data-profile-id={{ $profile_id }} class="follow_button text-sm sm:text-base min-w-[94px] min-h-[24px] sm:min-w-[105px] sm:min-h-[36px] border-2 border-neutral-300 py-1 px-2 text-center cursor-default select-none">Follow +</span>
                            <span data-profile-id={{ $profile_id }} class="hidden unfollow_button text-sm sm:text-base min-w-[94px] min-h-[24px] sm:min-w-[105px] sm:min-h-[36px] border border-neutral-300 py-1 px-2 font-normal cursor-default select-none">Following ✓</span>
                        </div>
                    </div>
                </div>
            </div>

            @if ($profile_id == Auth::id())
                <x-publish-post></x-publish-post>
            @endif

            @foreach ($posts as $post_id)
                <x-post :id="$post_id" :isEditPost="$isEditPost"></x-post>
            @endforeach
        </div>
    </div>
</x-app-layout>
