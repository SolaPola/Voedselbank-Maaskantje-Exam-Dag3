<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Overzicht ProductVoorraaden') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
 
                    <div class="flex justify-end mb-4">
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
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="p-4 bg-yellow-50 text-yellow-700 border border-yellow-200 rounded-lg text-center">
                            {{ __('Er zijn momenteel geen producten in de magazijnvoorraad.') }}
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
