{{-- filepath: c:\Users\bilag\OneDrive - MBO Utrecht\MBO-U-Leerljaar-2\Periode 4\Exam\day 3\code\Voedselbank-Maaskantje-Exam-Dag3-dev-dag03\resources\views\supplier\edit.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Wijzig Product') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- Green Title Section -->
                    <div class="mb-6">
                        <h1 class="text-2xl font-bold text-green-600 text-left">
                            Wijzig Product
                        </h1>
                    </div>

                    <!-- Success Message -->
                    @if(session('success'))
                        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative flex items-center gap-2">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif

                    <!-- Error Messages -->
                    @if(session('error'))
                        <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative flex items-center gap-2">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            <span>{{ session('error') }}</span>
                        </div>
                    @endif

                    @if(session('date_error'))
                        <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative flex items-center gap-2">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            <span>{{ session('date_error') }}</span>
                        </div>
                    @endif

                    <!-- Edit Form -->
                    <form method="POST" action="{{ route('supplier.edit', $product->id) }}" class="space-y-6">
                        @csrf
                        @method('POST')
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center border-b border-gray-200 pb-3">
                            <label class="text-sm font-medium text-gray-700" for="expiry_date">
                                {{ __('Houdbaarheidsdatum') }}:
                            </label>
                            <div class="md:col-span-2">
                                <input type="date" 
                                       id="expiry_date" 
                                       name="expiry_date" 
                                       value="{{ $product->expiry_date }}" 
                                       class="w-full bg-white border border-gray-200 rounded-md px-3 py-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500">
                            </div>
                        </div>

                        <!-- Warning Message -->
                        <div class="p-4 bg-red-50 border border-red-200 rounded-lg">
                            <p class="text-red-700 font-medium text-sm">
                                De houdbaarheidsdatum mag met maximaal 7 dagen worden verlengd
                            </p>
                        </div>

                        <!-- Action Buttons -->
                        <div class="mt-8 flex flex-col sm:flex-row sm:justify-between items-start sm:items-center gap-4">
                            <button type="submit" 
                                    class="inline-flex items-center px-6 py-2 bg-gray-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-600 focus:bg-gray-600 active:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Wijzig Houdbaarheidsdatum') }}
                            </button>
                            
                            <div class="flex space-x-3">
                                <a href="{{ route('manager.suppliers.show', ['supplier' => $product->supplier_id]) }}" 
                                   class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                    {{ __('Terug') }}
                                </a>
                                <a href="{{ route('dashboard') }}" 
                                   class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                    {{ __('Home') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>