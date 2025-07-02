<x-app-layout>
    <x-slot name="header">
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="flex justify-between items-center mb-4">
                        <h1 class="text-2xl font-bold text-green-600 underline">
                            Overzicht Product
                        </h1>
                        
                        <form action="{{ route('product-stock.index') }}" method="GET" class="flex items-center">
                            <div class="relative inline-block">
                                <select name="category_filter" id="filterSelect"
                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm pl-3 pr-10 py-2">
                                    <option value="">Alle Categorieën</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ request('category_filter') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }} - {{ $category->description }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit"
                                class="ml-4 px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700">
                                {{ __('Toon Voorraad') }}
                            </button>
                        </form>
                    </div>

                    @if (count($productStock) > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border border-gray-200">
                                <thead>
                                    <tr>
                                        <th
                                            class="px-6 py-3 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            {{ __('Productnaam') }}
                                        </th>
                                        <th
                                            class="px-6 py-3 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            {{ __('Categorie') }}
                                        </th>
                                        <th
                                            class="px-6 py-3 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            {{ __('Eenheid') }}
                                        </th>
                                        <th
                                            class="px-6 py-3 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            {{ __('Aantal') }}
                                        </th>
                                        <th
                                            class="px-6 py-3 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            {{ __('Houdbaarheidsdatum') }}
                                        </th>
                                        <th
                                            class="px-6 py-3 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            {{ __('Locatie') }}
                                        </th>
                                        <th
                                            class="px-6 py-3 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            {{ __('Details') }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($productStock as $item)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                                {{ $item->product_name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                                {{ $item->category_name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                                {{ $item->packaging_unit }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                    {{ $item->quantity < 10 ? 'bg-red-100 text-red-800' : ($item->quantity < 50 ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                                                    {{ $item->quantity }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                                @if ($item->expiry_date)
                                                    {{ \Carbon\Carbon::parse($item->expiry_date)->format('d/m/Y') }}
                                                @else
                                                    <span class="text-gray-400">Geen vervaldatum</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                                {{ $item->location ?? 'Niet gespecificeerd' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                                <a href="{{ route('product-stock.show', $item->product_id) }}"
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
                            {{ __('Er zijn geen producten bekend die behoren bij de geselecteerde productcategorie') }}
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

    <!-- Product Details Modal -->
    <div id="productModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900" id="modalTitle">{{ __('Product Details') }}</h3>
                    <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div id="modalContent" class="text-sm text-gray-700">
                    <!-- Content will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <script>
        function showProductDetails(productId) {
            // Show modal
            document.getElementById('productModal').classList.remove('hidden');

            // Show loading state
            document.getElementById('modalContent').innerHTML = '<div class="text-center py-4">{{ __('Laden...') }}</div>';

            // Fetch product details
            fetch(`/product-stock/details/${productId}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('modalContent').innerHTML = `
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <h4 class="font-semibold text-gray-900 mb-2">{{ __('Product Informatie') }}</h4>
                                <p><strong>{{ __('Naam') }}:</strong> ${data.name}</p>
                                <p><strong>{{ __('Categorie') }}:</strong> ${data.category_name}</p>
                                <p><strong>{{ __('Barcode') }}:</strong> ${data.barcode || '{{ __('Geen barcode') }}'}</p>
                                <p><strong>{{ __('Status') }}:</strong> ${data.status}</p>
                                <p><strong>{{ __('Allergieën') }}:</strong> ${data.allergy_type || '{{ __('Geen allergieën') }}'}</p>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900 mb-2">{{ __('Voorraad Informatie') }}</h4>
                                <p><strong>{{ __('Aantal') }}:</strong> ${data.quantity}</p>
                                <p><strong>{{ __('Verpakkingseenheid') }}:</strong> ${data.packaging_unit}</p>
                                <p><strong>{{ __('Locatie') }}:</strong> ${data.location || '{{ __('Niet gespecificeerd') }}'}</p>
                                <p><strong>{{ __('Ontvangen') }}:</strong> ${data.date_received ? new Date(data.date_received).toLocaleDateString('nl-NL') : '{{ __('Onbekend') }}'}</p>
                                <p><strong>{{ __('Vervaldatum') }}:</strong> ${data.expiry_date ? new Date(data.expiry_date).toLocaleDateString('nl-NL') : '{{ __('Geen vervaldatum') }}'}</p>
                            </div>
                        </div>
                        ${data.description ? `
                                <div class="mt-4">
                                    <h4 class="font-semibold text-gray-900 mb-2">{{ __('Beschrijving') }}</h4>
                                    <p class="text-gray-600">${data.description}</p>
                                </div>
                            ` : ''}
                    `;
                })
                .catch(error => {
                    document.getElementById('modalContent').innerHTML =
                        '<div class="text-red-600 text-center py-4">{{ __('Fout bij het laden van product details') }}</div>';
                });
        }

        function closeModal() {
            document.getElementById('productModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('productModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
    </script>
</x-app-layout>
