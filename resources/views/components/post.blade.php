<div {{ $attributes->merge(['class' => 'mt-2 md:mt-0 p-4 md:pt-6 px-6 bg-white border-b-2 md:border-x-2 flex justify-start']) }}>
    <figure class="mr-4 w-14 h-14 overflow-hidden rounded-full shrink-0">
        <img src="{{ asset('profile_pictures/test.webp')}}"
        class="max-h-20 object-contain">
    </figure>
    <div class="grow">
        <div class="flex justify-between items-baseline">
            <div class="text-xl font-bold">{{ $author }}</div>
            <div class="text-sm text-gray-400">{{ $date }}</div>
        </div>
        <div class="text-lg my-4">{{ $content }}</div>
        @if (isset($reply_to))
            <div>{{ $reply_to }}</div>
        @endif
        <div class="flex gap-4 mt-4 justify-around text-gray-500 font-light">
            <span class="material-symbols-outlined">favorite</span>
            <span class="material-symbols-outlined">chat_bubble</span>
            <span class="material-symbols-outlined">share</span>
        </div>
    </div>
</div>
