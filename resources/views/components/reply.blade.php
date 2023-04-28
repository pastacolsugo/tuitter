<div class="p-2 px-3 border-neutral-300">
    <div class="flex">
        <figure class="mr-4 w-10 h-10 bg-black border-white object-scale-down overflow-hidden rounded-full shrink-0 flex flex-col justify-center">
            <img src="{{ route('profile_pic', $author_id) }}" class="max-h-20 object-contain">
        </figure>
        <div class="max-w-[85%] flex flex-col">
            <div class="flex">
                <span class="font-bold mr-4 cursor-default">{{ $author_name }}</span>
                <span class="text-neutral-500 cursor-default">&#64;{{ $author_username }}</span>
            </div>
            <span class="break-words cursor-default">{{ $content }}</span>
        </div>
    </div>
</div>
