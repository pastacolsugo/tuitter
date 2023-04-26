<div {{ $attributes->merge(['class' => 'mt-2 p-4 px-6 bg-white dark:bg-black dark:text-white border-b border-t sm:border-x border-neutral-300 dark:border-neutral-800 flex justify-start']) }}>
    <figure class="mr-4 w-14 h-14 bg-black border-white object-scale-down overflow-hidden rounded-full shrink-0 flex flex-col justify-center">
        @if (isset($profilePictureAsset))
            <img src="{{ asset($profilePictureAsset) }}" class="max-h-20 object-contain">
        @else
            <img src="{{ asset('profile_pictures/default.svg') }}" class="max-h-20 object-contain">
        @endif
    </figure>
    <div class="grow">
        <div class="flex justify-between items-baseline">
            <div class="flex flex-col space-between">
                <div class="text-xl font-bold">{{ $author_name }}</div>
                <div class="text-md text-neutral-600 dark:text-neutral-400 font-light">&#64;{{ $author_username }}</div>
            </div>
            <div class="text-sm text-gray-400">{{ $date }}</div>
        </div>
        <div class="text-lg my-4">{{ $content }}</div>
        @if (isset($reply_to))
            <div>{{ $reply_to }}</div>
        @endif
        <div class="flex gap-4 mt-4 justify-around text-gray-500 font-light">
            <span data-post-id={{ $post_id }} class="{{ ($liked ? 'text-red-500' : '')." like_button material-symbols-outlined" }}">favorite</span>
            <span data-post-id={{ $post_id }} class="reply_button material-symbols-outlined">chat_bubble</span>
            <span data-post-id={{ $post_id }} class="share_button material-symbols-outlined">share</span>
        </div>
    </div>
</div>
