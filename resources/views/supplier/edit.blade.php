@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <a href="#" class="text-green-700 font-bold text-xl underline mb-4 inline-block">Wijzig Product</a>
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded border border-green-300 flex items-center gap-2">
            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @elseif(session('error'))
        <div class="mb-4 p-3 bg-red-100 text-red-800 rounded border border-red-300 flex items-center gap-2">
            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif
    @if(session('date_error'))
        <div class="mb-4 p-3 bg-red-100 text-red-800 rounded border border-red-300 flex items-center gap-2">
            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
            <span>{{ session('date_error') }}</span>
        </div>
    @endif
    <form method="POST" action="{{ route('supplier.edit', $product->id) }}" class="flex flex-col gap-4">
        @csrf
        @method('POST')
        <div class="flex items-center gap-4">
            <label class="block font-semibold text-lg" for="expiration_date">Houdbaarheidsdatum:</label>
            <input type="date" id="expiration_date" name="expiration_date" value="{{ $product->expiration_date }}" class="form-input border px-3 py-2 rounded w-64">
        </div>
        <div class="text-red-600 font-medium">
            De houdbaarheidsdatum mag met maximaal 7 dagen worden verlengd
        </div>
        <div class="flex items-center gap-4 mt-2">
            <button type="submit" class="px-6 py-2 rounded bg-gray-500 text-white font-semibold shadow hover:bg-gray-600 transition">
                Wijzig Houdbaarheidsdatum
            </button>
            <a href="{{ route('manager.suppliers.products', ['supplier' => $product->supplier_id]) }}" class="px-4 py-2 rounded bg-blue-600 text-white font-semibold shadow hover:bg-blue-700 transition">Terug</a>
            <a href="{{ route('manager.dashboard') }}" class="px-4 py-2 rounded bg-blue-600 text-white font-semibold shadow hover:bg-blue-700 transition">Home</a>
        </div>
    </form>
</div>
@endsection
