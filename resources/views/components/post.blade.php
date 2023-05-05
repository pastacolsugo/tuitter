<div data-replies-loaded=0 data-replies-showing=0 {{ $attributes->merge(['class' => 'mt-2 bg-white dark:bg-black dark:text-white border-b border-t sm:border-x border-neutral-300 dark:border-neutral-800'])}}>
    <div class="p-2 pt-4 sm:p-4 px-4 sm:px-6 flex justify-start border-neutral-300 dark:border-neutral-800">
        <figure class="mr-3 sm:mr-4 w-10 h-10 sm:w-14 sm:h-14 bg-black border-white object-scale-down overflow-hidden rounded-full shrink-0 flex flex-col justify-center select-none">
            <a href="{{ route('profile', $author_id) }}"><img src="{{ route('profile_pic', $author_id) }}" class="max-h-20 object-contain" alt="" longdesc=""></a>
        </figure>
        <div class="max-w-[85%] grow">
            @if (isset($is_edit_post) and $is_edit_post)
                <form method="post">
            @endif
            <div class="flex justify-between items-center">
                <div class="flex flex-col space-between">
                    <div class="text-md sm:text-xl font-bold cursor-default"><a href={{ route('profile', $author_id) }}>{{ $author_name }}</a></div>
                    <div class="text-sm sm:text-md text-neutral-600 dark:text-neutral-400 font-light cursor-default"><a href="{{ route('profile', $author_id) }}">&#64;{{ $author_username }}</a></div>
                </div>
                <div class=" sm:block text-xs sm:text-sm text-gray-400 cursor-default">{{ $date }}</div>
            </div>
            @if (isset($is_edit_post) and $is_edit_post)
                <label for="content" class="hidden">Edita il post</label>
                <textarea class="w-[100%] text-md sm:text-lg my-4 cursor-default break-words border-neutral-300 dark:border-neutral-800" name="content" id="content" required>{{ $content }}</textarea>
            @else
                <div class="text-md sm:text-lg my-4 cursor-default break-words">{{ $content }}</div>
            @endif
            @if ($has_image)
                <div class="image-container">
                    <figure>
                        <img class="max-h-[500px] object-contain overflow-hidden" src="{{ route('post-image', $post_id) }}" alt="{{ $image_description }}"/>
                    </figure>
                </div>
            @endif
            @if (!isset($is_edit_post) or $is_edit_post == false)
                <div class="flex gap-4 mt-4 justify-around text-gray-500 font-light">
                    <span data-post-id={{ $post_id }} class="px-2 like_button material-symbols-outlined cursor-default select-none">favorite</span>
                    <span data-post-id={{ $post_id }} class="px-2 reply_button material-symbols-outlined cursor-default select-none">chat_bubble</span>
                    <a href={{ route('post', $post_id) }}><span data-post-id={{ $post_id }} class="px-2 share_button material-symbols-outlined cursor-default select-none">share</span></a>
                    @if ($author_id == Auth::id())
                        <span class="more_button material-symbols-outlined">more_vert</span>
                    @endif
                </div>
                @if ($author_id == Auth::id())
                    {{-- hidden flex is necessary, js will remove and add back hidden to show the element --}}
                    <div class="hidden flex justify-evenly shadow-lg border-2 border-neutral-300 dark:border-neutral-800 pt-2 pb-1">
                        <a href="{{ route('delete-post', $post_id) }}" class="px-4"><span class="delete_button material-symbols-outlined text-red-800">delete</span></a>
                        <a href="{{ route('edit-post', $post_id) }}" class="px-4"><span class="edit_button material-symbols-outlined text-gray-500">edit</span></a>
                    </div>
                @endif
            @endif
            @if (isset($is_edit_post) and $is_edit_post)
                    <div class="flex justify-end">
                        <label for="submit" class="hidden">Salva</label>
                        <button type="submit" id="submit" class="py-2 px-8 border text-neutral-800 border-neutral-300 dark:border-neutral-800">Salva</button>
                    </div>
                </form>
            @endif
        </div>
    </div>
</div>
