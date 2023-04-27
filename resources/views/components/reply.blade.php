<div class="p-2 px-3 border-neutral-300">
    <div class="flex">
        <figure class="mr-4 w-10 h-10 bg-black border-white object-scale-down overflow-hidden rounded-full shrink-0 flex flex-col justify-center">
            @if (isset($author_profile_picture_asset))
                <img src="{{ asset($author_profile_picture_asset) }}" class="max-h-20 object-contain">
            @else
                <img src="{{ asset('profile_pictures/default.svg') }}" class="max-h-20 object-contain">
            @endif
        </figure>
        <div class="max-w-[85%] flex flex-col">
            <div class="flex">
                <span class="font-bold mr-4">{{ $author_name }}</span>
                <span class="text-neutral-500">&#64;{{ $author_username }}</span>
            </div>
            <span class="break-words">{{ $content }}</span>
        </div>
    </div>
</div>
