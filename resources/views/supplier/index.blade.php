{{-- filepath: c:\Users\bilag\OneDrive - MBO Utrecht\MBO-U-Leerljaar-2\Periode 4\Exam\day 3\code\Voedselbank-Maaskantje-Exam-Dag3-dev-dag03\resources\views\supplier\index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Overzicht Leveranciers') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- Filter for supplier type --}}
                    <form method="GET" action="{{ route('supplier.index') }}" class="flex items-center gap-2 mb-4 justify-end">
                        <select name="type" class="form-select px-3 py-2 border rounded" onchange="this.form.submit()">
                            <option value="">Selecteer LeverancierType</option>
                            @php
                                $types = $suppliers->pluck('supplier_type')->unique()->filter()->values();
                                // Add 'Donor' if not present
                                if (!$types->contains('Donor')) {
                                    $types->push('Donor');
                                }
                            @endphp
                            @foreach($types as $type)
                                <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>
                                    {{ $type }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-secondary px-4 py-2 rounded bg-blue-600 text-white">Toon Leveranciers</button>
                    </form>

                    @if (count($suppliers) > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border border-gray-300">
                                <thead>
                                    <tr>
                                        <th class="px-6 py-3 border-b border-r border-gray-300 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            {{ __('Naam') }}
                                        </th>
                                        <th class="px-6 py-3 border-b border-r border-gray-300 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            {{ __('Contactpersoon') }}
                                        </th>
                                        <th class="px-6 py-3 border-b border-r border-gray-300 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            {{ __('email') }}
                                        </th>
                                        <th class="px-6 py-3 border-b border-r border-gray-300 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            {{ __('mobiel') }}
                                        </th>
                                        <th class="px-6 py-3 border-b border-r border-gray-300 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            {{ __('Leverancier Nummer') }}
                                        </th>
                                        <th class="px-6 py-3 border-b border-r border-gray-300 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            {{ __('Leverancier Type') }}
                                        </th>
                                        <th class="px-6 py-3 border-b border-gray-300 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            {{ __('Product Details') }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($suppliers as $supplier)
                                        <tr>
                                            <td class="px-6 py-4 border-b border-r border-gray-300">
                                                {{ $supplier->name }}
                                            </td>
                                            <td class="px-6 py-4 border-b border-r border-gray-300">
                                                {{ $supplier->contact_person }}
                                            </td>
                                            <td class="px-6 py-4 border-b border-r border-gray-300">
                                                {{ $supplier->email }}
                                            </td>
                                            <td class="px-6 py-4 border-b border-r border-gray-300">
                                                {{ $supplier->mobiel }}
                                            </td>
                                            <td class="px-6 py-4 border-b border-r border-gray-300">
                                                {{ $supplier->supplier_number }}
                                            </td>
                                            <td class="px-6 py-4 border-b border-r border-gray-300">
                                                {{ $supplier->supplier_type }}
                                            </td>
                                            <td class="px-6 py-4 border-b border-gray-300">
                                                <a href="{{ route('supplier.show', $supplier->id) }}"
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
                            {{ __('Er zijn geen leveranciers bekent van het geselecteerde leverancierstype.') }}
                        </div>
                    @endif

                    <div class="mt-4 flex justify-end">
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