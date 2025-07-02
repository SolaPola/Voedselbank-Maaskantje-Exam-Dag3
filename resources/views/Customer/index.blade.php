{{-- filepath: c:\Users\bilag\OneDrive - MBO Utrecht\MBO-U-Leerljaar-2\Periode 4\Exam\day 3\code\Voedselbank-Maaskantje-Exam-Dag3-dev-dag03\resources\views\customer\index.blade.php --}}
<x-app-layout>
   

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- Green Title Section inside content area -->
                    <div class="mb-6">
                        <h1 class="text-2xl font-bold text-green-600 underline text-left">
                            Overzicht Klanten
                        </h1>
                    </div>

                    {{-- Success message display --}}
                    @if(session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- Filter section matching product stock styling --}}
                    <div class="flex justify-end mb-4">
                        <form action="{{ route('customers.index') }}" method="GET" class="flex items-center">
                            <div class="relative inline-block">
                                <select name="postal_code" id="filterSelect"
                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm pl-3 pr-10 py-2">
                                    <option value="">Selecteer Postcode</option>
                                    <option value="5271TH" {{ request('postal_code') == '5271TH' ? 'selected' : '' }}>5271TH</option>
                                    <option value="5271TJ" {{ request('postal_code') == '5271TJ' ? 'selected' : '' }}>5271TJ</option>
                                    <option value="5271ZE" {{ request('postal_code') == '5271ZE' ? 'selected' : '' }}>5271ZE</option>
                                    <option value="5271ZH" {{ request('postal_code') == '5271ZH' ? 'selected' : '' }}>5271ZH</option>
                                </select>
                            </div>
                            <button type="submit"
                                class="ml-4 px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700">
                                {{ __('Toon Klanten') }}
                            </button>
                        </form>
                    </div>

                    {{-- Main data table --}}
                    @if (count($pagination->items()) > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border border-gray-200">
                                <thead>
                                    <tr>
                                        <th class="px-6 py-3 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            {{ __('Naam Gezin') }}
                                        </th>
                                        <th class="px-6 py-3 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            {{ __('Vertegenwoordiger') }}
                                        </th>
                                        <th class="px-6 py-3 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            {{ __('E-mailadres') }}
                                        </th>
                                        <th class="px-6 py-3 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            {{ __('Mobiel') }}
                                        </th>
                                        <th class="px-6 py-3 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            {{ __('Adres') }}
                                        </th>
                                        <th class="px-6 py-3 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            {{ __('Woonplaats') }}
                                        </th>
                                        <th class="px-6 py-3 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            {{ __('Klant Details') }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pagination->items() as $family)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                                {{ $family->family_name ?? '~~~~' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                                {{ $family->representative_name ?? '~~~~' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                                {{ $family->email ?? '~~~~' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                                {{ $family->mobile ?? '~~~~' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                                {{ $family->address ?? '~~~~' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                                {{ $family->city ?? '~~~~' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-center">
                                                <a href="{{ route('customers.show', $family->id) }}" class="text-blue-600 hover:text-blue-800">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <rect x="4" y="4" width="16" height="16" rx="2" stroke="currentColor" fill="none"/>
                                                        <path d="M8 8h8M8 12h8M8 16h4" stroke="currentColor" stroke-linecap="round"/>
                                                    </svg>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="p-4 bg-yellow-50 text-yellow-700 border border-yellow-200 rounded-lg text-center">
                            @if(request('postal_code'))
                                {{ __('Er zijn geen klanten bekend die de geselecteerde postcode hebben') }}
                            @else
                                {{ __('Er zijn momenteel geen klanten in het systeem.') }}
                            @endif
                        </div>
                    @endif

                    {{-- Pagination section --}}
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

                    {{-- Home button matching product stock styling --}}
                    <div class="mt-4 flex justify-end">
                        <a href="{{ route('dashboard') }}"
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            {{ __('home') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>