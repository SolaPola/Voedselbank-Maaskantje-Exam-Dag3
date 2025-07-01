{{-- filepath: c:\Users\bilag\OneDrive - MBO Utrecht\MBO-U-Leerljaar-2\Periode 4\Exam\day 3\code\Voedselbank-Maaskantje-Exam-Dag3-dev-dag03\resources\views\customer\show.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Klant Details') }} - {{ $representative ? $representative->first_name . ' ' . $representative->last_name : $family->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Green Title Section -->
                    <div class="mb-6">
                        <h1 class="text-2xl font-bold text-green-600 text-left">
                            Klant Details {{ $representative ? $representative->first_name . ' ' . $representative->last_name : $family->name }}
                        </h1>
                    </div>

                    <!-- Success Message -->
                    @if(session('success'))
                        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                            De klantgegevens zijn gewijzigd
                        </div>
                    @endif

                    <div class="space-y-4">
                        <!-- Voornaam -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center border-b border-gray-200 pb-3">
                            <label class="text-sm font-medium text-gray-700">{{ __('Voornaam') }}</label>
                            <div class="md:col-span-2">
                                <div class="bg-gray-50 border border-gray-200 rounded-md px-3 py-2 text-sm text-gray-900">
                                    {{ $representative->first_name ?? '~' }}
                                </div>
                            </div>
                        </div>

                        <!-- Tussenvoegsel -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center border-b border-gray-200 pb-3">
                            <label class="text-sm font-medium text-gray-700">{{ __('Tussenvoegsel') }}</label>
                            <div class="md:col-span-2">
                                <div class="bg-gray-50 border border-gray-200 rounded-md px-3 py-2 text-sm text-gray-900">
                                    {{ $representative->infix ?? '~' }}
                                </div>
                            </div>
                        </div>

                        <!-- Achternaam -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center border-b border-gray-200 pb-3">
                            <label class="text-sm font-medium text-gray-700">{{ __('Achternaam') }}</label>
                            <div class="md:col-span-2">
                                <div class="bg-gray-50 border border-gray-200 rounded-md px-3 py-2 text-sm text-gray-900">
                                    {{ $representative->last_name ?? '~' }}
                                </div>
                            </div>
                        </div>

                        <!-- Geboortedatum -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center border-b border-gray-200 pb-3">
                            <label class="text-sm font-medium text-gray-700">{{ __('Geboortedatum') }}</label>
                            <div class="md:col-span-2">
                                <div class="bg-gray-50 border border-gray-200 rounded-md px-3 py-2 text-sm text-gray-900">
                                    {{ $representative->date_of_birth ?? '~' }}
                                </div>
                            </div>
                        </div>

                        <!-- TypePersoon -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center border-b border-gray-200 pb-3">
                            <label class="text-sm font-medium text-gray-700">{{ __('TypePersoon') }}</label>
                            <div class="md:col-span-2">
                                <div class="bg-gray-50 border border-gray-200 rounded-md px-3 py-2 text-sm text-gray-900">
                                    {{ $representative->person_type ?? '~' }}
                                </div>
                            </div>
                        </div>

                        <!-- Vertegenwoordiger -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center border-b border-gray-200 pb-3">
                            <label class="text-sm font-medium text-gray-700">{{ __('Vertegenwoordiger') }}</label>
                            <div class="md:col-span-2">
                                <div class="bg-gray-50 border border-gray-200 rounded-md px-3 py-2 text-sm text-gray-900">
                                    {{ $representative && $representative->is_representative ? 'Ja' : '~' }}
                                </div>
                            </div>
                        </div>

                        <!-- Straatnaam -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center border-b border-gray-200 pb-3">
                            <label class="text-sm font-medium text-gray-700">{{ __('Straatnaam') }}</label>
                            <div class="md:col-span-2">
                                <div class="bg-gray-50 border border-gray-200 rounded-md px-3 py-2 text-sm text-gray-900">
                                    {{ $contact->street ?? '~' }}
                                </div>
                            </div>
                        </div>

                        <!-- Huisnummer -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center border-b border-gray-200 pb-3">
                            <label class="text-sm font-medium text-gray-700">{{ __('Huisnummer') }}</label>
                            <div class="md:col-span-2">
                                <div class="bg-gray-50 border border-gray-200 rounded-md px-3 py-2 text-sm text-gray-900">
                                    {{ $contact->house_number ?? '~' }}
                                </div>
                            </div>
                        </div>

                        <!-- Toevoeging -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center border-b border-gray-200 pb-3">
                            <label class="text-sm font-medium text-gray-700">{{ __('Toevoeging') }}</label>
                            <div class="md:col-span-2">
                                <div class="bg-gray-50 border border-gray-200 rounded-md px-3 py-2 text-sm text-gray-900">
                                    {{ $contact->addition ?? '~' }}
                                </div>
                            </div>
                        </div>

                        <!-- Postcode -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center border-b border-gray-200 pb-3">
                            <label class="text-sm font-medium text-gray-700">{{ __('Postcode') }}</label>
                            <div class="md:col-span-2">
                                <div class="bg-gray-50 border border-gray-200 rounded-md px-3 py-2 text-sm text-gray-900">
                                    {{ $contact->postal_code ?? '~' }}
                                </div>
                            </div>
                        </div>

                        <!-- Woonplaats -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center border-b border-gray-200 pb-3">
                            <label class="text-sm font-medium text-gray-700">{{ __('Woonplaats') }}</label>
                            <div class="md:col-span-2">
                                <div class="bg-gray-50 border border-gray-200 rounded-md px-3 py-2 text-sm text-gray-900">
                                    {{ $contact->city ?? '~' }}
                                </div>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center border-b border-gray-200 pb-3">
                            <label class="text-sm font-medium text-gray-700">{{ __('Email') }}</label>
                            <div class="md:col-span-2">
                                <div class="bg-gray-50 border border-gray-200 rounded-md px-3 py-2 text-sm text-gray-900">
                                    {{ $contact->email ?? '~' }}
                                </div>
                            </div>
                        </div>

                        <!-- Mobiel -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center border-b border-gray-200 pb-3">
                            <label class="text-sm font-medium text-gray-700">{{ __('Mobiel') }}</label>
                            <div class="md:col-span-2">
                                <div class="bg-gray-50 border border-gray-200 rounded-md px-3 py-2 text-sm text-gray-900">
                                    {{ $contact->mobile ?? '~' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-8 flex justify-between items-center">
                        <div class="flex space-x-3">
                            <a href="{{ route('customers.edit', $family->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Wijzig') }}
                            </a>
                        </div>
                        
                        <div class="flex space-x-3">
                            <a href="{{ route('customers.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('terug') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>