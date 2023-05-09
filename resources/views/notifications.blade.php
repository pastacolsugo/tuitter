<x-app-layout>
    <div class="py-2 sm:py-6">
        <div class="max-w-3xl mx-0 sm:mx-auto sm:px-6 lg:px-8">
            @if (count($unread) == 0)
                <div class="flex items-center pt-8 justify-around">
                    <div class="ml-4 text-lg text-gray-500 uppercase tracking-wider">No new notifications</div>
                </div>
            @else
                @foreach ($unread as $n)
                    {{-- {{ print_r($n->data) }} --}}
                    <x-notification :dataa="$n->data" :date="$n->created_at" :type="$n->type" :id="$n->id"></x-notification>
                @endforeach
            @endif
        </div>
    </div>
</x-app-layout>
