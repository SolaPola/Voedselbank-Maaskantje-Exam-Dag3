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
            <div class="mb-6 flex justify-between items-start">
                <div class="flex items-center space-x-4">
                    <form method="GET" action="{{ route('customers.index') }}" class="flex items-center space-x-4">
                        <select name="postal_code" class="px-3 py-2 border border-gray-300 rounded bg-white text-sm min-w-48">
                            <option value="">Selecteer Postcode</option>
                            <option value="5271TH" {{ request('postal_code') == '5271TH' ? 'selected' : '' }}>5271TH</option>
                            <option value="5271TJ" {{ request('postal_code') == '5271TJ' ? 'selected' : '' }}>5271TJ</option>
                            <option value="5271ZE" {{ request('postal_code') == '5271ZE' ? 'selected' : '' }}>5271ZE</option>
                            <option value="5271ZH" {{ request('postal_code') == '5271ZH' ? 'selected' : '' }}>5271ZH</option>
                        </select>
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded text-sm hover:bg-blue-600">
                            Toon Klanten
                        </button>
                    </form>
                </div>
                
                <!-- Right aligned home button -->
                <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-blue-500 text-white rounded text-sm hover:bg-blue-600">
                    Home
                </a>
            </div>

            <!-- Table -->
            <div class="bg-white border border-gray-300 rounded-lg overflow-hidden">
                <table class="min-w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-700 border-b border-gray-300">Naam Gezin</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-700 border-b border-gray-300">Vertegenwoordiger</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-700 border-b border-gray-300">E-mailadres</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-700 border-b border-gray-300">Mobiel</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-700 border-b border-gray-300">Adres</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-700 border-b border-gray-300">Woonplaats</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-700 border-b border-gray-300">Klant Details</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @forelse($pagination->items() as $family)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-sm text-gray-900 border-b border-gray-200">
                                    {{ $family->family_name ?? '~~ ~~ ~~' }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-900 border-b border-gray-200">
                                    {{ $family->representative_name ?? '~~ ~~ ~~' }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-900 border-b border-gray-200">
                                    {{ $family->email ?? '~~ ~~ ~~' }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-900 border-b border-gray-200">
                                    {{ $family->mobile ?? '~~ ~~ ~~' }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-900 border-b border-gray-200">
                                    {{ $family->address ?? '~~ ~~ ~~' }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-900 border-b border-gray-200">
                                    {{ $family->city ?? '~~ ~~ ~~' }}
                                </td>
                                <td class="px-4 py-3 text-sm text-center border-b border-gray-200">
                                    <a href="{{ route('customers.edit', $family->id) }}" 
                                       class="inline-flex items-center justify-center w-6 h-6 bg-blue-100 text-blue-600 rounded hover:bg-blue-200 text-xs">
                                        📝
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-8 text-center">
                                    @if(request('postal_code'))
                                        <div class="bg-yellow-100 border border-yellow-400 text-yellow-800 px-4 py-3 rounded">
                                            Er zijn geen klanten bekend die de geselecteerde postcode hebben
                                        </div>
                                    @else
                                        <span class="text-gray-500">Geen klanten gevonden</span>
                                    @endif
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

        </div>
    </div>
</x-app-layout>
