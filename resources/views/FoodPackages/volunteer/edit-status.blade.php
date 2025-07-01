<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-green-600 leading-tight">
            {{ __('Wijzig voedselpakket status') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="text-xl font-medium text-green-600 text-center mb-6">
                    {{ __('Wijzig voedselpakket status') }}
                </h3>
                
                @if($errorMessage)
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        {{ $errorMessage }}
                    </div>
                @endif
                
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif
                
                <form action="{{ route('volunteer.food-packages.update', $package->id) }}" method="POST" class="max-w-md mx-auto">
                    @csrf
                    
                    <div class="mb-6">
                        <select name="status" class="w-full border-gray-300 rounded-md shadow-sm" {{ $isDisabled ? 'disabled' : '' }}>
                            @foreach($statusOptions as $value => $label)
                                <option value="{{ $value }}" {{ $package->status == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mt-8 flex justify-center space-x-4">
                        <button type="submit" class="px-4 py-2 bg-gray-500 text-white rounded-md" {{ $isDisabled ? 'disabled' : '' }}>
                            {{ __('Wijzig status voedselpakket') }}
                        </button>
                        
                        <a href="{{ route('volunteer.food-packages.family', $package->family_id) }}" class="px-4 py-2 bg-blue-500 text-white rounded-md">
                            {{ __('terug') }}
                        </a>
                        
                        <a href="{{ route('volunteer.dashboard') }}" class="px-4 py-2 bg-blue-500 text-white rounded-md">
                            {{ __('home') }}
                        </a>
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
