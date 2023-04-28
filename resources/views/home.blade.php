<x-app-layout>
    <div class="py-2 sm:py-6">
        <div class="max-w-xl mx-0 sm:mx-auto sm:px-6 lg:px-8">
            {{-- <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div> --}}

            @foreach ($posts as $post_id)
                <x-post :id="$post_id" :settings="false"></x-post>
            @endforeach
        </div>
    </div>
</x-app-layout>
