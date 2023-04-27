<div class="replies-container">
    @foreach ($replies as $reply)
        <x-reply :reply="$reply"></x-reply>
    @endforeach
    <div class="py-4 px-3 border-neutral-300">
        <div class="flex items-center">
            <figure class="mr-4 w-10 h-10 bg-black border-white object-scale-down overflow-hidden rounded-full shrink-0 flex flex-col justify-center select-none">
                @if (isset($profile_pic))
                    <img src="{{ asset($profile_pic) }}" class="max-h-20 object-contain">
                @else
                    <img src="{{ asset('profile_pictures/default.svg') }}" class="max-h-20 object-contain">
                @endif
            </figure>
            <form class="grow flex items-bottom" action="javascript:void(0);">
                <label class="hidden" for="reply-{{ $post_id }}">Write reply to post {{ $post_id }}</label>
                <input class="w-[100%] p-1 px-2 border border-neutral-300 rounded-none" rows="2" type="textarea" data-post-id={{ $post_id }} id="reply-{{ $post_id }}" name="reply" placeholder="Reply...">
                <button class="mx-2" data-post-id="{{ $post_id }}" type="submit"><span class="submit_reply_button text-4xl text-gray-500 material-symbols-outlined cursor-default">send</span></button>
            </form>
        </div>
    </div>
</div>
