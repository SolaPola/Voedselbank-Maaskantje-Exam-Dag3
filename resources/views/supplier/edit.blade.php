@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h2 class="text-2xl font-bold mb-4 text-green-700">Product bewerken</h2>
    <form method="POST" action="#">
        @csrf
        {{-- Add @method('PUT') if you implement update --}}
        <div class="mb-4">
            <label class="block font-semibold mb-1">Naam</label>
            <input type="text" name="name" value="{{ $product->name }}" class="form-input w-full border px-3 py-2 rounded" disabled>
        </div>
        <div class="mb-4">
            <label class="block font-semibold mb-1">Soort Allergie</label>
            <input type="text" name="allergy_type" value="{{ $product->allergy_type }}" class="form-input w-full border px-3 py-2 rounded" disabled>
        </div>
        <div class="mb-4">
            <label class="block font-semibold mb-1">Barcode</label>
            <input type="text" name="barcode" value="{{ $product->barcode }}" class="form-input w-full border px-3 py-2 rounded" disabled>
        </div>
        <div class="mb-4">
            <label class="block font-semibold mb-1">Houdbaarheidsdatum</label>
            <input type="date" name="expiration_date" value="{{ $product->expiration_date }}" class="form-input w-full border px-3 py-2 rounded" disabled>
        </div>
        <div class="mb-4">
            <label class="block font-semibold mb-1">Omschrijving</label>
            <textarea name="description" class="form-input w-full border px-3 py-2 rounded" disabled>{{ $product->description }}</textarea>
        </div>
        <div class="mb-4">
            <label class="block font-semibold mb-1">Status</label>
            <input type="text" name="status" value="{{ $product->status }}" class="form-input w-full border px-3 py-2 rounded" disabled>
        </div>
        <a href="{{ route('suppliers.products') }}" class="px-4 py-2 rounded bg-blue-600 text-white font-semibold shadow hover:bg-blue-700 transition">Terug</a>
    </form>
</div>
@endsection
