<x-app-layout>
    <div class="py-2 sm:py-6">
        <div class="max-w-xl mx-0 sm:mx-auto sm:px-6 lg:px-8">
            <div>Followers of <b>&#64;{{ $user->username }}:</b></div>
            @if (count($followers) > 0)
                @foreach ($followers as $f)
                    <x-user-card
                        :username="$f->username"
                        :name="$f->name"
                        :profile_pic="$f->profile_pic_asset"
                        :id="$f->id">
                    </x-user-card>
                @endforeach
            @else
                <div>No followers.</div>
            @endif
        </div>
    </div>
</x-app-layout>
