<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-green-600 leading-tight">
            {{ __('Overzicht gezinnen met voedselpakketten') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-end mb-4">
                <div class="flex items-center">
                    <select name="diet_preference" class="border border-gray-300 rounded-md px-4 py-2">
                        <option>Selecteer Eetwens</option>
                        @foreach($dietPreferences as $dietPreference)
                            <option value="{{ $dietPreference->id }}" {{ $selectedDietPreference == $dietPreference->id ? 'selected' : '' }}>
                                {{ $dietPreference->name }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="ml-2 px-4 py-2 bg-gray-500 text-white rounded-md">
                        Toon Gezinnen
                    </button>
                </div>
            </div>

            <div class="overflow-hidden bg-white">
                <table class="min-w-full border-collapse">
                    <thead>
                        <tr>
                            <th class="border px-4 py-2 text-left">Naam</th>
                            <th class="border px-4 py-2 text-left">Omschrijving</th>
                            <th class="border px-4 py-2 text-left">Volwassenen</th>
                            <th class="border px-4 py-2 text-left">Kinderen</th>
                            <th class="border px-4 py-2 text-left">Babys</th>
                            <th class="border px-4 py-2 text-left">Vertegenwoordiger</th>
                            <th class="border px-4 py-2 text-center">Voedselpakket Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($families) > 0)
                            @foreach($families as $family)
                            <tr>
                                <td class="border px-4 py-2">{{ $family->name }}</td>
                                <td class="border px-4 py-2">{{ $family->description }}</td>
                                <td class="border px-4 py-2">{{ $family->adults }}</td>
                                <td class="border px-4 py-2">{{ $family->children }}</td>
                                <td class="border px-4 py-2">{{ $family->babies }}</td>
                                <td class="border px-4 py-2">{{ $family->representative_name ?? '~~~~' }}</td>
                                <td class="border px-4 py-2 text-center">
                                    <a href="{{ route('food-packages.family', $family->id) }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7" class="border px-4 py-2 text-center">
                                    {{ __('Er zijn geen gezinnen bekent die de geselecteerde eetwens hebben') }}
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <div class="mt-4 flex justify-end">
                <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md">
                    home
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
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

