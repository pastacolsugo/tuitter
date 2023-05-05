<div {{ $attributes->merge(['class' => 'mt-2 bg-white dark:bg-black dark:text-white border-b border-t sm:border-x border-neutral-300 dark:border-neutral-800'])}}>
    <a href="{{ route('profile', $id) }}" class="block">
        <div class="p-2 sm:p-4 px-4 sm:px-6 flex justify-start border-neutral-300 dark:border-neutral-800">
            <figure class="mr-3 sm:mr-4 w-10 h-10 sm:w-14 sm:h-14 bg-black border-white object-scale-down overflow-hidden rounded-full shrink-0 flex flex-col justify-center select-none">
                <img src="{{ route('profile_pic', $id) }}" class="max-h-20 object-contain" alt="" longdesc="">
            </figure>
            <div class="max-w-[85%] grow">
                <div class="flex justify-between items-center">
                    <div class="flex flex-col space-between">
                        <div class="text-md sm:text-xl font-bold">{{ $name }}</div>
                        <div class="text-sm sm:text-md text-neutral-600 dark:text-neutral-400 font-light">&#64;{{ $username }}</div>
                    </div>
                </div>
            </div>
        </div>
    </a>
</div>
