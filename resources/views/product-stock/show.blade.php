<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Product Details') }} - {{ $product->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Green Title Section -->
                    <div class="mb-6 text-center">
                        <h1 class="text-2xl font-bold text-green-600 text-left">
                            Product Details {{ $product->name }}
                        </h1>
                    </div>

                    <div class="space-y-4">
                        <!-- Product Name -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center border-b border-gray-200 pb-3">
                            <label class="text-sm font-medium text-gray-700">{{ __('Productnaam') }}</label>
                            <div class="md:col-span-2">
                                <div class="bg-gray-50 border border-gray-200 rounded-md px-3 py-2 text-sm text-gray-900">
                                    {{ $product->name ?? '~' }}
                                </div>
                            </div>
                        </div>

                        <!-- Expiry Date -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center border-b border-gray-200 pb-3">
                            <label class="text-sm font-medium text-gray-700">{{ __('Houdbaarheidsdatum') }}</label>
                            <div class="md:col-span-2">
                                <div class="bg-gray-50 border border-gray-200 rounded-md px-3 py-2 text-sm text-gray-900">
                                    {{ $product->expiry_date ? \Carbon\Carbon::parse($product->expiry_date)->format('d/m/Y') : '~' }}
                                </div>
                            </div>
                        </div>

                        <!-- Barcode -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center border-b border-gray-200 pb-3">
                            <label class="text-sm font-medium text-gray-700">{{ __('Barcode') }}</label>
                            <div class="md:col-span-2">
                                <div class="bg-gray-50 border border-gray-200 rounded-md px-3 py-2 text-sm text-gray-900">
                                    {{ $product->barcode ?? '~' }}
                                </div>
                            </div>
                        </div>

                        <!-- Magazine Location -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center border-b border-gray-200 pb-3">
                            <label class="text-sm font-medium text-gray-700">{{ __('Magazijn locatie') }}</label>
                            <div class="md:col-span-2">
                                <div class="bg-gray-50 border border-gray-200 rounded-md px-3 py-2 text-sm text-gray-900">
                                    {{ $productPerWarehouse->location ?? '~' }}
                                </div>
                            </div>
                        </div>

                        <!-- Received Date -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center border-b border-gray-200 pb-3">
                            <label class="text-sm font-medium text-gray-700">{{ __('Ontvangstdatum') }}</label>
                            <div class="md:col-span-2">
                                <div class="bg-gray-50 border border-gray-200 rounded-md px-3 py-2 text-sm text-gray-900">
                                    {{ $warehouse->date_received ? \Carbon\Carbon::parse($warehouse->date_received)->format('d/m/Y') : '~' }}
                                </div>
                            </div>
                        </div>

                        <!-- Delivery Date -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center border-b border-gray-200 pb-3">
                            <label class="text-sm font-medium text-gray-700">{{ __('Uitleveringsdatum') }}</label>
                            <div class="md:col-span-2">
                                <div class="bg-gray-50 border border-gray-200 rounded-md px-3 py-2 text-sm text-gray-900">
                                    {{ $warehouse->date_delivered ? \Carbon\Carbon::parse($warehouse->date_delivered)->format('d/m/Y') : '~' }}
                                </div>
                            </div>
                        </div>

                        <!-- Stock Quantity -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center border-b border-gray-200 pb-3">
                            <label class="text-sm font-medium text-gray-700">{{ __('Aantal op voorraad') }}</label>
                            <div class="md:col-span-2">
                                <div class="bg-gray-50 border border-gray-200 rounded-md px-3 py-2 text-sm text-gray-900">
                                    {{ $warehouse->quantity ?? '~' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-8 flex justify-between items-center">
                        <div class="flex space-x-3">
                            <a href="{{ route('product-stock.edit', $product->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Wijzig') }}
                            </a>
                        </div>
                        
                        <div class="flex space-x-3">
                            <a href="{{ route('product-stock.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('terug') }}
                            </a>
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('home') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
