<x-app-layout>
    <x-slot name="header">
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg text-green-600 font-medium underline">{{ __('Overzicht gezinnen met voedselpakketten') }}</h3>
                    
                    <div class="flex items-center">
                        <form action="{{ route('FoodPackages.food-packages') }}" method="GET" class="flex items-center">
                            <div class="relative inline-block">
                                <select name="diet_preference" id="filterSelect"
                                    class="border-gray-300 rounded-md shadow-sm pl-3 pr-10 py-2">
                                    <option value="">Selecteer Eetwens</option>
                                    @foreach($dietPreferences as $dietPreference)
                                        <option value="{{ $dietPreference->id }}" {{ $selectedDietPreference == $dietPreference->id ? 'selected' : '' }}>
                                            {{ $dietPreference->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit"
                                class="ml-4 px-4 py-2 bg-gray-600 text-white rounded-md">
                                {{ __('Toon Gezinnen') }}
                            </button>
                        </form>
                    </div>
                </div>

                @if(count($families) > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead>
                                <tr class="border-b">
                                    <th class="py-3 px-4 text-left font-medium">{{ __('Gezinsnaam') }}</th>
                                    <th class="py-3 px-4 text-left font-medium">{{ __('Omschrijving') }}</th>
                                    <th class="py-3 px-4 text-left font-medium">{{ __('Volwassenen') }}</th>
                                    <th class="py-3 px-4 text-left font-medium">{{ __('Kinderen') }}</th>
                                    <th class="py-3 px-4 text-left font-medium">{{ __('Baby\'s') }}</th>
                                    <th class="py-3 px-4 text-left font-medium">{{ __('Vertegenwoordiger') }}</th>
                                    <th class="py-3 px-4 text-left font-medium">{{ __('Voedselpakket Details') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($families as $family)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="py-3 px-4">{{ $family->name }}</td>
                                        <td class="py-3 px-4">{{ $family->description }}</td>
                                        <td class="py-3 px-4">{{ $family->adults }}</td>
                                        <td class="py-3 px-4">{{ $family->children }}</td>
                                        <td class="py-3 px-4">{{ $family->babies }}</td>
                                        <td class="py-3 px-4">{{ $family->representative_name ?? '~~~~' }}</td>
                                        <td class="py-3 px-4 text-center">
                                            <a href="{{ route('food-packages.family', $family->id) }}" class="text-blue-300 flex justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-box" viewBox="0 0 16 16">
                                                  <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5 8 5.961 14.154 3.5zM15 4.239l-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464z"/>
                                                </svg>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-4 bg-yellow-50 text-yellow-700 border border-yellow-200 rounded-lg text-center">
                        {{ __('Er zijn geen gezinnen bekent die de geselecteerde eetwens hebben') }}
                    </div>
                @endif
                
                <div class="mt-6 flex justify-end">
                    <a href="{{ route('dashboard') }}"
                        class="px-4 py-2 bg-blue-500 text-white rounded-md">
                        {{ __('home') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>