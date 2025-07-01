<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Wijzig voedselpakket status') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-xl font-medium text-green-600 text-center mb-6">
                        {{ __('Wijzig voedselpakket status') }}
                    </h3>

                    <form action="{{ route('food-packages.update', $package->id) }}" method="POST" class="max-w-md mx-auto">
                        @csrf
                        
                        <div class="mb-6">
                            <select id="status" name="status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                @foreach($statusOptions as $value => $label)
                                    <option value="{{ $value }}" {{ $package->status == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        @if(session('success'))
                            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-md mb-6">
                                <p class="text-center">{{ session('success') }}</p>
                            </div>
                        @endif

                        <div class="flex items-center justify-center gap-4">
                            <button type="submit" class="px-4 py-2 bg-gray-700 text-white rounded-md hover:bg-gray-800">
                                {{ __('Wijzig status voedselpakket') }}
                            </button>
                            
                            <a href="{{ route('food-packages.family', $package->family_id) }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                {{ __('terug') }}
                            </a>
                            
                            <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                {{ __('home') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

