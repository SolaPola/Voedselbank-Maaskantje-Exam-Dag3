<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Wijzig Product Details') }} - {{ $product->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Green Title Section -->
                    <div class="mb-6 text-center">
                        <h1 class="text-2xl font-bold text-green-600 text-left">
                            Wijzig Product Details {{ $product->name }}
                        </h1>
                    </div>

                    <!-- Success Message -->
                    @if (session('success'))
                        <div class="mb-4 p-4 bg-green-50 text-green-700 border border-green-200 rounded-lg">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Error Message -->
                    @if ($errors->has('error'))
                        <div class="mb-4 p-4 bg-red-50 text-red-700 border border-red-200 rounded-lg">
                            {{ $errors->first('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('product-stock.update', $product->id) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="space-y-4">
                            <!-- Product Name -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center border-b border-gray-200 pb-3">
                                <label class="text-sm font-medium text-gray-700">{{ __('Productnaam') }}</label>
                                <div class="md:col-span-2">
                                    <input type="text" name="name" value="{{ old('name', $product->name) }}" 
                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('name') border-red-500 @enderror">
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Expiry Date -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center border-b border-gray-200 pb-3">
                                <label class="text-sm font-medium text-gray-700">{{ __('Houdbaarheidsdatum') }}</label>
                                <div class="md:col-span-2">
                                    <input type="date" name="expiry_date" value="{{ old('expiry_date', $product->expiry_date ? $product->expiry_date->format('Y-m-d') : '') }}" 
                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('expiry_date') border-red-500 @enderror">
                                    @error('expiry_date')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Barcode -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center border-b border-gray-200 pb-3">
                                <label class="text-sm font-medium text-gray-700">{{ __('Barcode') }}</label>
                                <div class="md:col-span-2">
                                    <input type="text" name="barcode" value="{{ old('barcode', $product->barcode) }}" 
                                        maxlength="13"
                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('barcode') border-red-500 @enderror">
                                    @error('barcode')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-1 text-xs text-gray-500">Maximaal 13 karakters</p>
                                </div>
                            </div>

                            <!-- Magazine Location -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center border-b border-gray-200 pb-3">
                                <label class="text-sm font-medium text-gray-700">{{ __('Magazijn Locatie') }}</label>
                                <div class="md:col-span-2">
                                    <select name="location" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('location') border-red-500 @enderror">
                                        <option value="Berlicum" {{ old('location', $productPerWarehouse->location) == 'Berlicum' ? 'selected' : '' }}>Berlicum</option>
                                        <option value="Rosmalen" {{ old('location', $productPerWarehouse->location) == 'Rosmalen' ? 'selected' : '' }}>Rosmalen</option>
                                        <option value="Den Bosch" {{ old('location', $productPerWarehouse->location) == 'Den Bosch' ? 'selected' : '' }}>Den Bosch</option>
                                    </select>
                                    @error('location')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Received Date -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center border-b border-gray-200 pb-3">
                                <label class="text-sm font-medium text-gray-700">{{ __('Ontvangstdatum') }}</label>
                                <div class="md:col-span-2">
                                    <input type="date" name="date_received" value="{{ old('date_received', $warehouse->date_received ? $warehouse->date_received->format('Y-m-d') : '') }}" 
                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('date_received') border-red-500 @enderror">
                                    @error('date_received')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Aantal uitgeleverde producten -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center border-b border-gray-200 pb-3">
                                <label class="text-sm font-medium text-gray-700">{{ __('Aantal uitgeleverde producten') }}</label>
                                <div class="md:col-span-2">
                                    <input type="number" name="delivered_quantity" value="{{ old('delivered_quantity', $warehouse->delivered_quantity ?? 0) }}" 
                                        min="0"
                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('delivered_quantity') border-red-500 @enderror">
                                    @error('delivered_quantity')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Delivery Date -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center border-b border-gray-200 pb-3">
                                <label class="text-sm font-medium text-gray-700">{{ __('Uitleveringsdatum') }}</label>
                                <div class="md:col-span-2">
                                    <input type="date" name="date_delivered" value="{{ old('date_delivered', $warehouse->date_delivered ? $warehouse->date_delivered->format('Y-m-d') : '') }}" 
                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('date_delivered') border-red-500 @enderror">
                                    @error('date_delivered')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Stock Quantity -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center border-b border-gray-200 pb-3">
                                <label class="text-sm font-medium text-gray-700">{{ __('Aantal op voorraad') }}</label>
                                <div class="md:col-span-2">
                                    <div class="bg-gray-50 border border-gray-200 rounded-md px-3 py-2 text-sm text-gray-900">
                                        {{ $warehouse->quantity ?? '0' }}
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500">Dit veld kan niet worden bewerkt</p>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="mt-8 flex justify-between items-center">
                            <div class="flex space-x-3">
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    {{ __('Wijzig Product Details') }}
                                </button>
                            </div>
                            
                            <div class="flex space-x-3">
                                <a href="{{ route('product-stock.show', $product->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    {{ __('terug') }}
                                </a>
                                <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    {{ __('home') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

