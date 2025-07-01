@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6 bg-white rounded shadow">
    <a href="#" class="text-green-700 font-bold text-lg underline mb-4 inline-block">Overzicht producten</a>
    <table class="border mb-6">
        <tr>
            <td class="border px-4 py-2 font-semibold">Naam:</td>
            <td class="border px-4 py-2">{{ $supplier->name }}</td>
        </tr>
        <tr>
            <td class="border px-4 py-2 font-semibold">Leveranciernummer:</td>
            <td class="border px-4 py-2">{{ $supplier->supplier_number }}</td>
        </tr>
        <tr>
            <td class="border px-4 py-2 font-semibold">Leveranciertype:</td>
            <td class="border px-4 py-2">{{ $supplier->supplier_type }}</td>
        </tr>
    </table>
    <table class="min-w-full border mb-6">
        <thead>
            <tr>
                <th class="border px-4 py-2 text-left font-semibold">Naam</th>
                <th class="border px-4 py-2 text-left font-semibold">Soort Allergie</th>
                <th class="border px-4 py-2 text-left font-semibold">Barcode</th>
                <th class="border px-4 py-2 text-left font-semibold">Houdbaarheidsdatum</th>
                <th class="border px-4 py-2 text-left font-semibold">Wijzig Product</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($products) && count($products))
                @foreach($products as $product)
                <tr>
                    <td class="border px-4 py-2">{{ $product->name }}</td>
                    <td class="border px-4 py-2">{{ $product->allergy_type ?? '-' }}</td>
                    <td class="border px-4 py-2">{{ $product->barcode ?? '-' }}</td>
                    <td class="border px-4 py-2">
                        {{ $product->expiration_date ? \Carbon\Carbon::parse($product->expiration_date)->format('d-m-Y') : '-' }}
                    </td>
                    <td class="border px-4 py-2 text-center">
                        <a href="{{ route('supplier.edit', $product->id) }}" class="inline-flex items-center px-3 py-1 bg-yellow-500 text-white text-xs font-semibold rounded hover:bg-yellow-600 transition">
                            <i class="bi bi-pencil-square mr-1"></i> Edit
                        </a>
                    </td>
                </tr>
                @endforeach
            @else
                <tr>
                    <td class="border px-4 py-2 text-center" colspan="5">Geen producten gevonden.</td>
                </tr>
            @endif
        </tbody>
    </table>
    <div class="flex justify-end gap-2 mt-4">
        <a href="{{ route('supplier.index') }}" class="px-4 py-2 rounded bg-blue-600 text-white font-semibold shadow hover:bg-blue-700 transition">terug</a>
        <a href="{{ route('manager.dashboard') }}" class="px-4 py-2 rounded bg-blue-600 text-white font-semibold shadow hover:bg-blue-700 transition">home</a>
    </div>
</div>
@endsection

