{{-- filepath: c:\Users\bilag\OneDrive - MBO Utrecht\MBO-U-Leerljaar-2\Periode 4\Exam\day 3\code\Voedselbank-Maaskantje-Exam-Dag3-dev-dag03\resources\views\customer\index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Klantenoverzicht') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto border-collapse border border-gray-300">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="border border-gray-300 px-4 py-2 text-left font-semibold">Naam gezin</th>
                                    <th class="border border-gray-300 px-4 py-2 text-left font-semibold">Vertegenwoordiger</th>
                                    <th class="border border-gray-300 px-4 py-2 text-left font-semibold">E-mailadres</th>
                                    <th class="border border-gray-300 px-4 py-2 text-left font-semibold">Mobiel</th>
                                    <th class="border border-gray-300 px-4 py-2 text-left font-semibold">Adres</th>
                                    <th class="border border-gray-300 px-4 py-2 text-left font-semibold">Woonplaats</th>
                                    <th class="border border-gray-300 px-4 py-2 text-center font-semibold">Klant details</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($families as $family)
                                    <tr class="hover:bg-gray-50">
                                        <td class="border border-gray-300 px-4 py-2">{{ $family->family_name ?? 'Geen naam' }}</td>
                                        <td class="border border-gray-300 px-4 py-2">{{ $family->representative_name ?? 'Geen vertegenwoordiger' }}</td>
                                        <td class="border border-gray-300 px-4 py-2">{{ $family->email ?? 'Geen e-mail' }}</td>
                                        <td class="border border-gray-300 px-4 py-2">{{ $family->mobile ?? 'Geen mobiel' }}</td>
                                        <td class="border border-gray-300 px-4 py-2">{{ $family->address ?? 'Geen adres' }}</td>
                                        <td class="border border-gray-300 px-4 py-2">{{ $family->city ?? 'Geen stad' }}</td>
                                        <td class="border border-gray-300 px-4 py-2 text-center">
                                            <a href="{{ route('customers.edit', $family->id) }}" 
                                               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded text-sm">
                                                Bewerken
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="border border-gray-300 px-4 py-2 text-center text-gray-500">
                                            Geen klanten gevonden
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>