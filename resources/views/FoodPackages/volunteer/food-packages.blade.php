{{-- filepath: c:\Users\bilag\OneDrive - MBO Utrecht\MBO-U-Leerljaar-2\Periode 4\Exam\day 3\code\Voedselbank-Maaskantje-Exam-Dag3-dev-dag03\resources\views\FoodPackages\volunteer\food-packages.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Overzicht Voedselpakketten voor Vrijwilligers') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if(isset($error))
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                            <span class="block sm:inline">{{ $error }}</span>
                        </div>
                    @endif

                    @if (count($packages) > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border border-gray-200">
                                <thead>
                                    <tr>
                                        <th
                                            class="px-6 py-3 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            {{ __('Pakketnummer') }}
                                        </th>
                                        <th
                                            class="px-6 py-3 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            {{ __('Gezin') }}
                                        </th>
                                        <th
                                            class="px-6 py-3 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            {{ __('Vertegenwoordiger') }}
                                        </th>
                                        <th
                                            class="px-6 py-3 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            {{ __('Datum samenstelling') }}
                                        </th>
                                        <th
                                            class="px-6 py-3 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            {{ __('Datum uitgifte') }}
                                        </th>
                                        <th
                                            class="px-6 py-3 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            {{ __('Status') }}
                                        </th>
                                        <th
                                            class="px-6 py-3 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            {{ __('Aantal producten') }}
                                        </th>
                                        <th
                                            class="px-6 py-3 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            {{ __('Details') }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($packages as $package)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                                {{ $package->package_number }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                                {{ $package->family_name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                                {{ $package->representative_name ?? '-' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                                {{ $package->date_composed ? date('d-m-Y', strtotime($package->date_composed)) : '-' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                                {{ $package->date_issued ? date('d-m-Y', strtotime($package->date_issued)) : '-' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                                @if($package->status == 'Uitgereikt')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        Uitgereikt
                                                    </span>
                                                @elseif($package->status == 'NietUitgereikt')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                        Niet Uitgereikt
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                        Niet Meer Ingeschreven
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                                {{ $package->product_count }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                                <a href="{{ route('volunteer.food-packages.family', $package->family_id) }}"
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
                            {{ __('Geen voedselpakketten gevonden') }}
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