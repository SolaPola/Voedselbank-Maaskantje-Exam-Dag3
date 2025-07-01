{{-- filepath: c:\Users\bilag\OneDrive - MBO Utrecht\MBO-U-Leerljaar-2\Periode 4\Exam\day 3\code\Voedselbank-Maaskantje-Exam-Dag3-dev-dag03\resources\views\customer\show.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-green-600 leading-tight">
            {{ __('Klant Details ' . ($representative ? $representative->first_name . ' ' . $representative->last_name : $family->name)) }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white border border-gray-300 rounded-lg overflow-hidden shadow-lg">
                <table class="min-w-full">
                    <tbody>
                        <tr class="border-b border-gray-200">
                            <td class="px-4 py-3 bg-gray-50 text-sm font-medium text-gray-700 w-1/3">Voornaam</td>
                            <td class="px-4 py-3 bg-white text-sm text-gray-900">{{ $representative->first_name ?? '~~~~' }}</td>
                        </tr>
                        <tr class="border-b border-gray-200">
                            <td class="px-4 py-3 bg-white text-sm font-medium text-gray-700">Tussenvoegsel</td>
                            <td class="px-4 py-3 bg-gray-50 text-sm text-gray-900">{{ $representative->infix ?? '~~~~' }}</td>
                        </tr>
                        <tr class="border-b border-gray-200">
                            <td class="px-4 py-3 bg-gray-50 text-sm font-medium text-gray-700">Achternaam</td>
                            <td class="px-4 py-3 bg-white text-sm text-gray-900">{{ $representative->last_name ?? '~~~~' }}</td>
                        </tr>
                        <tr class="border-b border-gray-200">
                            <td class="px-4 py-3 bg-white text-sm font-medium text-gray-700">Geboortedatum</td>
                            <td class="px-4 py-3 bg-gray-50 text-sm text-gray-900">{{ $representative->date_of_birth ?? '~~~~' }}</td>
                        </tr>
                        <tr class="border-b border-gray-200">
                            <td class="px-4 py-3 bg-gray-50 text-sm font-medium text-gray-700">TypePersoon</td>
                            <td class="px-4 py-3 bg-white text-sm text-gray-900">{{ $representative->person_type ?? '~~~~' }}</td>
                        </tr>
                        <tr class="border-b border-gray-200">
                            <td class="px-4 py-3 bg-white text-sm font-medium text-gray-700">Vertegenwoordiger</td>
                            <td class="px-4 py-3 bg-gray-50 text-sm text-gray-900">{{ $representative && $representative->is_representative ? 'Ja' : '~~~~' }}</td>
                        </tr>
                        <tr class="border-b border-gray-200">
                            <td class="px-4 py-3 bg-gray-50 text-sm font-medium text-gray-700">Straatnaam</td>
                            <td class="px-4 py-3 bg-white text-sm text-gray-900">{{ $contact->street ?? '~~~~' }}</td>
                        </tr>
                        <tr class="border-b border-gray-200">
                            <td class="px-4 py-3 bg-white text-sm font-medium text-gray-700">Huisnummer</td>
                            <td class="px-4 py-3 bg-gray-50 text-sm text-gray-900">{{ $contact->house_number ?? '~~~~' }}</td>
                        </tr>
                        <tr class="border-b border-gray-200">
                            <td class="px-4 py-3 bg-gray-50 text-sm font-medium text-gray-700">Toevoeging</td>
                            <td class="px-4 py-3 bg-white text-sm text-gray-900">{{ $contact->addition ?? '~~~~' }}</td>
                        </tr>
                        <tr class="border-b border-gray-200">
                            <td class="px-4 py-3 bg-white text-sm font-medium text-gray-700">Postcode</td>
                            <td class="px-4 py-3 bg-gray-50 text-sm text-gray-900">{{ $contact->postal_code ?? '~~~~' }}</td>
                        </tr>
                        <tr class="border-b border-gray-200">
                            <td class="px-4 py-3 bg-gray-50 text-sm font-medium text-gray-700">Woonplaats</td>
                            <td class="px-4 py-3 bg-white text-sm text-gray-900">{{ $contact->city ?? '~~~~' }}</td>
                        </tr>
                        <tr class="border-b border-gray-200">
                            <td class="px-4 py-3 bg-white text-sm font-medium text-gray-700">Email</td>
                            <td class="px-4 py-3 bg-gray-50 text-sm text-gray-900">{{ $contact->email ?? '~~~~' }}</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-3 bg-gray-50 text-sm font-medium text-gray-700">Mobiel</td>
                            <td class="px-4 py-3 bg-white text-sm text-gray-900">{{ $contact->mobile ?? '~~~~~~~~~~~~~~~~~~' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Action buttons -->
            <div class="mt-6 flex justify-between">
                <a href="{{ route('customers.edit', $family->id) }}" class="px-6 py-2 bg-blue-500 text-white rounded text-sm hover:bg-blue-600">
                    Wijzig
                </a>
                
                <div class="flex space-x-4">
                    <a href="{{ route('customers.index') }}" class="px-6 py-2 bg-blue-500 text-white rounded text-sm hover:bg-blue-600">
                        terug
                    </a>
                    <a href="{{ route('dashboard') }}" class="px-6 py-2 bg-blue-500 text-white rounded text-sm hover:bg-blue-600">
                        home
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>