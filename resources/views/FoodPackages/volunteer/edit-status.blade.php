<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-green-600 leading-tight">
            {{ __('Wijzig voedselpakket status') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <!-- Make sure the form action points to the correct route -->
                <form action="{{ route('volunteer.food-packages.update', $package->id) }}" method="POST">
                    @csrf
                    
                    <div class="mb-6">
                        <select name="status" class="w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm">
                            @foreach($statusOptions as $value => $label)
                                <option value="{{ $value }}" {{ $package->status == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="flex justify-between mt-8">
                        <button type="submit" class="px-4 py-2 bg-gray-500 text-white rounded-md">
                            {{ __('Wijzig status voedselpakket') }}
                        </button>
                        
                        <div>
                            <a href="{{ route('volunteer.food-packages.family', $package->family_id) }}" class="px-4 py-2 bg-blue-500 text-white rounded-md mr-2">
                                {{ __('terug') }}
                            </a>
                            
                            <a href="{{ route('volunteer.dashboard') }}" class="px-4 py-2 bg-blue-500 text-white rounded-md">
                                {{ __('home') }}
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if(session('success'))
    <script>
        // Redirect back to family packages page after 3 seconds
        setTimeout(function() {
            window.location.href = "{{ route('volunteer.food-packages.family', $package->family_id) }}";
        }, 3000);
    </script>
    @endif
</x-app-layout>
