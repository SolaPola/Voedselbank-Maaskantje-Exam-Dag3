<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manager Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Welkom, Manager!</h3>
                    <p class="mb-4">U heeft volledige toegang tot het beheer van de voedselbank operaties.</p>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-blue-800">Gebruikers Beheren</h4>
                            <p class="text-blue-600">Gebruikersaccounts toevoegen, bewerken en beheren</p>
                        </div>
                        <div class="bg-green-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-green-800">Voorraadbeheer</h4>
                            <p class="text-green-600 mb-2">Volledige toegang tot voorraadbeheer</p>
                            <a href="{{ route('product-stock.index') }}"
                                class="inline-flex items-center text-sm text-green-700 hover:text-green-900">
                                Voorraagoverzicht Bekijken
                                <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                        <div class="bg-purple-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-purple-800">Rapporten</h4>
                            <p class="text-purple-600">Uitgebreide rapporten bekijken</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
