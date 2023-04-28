<div data-replies-loaded=0 data-replies-showing=0 {{ $attributes->merge(['class' => 'mt-2 bg-white dark:bg-black dark:text-white border-b border-t sm:border-x border-neutral-300 dark:border-neutral-800'])}}>
    <div class="p-4 px-6 flex justify-start border-neutral-300 dark:border-neutral-800">
        <figure class="mr-4 w-14 h-14 bg-black border-white object-scale-down overflow-hidden rounded-full shrink-0 flex flex-col justify-center select-none">
            @if (isset($profilePictureAsset))
                <img src="{{ asset($profilePictureAsset) }}" class="max-h-20 object-contain">
            @else
                <img src="{{ asset('profile_pictures/default.svg') }}" class="max-h-20 object-contain">
            @endif
        </figure>
        <div class="max-w-[85%] grow">
            <div class="flex justify-between items-baseline">
                <div class="flex flex-col space-between">
                    <div class="text-xl font-bold cursor-default"><a href={{ route('profile', $author_id) }}>{{ $author_name }}</a></div>
                    <div class="text-md text-neutral-600 dark:text-neutral-400 font-light cursor-default"><a href="{{ route('profile', $author_id) }}">&#64;{{ $author_username }}</a></div>
                </div>
                <div class="text-sm text-gray-400 cursor-default">{{ $date }}</div>
            </div>
            <div class="text-lg my-4 cursor-default break-words">{{ $content }}</div>
            <div class="flex gap-4 mt-4 justify-around text-gray-500 font-light">
                <span data-post-id={{ $post_id }} class="like_button material-symbols-outlined cursor-default select-none">favorite</span>
                <span data-post-id={{ $post_id }} class="reply_button material-symbols-outlined cursor-default select-none">chat_bubble</span>
                <a href={{ route('post', $post_id) }}><span data-post-id={{ $post_id }} class="share_button material-symbols-outlined cursor-default select-none">share</span></a>
            </div>
        </div>
    </div>
</div>
