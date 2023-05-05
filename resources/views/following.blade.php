<x-app-layout>
    <div class="py-2 sm:py-6">
        <div class="max-w-xl mx-0 sm:mx-auto sm:px-6 lg:px-8">
            <div>Followed by <b>&#64;{{ $user->username }}:</b></div>
            @if (count($following) > 0)
                @foreach ($following as $f)
                    <x-user-card
                        :username="$f->username"
                        :name="$f->name"
                        :profile_pic="$f->profile_pic_asset"
                        :id="$f->id">
                    </x-user-card>
                @endforeach
            @else
                <div>Follows no one.</div>
            @endif
        </div>
    </div>
</x-app-layout>
