<x-app-layout>
    <div class="py-2 sm:py-6">
        <div class="max-w-xl mx-0 sm:mx-auto sm:px-6 lg:px-8">
            {{-- <div class="py-2 align-middle inline-block min-w-full sm:px-0 lg:p-8 lg:pt-4">
                <div class="overflow-hidden sm:rounded-lg"> --}}
                    @if($query and $results)
                        @if($results->count() > 0)
                            @foreach ($results as $user)
                                <x-user-card
                                    :username="$user->username"
                                    :name="$user->name"
                                    :profile_pic="$user->profile_pic_asset"
                                    :id="$user->id">
                                </x-user-card>
                            @endforeach
                        <div class="mx-2 py-2">
                            {{ $results->links() }}
                        </div>
                        @else
                            <div class="alert alert-warning text-center pt-2" role="alert">No results for {{ $query }}</div>
                        @endif
                    @else
                        <p class="font-medium text-gray-700">Search users!</p>
                    @endif
                {{-- </div>
            </div> --}}
        </div>
    </div>
</x-app-layout>
