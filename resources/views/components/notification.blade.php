<a href="/notifications/0b6cd504-d5b9-4e76-ab4d-bb4a1abe20d4">
    <div {{ $attributes->merge(['class' => 'notification mt-2 bg-white dark:bg-black dark:text-white border-b border-t sm:border-x border-neutral-300 dark:border-neutral-800'])}}>
        <div class="p-4 px-6 flex justify-start border-neutral-300 dark:border-neutral-800">
            <figure class="mr-4 w-14 h-14 bg-black border-white object-scale-down overflow-hidden rounded-full shrink-0 flex flex-col justify-center select-none">
                {{-- <img src="{{ route('profile_pic', $author_id) }}" class="max-h-20 object-contain" alt="" longdesc=""> --}}
                <img src="{{ route('profile_pic', $user->id) }}" class="max-h-20 object-contain" alt="" longdesc="">
            </figure>
            <div class="max-w-[85%] grow">
                <div class="flex justify-between items-center">
                    <div class="text-lg my-4 cursor-default break-words"><b>{{ $user->name }}</b> (&#64;{{ $user->username }}) ha iniziato a seguirti.</div>
                    <div class="text-sm text-gray-400 cursor-default">{{ $date }}</div>
                </div>
            </div>
        </div>
    </div>
</a>
