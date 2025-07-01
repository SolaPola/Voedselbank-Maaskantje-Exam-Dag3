<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-green-600 leading-tight">
            {{ __('Overzicht gezinnen met voedselpakketten') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-end mb-4">
                <form action="{{ route('FoodPackages.food-packages') }}" method="GET" class="flex items-center">
                    <div class="relative inline-block">
                        <select name="diet_preference" id="filterSelect" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="">Selecteer Eetwens</option>
                            @foreach($dietPreferences as $dietPreference)
                                <option value="{{ $dietPreference->id }}" {{ $selectedDietPreference == $dietPreference->id ? 'selected' : '' }}>
                                    {{ $dietPreference->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="ml-4 px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                        {{ __('Toon Gezinnen') }}
                    </button>
                </form>
            </div>

            @if(count($families) > 0)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 border-b border-gray-200 bg-gray-50 text-left text-sm font-medium text-gray-700">
                                        {{ __('Naam') }}
                                    </th>
                                    <th class="px-4 py-2 border-b border-gray-200 bg-gray-50 text-left text-sm font-medium text-gray-700">
                                        {{ __('Omschrijving') }}
                                    </th>
                                    <th class="px-4 py-2 border-b border-gray-200 bg-gray-50 text-left text-sm font-medium text-gray-700">
                                        {{ __('Volwassenen') }}
                                    </th>
                                    <th class="px-4 py-2 border-b border-gray-200 bg-gray-50 text-left text-sm font-medium text-gray-700">
                                        {{ __('Kinderen') }}
                                    </th>
                                    <th class="px-4 py-2 border-b border-gray-200 bg-gray-50 text-left text-sm font-medium text-gray-700">
                                        {{ __('Babys') }}
                                    </th>
                                    <th class="px-4 py-2 border-b border-gray-200 bg-gray-50 text-left text-sm font-medium text-gray-700">
                                        {{ __('Vertegenwoordiger') }}
                                    </th>
                                    <th class="px-4 py-2 border-b border-gray-200 bg-gray-50 text-center text-sm font-medium text-gray-700">
                                        {{ __('Voedselpakket Details') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($families as $family)
                                <tr>
                                    <td class="px-4 py-2 border-b">{{ $family->name }}</td>
                                    <td class="px-4 py-2 border-b">{{ $family->description }}</td>
                                    <td class="px-4 py-2 border-b">{{ $family->adults }}</td>
                                    <td class="px-4 py-2 border-b">{{ $family->children }}</td>
                                    <td class="px-4 py-2 border-b">{{ $family->babies }}</td>
                                    <td class="px-4 py-2 border-b">{{ $family->representative_name ?? 'N/A' }}</td>
                                    <td class="px-4 py-2 border-b text-center">
                                        <a href="{{ route('food-packages.family', $family->id) }}" class="text-blue-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="p-4 bg-yellow-50 text-yellow-700 border border-yellow-200 rounded-lg text-center">
                        {{ __('Er zijn geen gezinnen bekent die de geselecteerde eetwens hebben') }}
                    </div>
                </div>
            @endif

            <div class="mt-4 flex justify-end">
                <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white font-bold rounded">
                    home
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
                        </div>
                    @endif
                    <div class="mt-4 flex justify-end">
                        <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            {{ __('Home') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

