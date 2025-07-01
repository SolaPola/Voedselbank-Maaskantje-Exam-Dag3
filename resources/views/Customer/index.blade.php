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
                    <!-- Results count -->
                    <div class="mb-4">
                        <p class="text-sm text-gray-600">
                            Totaal {{ $pagination->total() }} klanten gevonden. 
                            Pagina {{ $pagination->currentPage() }} van {{ $pagination->lastPage() }}
                        </p>
                    </div>

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
                                @forelse($pagination->items() as $family)
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

                    <!-- Pagination Links -->
                    @if($pagination->hasPages())
                        <div class="mt-6">
                            <nav class="flex items-center justify-between">
                                <div class="flex-1 flex justify-between sm:hidden">
                                    @if($pagination->onFirstPage())
                                        <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-md">
                                            Vorige
                                        </span>
                                    @else
                                        <a href="{{ $pagination->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                            Vorige
                                        </a>
                                    @endif

                                    @if($pagination->hasMorePages())
                                        <a href="{{ $pagination->nextPageUrl() }}" class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                            Volgende
                                        </a>
                                    @else
                                        <span class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-md">
                                            Volgende
                                        </span>
                                    @endif
                                </div>

                                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                                    <div>
                                        <p class="text-sm text-gray-700">
                                            Toont
                                            <span class="font-medium">{{ $pagination->firstItem() }}</span>
                                            tot
                                            <span class="font-medium">{{ $pagination->lastItem() }}</span>
                                            van
                                            <span class="font-medium">{{ $pagination->total() }}</span>
                                            resultaten
                                        </p>
                                    </div>
                                    <div>
                                        <span class="relative z-0 inline-flex shadow-sm rounded-md">
                                            {{-- Previous Page Link --}}
                                            @if($pagination->onFirstPage())
                                                <span class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-l-md">
                                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                    </svg>
                                                </span>
                                            @else
                                                <a href="{{ $pagination->previousPageUrl() }}" class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-l-md hover:bg-gray-50">
                                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                    </svg>
                                                </a>
                                            @endif

                                            {{-- Pagination Elements --}}
                                            @foreach($pagination->getUrlRange(1, $pagination->lastPage()) as $page => $url)
                                                @if($page == $pagination->currentPage())
                                                    <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-white bg-blue-600 border border-gray-300">
                                                        {{ $page }}
                                                    </span>
                                                @else
                                                    <a href="{{ $url }}" class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 hover:bg-gray-50">
                                                        {{ $page }}
                                                    </a>
                                                @endif
                                            @endforeach

                                            {{-- Next Page Link --}}
                                            @if($pagination->hasMorePages())
                                                <a href="{{ $pagination->nextPageUrl() }}" class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-md hover:bg-gray-50">
                                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                                    </svg>
                                                </a>
                                            @else
                                                <span class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-r-md">
                                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                                    </svg>
                                                </span>
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </nav>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
