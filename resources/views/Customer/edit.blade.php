{{-- filepath: c:\Users\bilag\OneDrive - MBO Utrecht\MBO-U-Leerljaar-2\Periode 4\Exam\day 3\code\Voedselbank-Maaskantje-Exam-Dag3-dev-dag03\resources\views\customer\edit.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Wijzig Klant Details') }} - {{ $family->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @php
                        $contact = $family->contactPerFamilies->first()?->contact;
                        $representative = $family->people->first();
                    @endphp

                    <!-- Green Title Section -->
                    <div class="mb-6">
                        <h1 class="text-2xl font-bold text-green-600 text-left">
                            Wijzig Klant Details {{ $representative ? $representative->first_name . ' ' . $representative->last_name : $family->name }}
                        </h1>
                    </div>

                    <!-- Success Message -->
                    @if(session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                            De klantgegevens zijn gewijzigd
                        </div>
                    @endif

                    <!-- Error Message -->
                    @if($errors->any())
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            De contactgegevens kunnen niet worden gewijzigd
                        </div>
                    @endif

                    <form method="POST" action="{{ route('customers.update', $family->id) }}" class="space-y-4">
                        @csrf
                        @method('PUT')

                  
                        <!-- Voornaam (Editable) -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center border-b border-gray-200 pb-3">
                            <label class="text-sm font-medium text-gray-700">{{ __('Voornaam') }}</label>
                            <div class="md:col-span-2">
                                <input type="text" 
                                       name="first_name" 
                                       value="{{ old('first_name', $representative->first_name) }}"
                                       required
                                       minlength="2"
                                       maxlength="50"
                                       class="w-full bg-white border border-gray-200 rounded-md px-3 py-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 @error('first_name') border-red-500 @enderror">
                                @error('first_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Tussenvoegsel (Editable) -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center border-b border-gray-200 pb-3">
                            <label class="text-sm font-medium text-gray-700">{{ __('Tussenvoegsel') }}</label>
                            <div class="md:col-span-2">
                                <input type="text" 
                                       name="infix" 
                                       value="{{ old('infix', $representative->infix) }}"
                                       maxlength="20"
                                       class="w-full bg-white border border-gray-200 rounded-md px-3 py-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 @error('infix') border-red-500 @enderror">
                                @error('infix')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Achternaam (Editable) -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center border-b border-gray-200 pb-3">
                            <label class="text-sm font-medium text-gray-700">{{ __('Achternaam') }}</label>
                            <div class="md:col-span-2">
                                <input type="text" 
                                       name="last_name" 
                                       value="{{ old('last_name', $representative->last_name) }}"
                                       required
                                       minlength="2"
                                       maxlength="50"
                                       class="w-full bg-white border border-gray-200 rounded-md px-3 py-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 @error('last_name') border-red-500 @enderror">
                                @error('last_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Geboortedatum (Editable with date picker) -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center border-b border-gray-200 pb-3">
                            <label class="text-sm font-medium text-gray-700">{{ __('Geboortedatum') }}</label>
                            <div class="md:col-span-2">
                                <input type="date" 
                                       name="date_of_birth" 
                                       value="{{ old('date_of_birth', $representative->date_of_birth) }}"
                                       class="w-full bg-white border border-gray-200 rounded-md px-3 py-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500">
                            </div>
                        </div>

                        <!-- Type Persoon (Read-only) -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center border-b border-gray-200 pb-3">
                            <label class="text-sm font-medium text-gray-700">{{ __('Type Persoon') }}</label>
                            <div class="md:col-span-2">
                                <div class="bg-blue-50 border border-gray-200 rounded-md px-3 py-2 text-sm text-blue-900">
                                    {{ $representative->person_type ?? 'Klant' }}
                                </div>
                            </div>
                        </div>

                        <!-- Vertegenwoordiger (Read-only) -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center border-b border-gray-200 pb-3">
                            <label class="text-sm font-medium text-gray-700">{{ __('Vertegenwoordiger') }}</label>
                            <div class="md:col-span-2">
                                <div class="bg-blue-50 border border-gray-200 rounded-md px-3 py-2 text-sm text-blue-900">
                                    {{ $representative && $representative->is_representative ? 'Ja' : '~' }}
                                </div>
                            </div>
                        </div>

                        <!-- Straatnaam (Editable) -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center border-b border-gray-200 pb-3">
                            <label class="text-sm font-medium text-gray-700">{{ __('Straatnaam') }}</label>
                            <div class="md:col-span-2">
                                <input type="text" 
                                       name="street" 
                                       value="{{ old('street', $contact->street) }}"
                                       class="w-full bg-white border border-gray-200 rounded-md px-3 py-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 @error('street') border-red-500 @enderror">
                                @error('street')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Huisnummer (Editable) -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center border-b border-gray-200 pb-3">
                            <label class="text-sm font-medium text-gray-700">{{ __('Huisnummer') }}</label>
                            <div class="md:col-span-2">
                                <input type="text" 
                                       name="house_number" 
                                       value="{{ old('house_number', $contact->house_number) }}"
                                       class="w-full bg-white border border-gray-200 rounded-md px-3 py-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 @error('house_number') border-red-500 @enderror">
                                @error('house_number')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Toevoeging (Editable) -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center border-b border-gray-200 pb-3">
                            <label class="text-sm font-medium text-gray-700">{{ __('Toevoeging') }}</label>
                            <div class="md:col-span-2">
                                <input type="text" 
                                       name="addition" 
                                       value="{{ old('addition', $contact->addition) }}"
                                       class="w-full bg-white border border-gray-200 rounded-md px-3 py-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500">
                            </div>
                        </div>

                        <!-- Postcode (Editable with validation) -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center border-b border-gray-200 pb-3">
                            <label class="text-sm font-medium text-gray-700">{{ __('Postcode') }}</label>
                            <div class="md:col-span-2">
                                <input type="text" 
                                       name="postal_code" 
                                       value="{{ old('postal_code', $contact->postal_code) }}"
                                       class="w-full bg-white border border-gray-200 rounded-md px-3 py-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 @error('postal_code') border-red-500 @enderror">
                                @error('postal_code')
                                    <p class="mt-1 text-sm text-red-600">Deze postcode komt niet uit de regio Maaskantje</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Woonplaats (Editable) -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center border-b border-gray-200 pb-3">
                            <label class="text-sm font-medium text-gray-700">{{ __('Woonplaats') }}</label>
                            <div class="md:col-span-2">
                                <input type="text" 
                                       name="city" 
                                       value="{{ old('city', $contact->city) }}"
                                       class="w-full bg-white border border-gray-200 rounded-md px-3 py-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 @error('city') border-red-500 @enderror">
                                @error('city')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Email (Editable with validation) -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center border-b border-gray-200 pb-3">
                            <label class="text-sm font-medium text-gray-700">{{ __('E-mail') }}</label>
                            <div class="md:col-span-2">
                                <div class="relative">
                                    <input type="email" 
                                           name="email" 
                                           value="{{ old('email', $contact->email) }}"
                                           class="w-full bg-white border border-gray-200 rounded-md px-3 py-2 pr-8 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 @error('email') border-red-500 @enderror">
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                        <svg class="w-4 h-4 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                                        </svg>
                                    </div>
                                </div>
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Mobiel (Editable) -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center border-b border-gray-200 pb-3">
                            <label class="text-sm font-medium text-gray-700">{{ __('Mobiel') }}</label>
                            <div class="md:col-span-2">
                                <input type="text" 
                                       name="mobile" 
                                       value="{{ old('mobile', $contact->mobile) }}"
                                       class="w-full bg-white border border-gray-200 rounded-md px-3 py-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 @error('mobile') border-red-500 @enderror">
                                @error('mobile')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="mt-8 flex justify-between items-center">
                            <div class="flex space-x-3">
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    {{ __('Wijzig Klant Details') }}
                                </button>
                            </div>
                            
                            <div class="flex space-x-3">
                                <a href="{{ route('customers.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    {{ __('terug') }}
                                </a>
                                
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>