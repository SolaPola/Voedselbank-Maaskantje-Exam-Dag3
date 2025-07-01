<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Overzicht Klanten') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Header with controls -->
            <div class="mb-6 flex justify-between items-center">
                <form method="GET" action="{{ route('customers.index') }}" class="flex items-center space-x-4">
                    <select name="postal_code" class="px-4 py-2 border border-gray-300 rounded-md bg-white text-sm">
                        <option value="">Selecteer Postcode</option>
                        <option value="5271TH" {{ request('postal_code') == '5271TH' ? 'selected' : '' }}>5271TH</option>
                        <option value="5271TJ" {{ request('postal_code') == '5271TJ' ? 'selected' : '' }}>5271TJ</option>
                        <option value="5271ZE" {{ request('postal_code') == '5271ZE' ? 'selected' : '' }}>5271ZE</option>
                        <option value="5271ZH" {{ request('postal_code') == '5271ZH' ? 'selected' : '' }}>5271ZH</option>
                    </select>
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-md text-sm font-medium hover:bg-blue-700">
                        Toon Klanten
                    </button>
                    @if(request('postal_code'))
                        <a href="{{ route('customers.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md text-sm font-medium hover:bg-gray-600">
                            Reset Filter
                        </a>
                    @endif
                </form>
            </div>

            <!-- Table -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <table class="min-w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Naam</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vertegenwoordiger</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mobiel</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Adres</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Woonplaats</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Klant Details</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($pagination->items() as $family)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $family->family_name ?? 'Geen naam' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $family->representative_name ?? 'No contact' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-600">
                                    {{ $family->email ?? '' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $family->mobile ?? '' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $family->address ?? '' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $family->city ?? '' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <a href="{{ route('customers.edit', $family->id) }}" 
                                       class="text-blue-600 hover:text-blue-900 underline">
                                        Bewerken
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                    Geen klanten gevonden
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($pagination->hasPages())
                <div class="mt-6 flex items-center justify-between">
                    <div class="text-sm text-gray-700">
                        Toont {{ $pagination->firstItem() }} tot {{ $pagination->lastItem() }} van {{ $pagination->total() }} resultaten
                        @if(request('postal_code'))
                            voor postcode {{ request('postal_code') }}
                        @endif
                    </div>
                    <div class="flex items-center space-x-2">
                        @if($pagination->onFirstPage())
                            <span class="px-3 py-2 text-sm text-gray-400 cursor-not-allowed">Vorige</span>
                        @else
                            <a href="{{ $pagination->appends(request()->query())->previousPageUrl() }}" class="px-3 py-2 text-sm text-blue-600 hover:text-blue-800">Vorige</a>
                        @endif

                        @foreach($pagination->getUrlRange(1, $pagination->lastPage()) as $page => $url)
                            @if($page == $pagination->currentPage())
                                <span class="px-3 py-2 text-sm bg-blue-600 text-white rounded">{{ $page }}</span>
                            @else
                                <a href="{{ $pagination->appends(request()->query())->url($page) }}" class="px-3 py-2 text-sm text-blue-600 hover:text-blue-800">{{ $page }}</a>
                            @endif
                        @endforeach

                        @if($pagination->hasMorePages())
                            <a href="{{ $pagination->appends(request()->query())->nextPageUrl() }}" class="px-3 py-2 text-sm text-blue-600 hover:text-blue-800">Volgende</a>
                        @else
                            <span class="px-3 py-2 text-sm text-gray-400 cursor-not-allowed">Volgende</span>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Bottom navigation -->
            <div class="mt-8 flex justify-end">
                <a href="{{ route('dashboard') }}" class="px-6 py-2 bg-blue-600 text-white rounded-md text-sm font-medium hover:bg-blue-700">
                    Home
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
