<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Vrijwilliger Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Welkom, Vrijwilliger!</h3>
                    <p class="mb-4">Bedankt voor het helpen van onze gemeenschap!</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-rose-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-rose-800">Voorraad Ondersteuning</h4>
                            <p class="text-rose-600">Help met voorraad en bevoorrading</p>
                        </div>
                        <div class="bg-indigo-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-indigo-800">Basis Taken</h4>
                            <p class="text-indigo-600">Assisteer met dagelijkse vrijwilligerstaken</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
