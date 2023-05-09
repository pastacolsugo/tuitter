<a href="{{ route('mark_notifications', $id)}}">
    {{-- {{ print_r($dataa) }} --}}
    <div {{ $attributes->merge(['class' => 'notification mt-2 bg-white dark:bg-black dark:text-white border-b border-t sm:border-x border-neutral-300 dark:border-neutral-800'])}}>
        <div class="p-2 py-4 sm:p-4 sm:px-6 flex justify-start items-center border-neutral-300 dark:border-neutral-800">
            <figure class="mr-2 sm:mr-4 w-10 h-10 sm:w-14 sm:h-14 bg-black border-white object-scale-down overflow-hidden rounded-full shrink-0 flex flex-col justify-center select-none">
                <img src="{{ route('profile_pic', $dataa['user_id']) }}" class="max-h-20 object-contain" alt="" longdesc="">
            </figure>
            <div class="grow">
                <div class="flex justify-between items-center">
                    @switch ($type)
                        @case ('App\Notifications\NewFollow')
                            <div class="text-md sm:text-lg my-4 cursor-default break-words"><b>{{ $user->name }}</b> (&#64;{{ $user->username }}) ha iniziato a seguirti.</div>
                            @break

                        @case ('App\Notifications\NewLike')
                            <div class="text-md sm:text-lg my-4 cursor-default break-words"><b>{{ $user->name }}</b> (&#64;{{ $user->username }}) ha messo like al tuo post.</div>
                            @break

                        @case ('App\Notifications\NewReply')
                            <div class="text-md sm:text-lg my-4 cursor-default break-words"><b>{{ $user->name }}</b> (&#64;{{ $user->username }}) ha risposto al tuo post.</div>
                            @break

                        @default
                            Default case...
                    @endswitch
                    {{-- <div class="text-md sm:text-lg my-4 cursor-default break-words"><b>{{ $user->name }}</b> (&#64;{{ $user->username }}) {{ $type }} ha iniziato a seguirti.</div> --}}
                    <div class="text-xs sm:text-sm text-gray-400 cursor-default">{{ $date }}</div>
                </div>
            </div>
        </div>
    </div>
</a>
