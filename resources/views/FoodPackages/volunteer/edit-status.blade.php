<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-green-600 leading-tight">
            {{ __('Wijzig voedselpakket status') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-6 text-green-600 text-center">
                    {{ __('Wijzig voedselpakket status') }}
                </h3>
                
                <form action="{{ route('food-packages.update', $package->id) }}" method="POST" class="max-w-md mx-auto">
                    @csrf
                    
                    <div class="mb-6">
                        <select name="status" class="w-full border-gray-300 rounded-md shadow-sm">
                            @foreach($statusOptions as $value => $label)
                                <option value="{{ $value }}" {{ $package->status == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mt-8 flex justify-center space-x-4">
                        <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-md">
                            {{ __('Wijzig status voedselpakket') }}
                        </button>
                        
                        <a href="{{ route('food-packages.family', $package->family_id) }}" class="px-4 py-2 bg-blue-500 text-white rounded-md">
                            {{ __('terug') }}
                        </a>
                        
                        <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-blue-500 text-white rounded-md">
                            {{ __('home') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
