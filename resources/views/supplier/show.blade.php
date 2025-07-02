{{-- filepath: c:\Users\bilag\OneDrive - MBO Utrecht\MBO-U-Leerljaar-2\Periode 4\Exam\day 3\code\Voedselbank-Maaskantje-Exam-Dag3-dev-dag03\resources\views\supplier\products.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Overzicht Producten') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- Green Title Section -->
                    <div class="mb-6">
                        <h1 class="text-2xl font-bold text-green-600 text-left">
                            Overzicht producten
                        </h1>
                    </div>

                    <!-- Supplier Information Table -->
                    <div class="mb-6 bg-gray-50 border border-gray-200 rounded-lg p-4">
                        <table class="w-full">
                            <tr>
                                <td class="py-2 font-semibold text-gray-700 w-1/3">Naam:</td>
                                <td class="py-2 text-gray-900">{{ $supplier->name }}</td>
                            </tr>
                            <tr>
                                <td class="py-2 font-semibold text-gray-700 w-1/3">Leveranciernummer:</td>
                                <td class="py-2 text-gray-900">{{ $supplier->supplier_number }}</td>
                            </tr>
                            <tr>
                                <td class="py-2 font-semibold text-gray-700 w-1/3">Leveranciertype:</td>
                                <td class="py-2 text-gray-900">{{ $supplier->supplier_type }}</td>
                            </tr>
                        </table>
                    </div>

                    <!-- Products Table -->
                    @if(isset($products) && count($products) > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border border-gray-200">
                                <thead>
                                    <tr>
                                        <th class="px-6 py-3 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            {{ __('Naam') }}
                                        </th>
                                        <th class="px-6 py-3 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            {{ __('Soort Allergie') }}
                                        </th>
                                        <th class="px-6 py-3 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            {{ __('Barcode') }}
                                        </th>
                                        <th class="px-6 py-3 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            {{ __('Houdbaarheidsdatum') }}
                                        </th>
                                        <th class="px-6 py-3 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            {{ __('Details') }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $product)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                                {{ $product->name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                                {{ $product->allergy_type ?? '-' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                                {{ $product->barcode ?? '-' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                                @if($product->expiry_date)
                                                    {{ \Carbon\Carbon::parse($product->expiry_date)->format('d-m-Y') }}
                                                @else
                                                    <span class="text-gray-400">Geen vervaldatum</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                                <a href="{{ route('supplier.edit', $product->id) }}"
                                                    class="inline-flex items-center px-3 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                                    title="{{ __('Toon details') }}">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                        </path>
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
                            {{ __('Geen producten gevonden.') }}
                        </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="mt-6 flex justify-end space-x-3">
                        <a href="{{ route('supplier.index') }}"
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            {{ __('terug') }}
                        </a>
                        <a href="{{ route('dashboard') }}"
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            {{ __('Home') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>