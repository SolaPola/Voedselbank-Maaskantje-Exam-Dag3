@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <a href="#" class="text-green-700 font-bold text-xl underline mb-4 inline-block">Wijzig Product</a>
    <form method="POST" action="{{ route('supplier.edit', $product->id) }}" class="flex flex-col gap-4">
        @csrf
        @method('POST')
        <div class="flex items-center gap-4">
            <label class="block font-semibold text-lg" for="expiration_date">Houdbaarheidsdatum:</label>
            <input type="date" id="expiration_date" name="expiration_date" value="{{ $product->expiration_date }}" class="form-input border px-3 py-2 rounded w-64">
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
