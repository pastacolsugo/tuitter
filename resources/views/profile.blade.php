<x-app-layout>
    <div class="py-2 sm:py-6">
        <div class="max-w-xl mx-0 sm:mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-black overflow-hidden border border-neutral-300 dark:border-neutral-900">
                <div class="p-4 text-gray-900 flex dark:text-gray-100">
                    <figure class="mr-4 w-32 h-32 bg-black border-white object-scale-down overflow-hidden rounded-full shrink-0 flex flex-col justify-center select-none">
                        <img src="{{ route('profile_pic', $profile_id) }}" class="max-h-32 object-contain">
                    </figure>
                    <div class="flex flex-col grow">
                        <span class="text-2xl font-bold cursor-default">{{ $name }}</span>
                        <span class="text-lg text-neutral-700 cursor-default">&#64;{{ $username }}</span>
                        <span class="grow cursor-default">{{ $bio }}</span>
                        <div class="m-0 flex justify-evenly items-center font-bold">
                            <span class="cursor-default select-none">{{ $followers }} Followers</span>
                            <span class="cursor-default select-none">{{ $following }} Following</span>
                            <span data-profile-id={{ $profile_id }} class="follow_button min-w-[105px] min-h-[36px] border-2 border-neutral-300 py-1 px-2 text-center cursor-default select-none">Follow +</span>
                            <span data-profile-id={{ $profile_id }} class="hidden unfollow_button min-w-[105px] min-h-[36px] border border-neutral-300 py-1 px-2 font-normal bg-neutral-200 cursor-default select-none">Following ✓</span>
                        </div>
                    </div>
                </div>
            </div>

            @foreach ($posts as $post_id)
                <x-post :id="$post_id" :settings="$settings_enabled"></x-post>
            @endforeach
        </div>
    </div>
</x-app-layout>
