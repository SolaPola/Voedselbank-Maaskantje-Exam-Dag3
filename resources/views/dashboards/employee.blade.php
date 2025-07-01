<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Medewerker Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Welkom, Medewerker!</h3>
                    <p class="mb-4">Beheer dagelijkse operaties en help gezinnen.</p>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-orange-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-orange-800">Gezinsbeheer</h4>
                            <p class="text-orange-600">Gezinsinformatie registreren en beheren</p>
                        </div>
                        <div class="bg-teal-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-teal-800">Pakket Distributie</h4>
                            <p class="text-teal-600">Voedselpakketten samenstellen en uitdelen</p>
                        </div>
                        <div class="bg-indigo-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-indigo-800">Voorraadoverzicht</h4>
                            <p class="text-indigo-600 mb-2">Huidige voorraadniveaus controleren</p>
                            <a href="{{ route('product-stock.index') }}"
                                class="inline-flex items-center text-sm text-indigo-700 hover:text-indigo-900">
                                Voorraad Bekijken
                                <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
