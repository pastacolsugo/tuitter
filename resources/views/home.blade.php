<x-app-layout>
    <div class="py-6">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            {{-- <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div> --}}

            @foreach ($posts as $p)
                @if ($loop->first)
                    <x-post class="md:border-t-2" :author="$p['author']" :date="$p['date']" :content="$p['content']" ></x-post>
                    @continue
                @endif
                <x-post :author="$p['author']" :date="$p['date']" :content="$p['content']" ></x-post>
            @endforeach
        </div>
    </div>
</x-app-layout>
