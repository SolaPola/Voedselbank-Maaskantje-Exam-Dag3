@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h2 class="text-2xl font-bold mb-4 text-green-700">Overzicht Leveranciers</h2>
    <form method="GET" action="{{ route('supplier.index') }}" class="flex items-center gap-2 mb-4 justify-end">
        <select name="type" class="form-select px-3 py-2 border rounded" onchange="this.form.submit()">
            <option value="">Selecteer LeverancierType</option>
            @php
                $types = $suppliers->pluck('supplier_type')->unique()->filter()->values();
            @endphp
            @foreach($types as $type)
                <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>
                    {{ $type }}
                </option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-secondary px-4 py-2 rounded bg-blue-600 text-white">Toon Leveranciers</button>
    </form>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 border border-gray-300">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-black-500 uppercase tracking-wider border-r border-gray-300">Naam</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-black-500 uppercase tracking-wider border-r border-gray-300">Contactpersoon</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-black-500 uppercase tracking-wider border-r border-gray-300">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-black-500 uppercase tracking-wider border-r border-gray-300">Mobiel</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-black-500 uppercase tracking-wider border-r border-gray-300">Leveranciernummer</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-black-500 uppercase tracking-wider border-r border-gray-300">LeverancierType</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-black-500 uppercase tracking-wider">Product Details</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($suppliers as $supplier)
                    @php $contact = $supplier->contacts->first(); @endphp
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 border-r border-gray-300">{{ $supplier->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 border-r border-gray-300">{{ $supplier?->contact_person}}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 border-r border-gray-300">{{ $contact?->email ?? '' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 border-r border-gray-300">{{ $contact?->mobile ?? '' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 border-r border-gray-300">{{ $supplier->supplier_number }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 border-r border-gray-300">{{ $supplier->supplier_type }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <a href="{{ route('manager.suppliers.products', $supplier->id) }}" class="inline-flex items-center px-3 py-1 bg-blue-500 text-white text-xs font-semibold rounded hover:bg-blue-700 transition">
                                <i class="bi bi-clipboard mr-1"></i> Show
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900" colspan="7">No suppliers found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="flex justify-end mt-4">
        <a href="{{ route('manager.dashboard') }}" class="px-6 py-2 rounded bg-blue-600 text-white font-semibold shadow hover:bg-blue-700 transition">
            Home
        </a>
    </div>
</div>
@endsection
