<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Volunteer Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <a href="{{ route('volunteer.food-packages') }}" class="text-blue-600 hover:underline">
                        {{ __('Overzicht voedselpakketten') }}
                    </a>
                    
                    <div class="mt-6">
                        <h3 class="text-lg font-semibold mb-4">Welcome, Volunteer!</h3>
                        <p class="mb-4">Beheer en registreer voedselpakketten voor gezinnen.</p>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="bg-yellow-50 p-4 rounded-lg">
                                <h4 class="font-semibold text-yellow-800">Voedselpakketten beheren</h4>
                                <p class="text-yellow-600">Status van pakketten bijwerken</p>
                            </div>
                            <div class="bg-cyan-50 p-4 rounded-lg">
                                <h4 class="font-semibold text-cyan-800">Uitgifte registreren</h4>
                                <p class="text-cyan-600">Registreer uitgegeven pakketten</p>
                            </div>
                            <div class="bg-pink-50 p-4 rounded-lg">
                                <h4 class="font-semibold text-pink-800">Pakketinformatie</h4>
                                <p class="text-pink-600">Bekijk inhoud van pakketten</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
