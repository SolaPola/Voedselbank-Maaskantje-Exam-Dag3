{{-- filepath: c:\Users\bilag\OneDrive - MBO Utrecht\MBO-U-Leerljaar-2\Periode 4\Exam\day 3\code\Voedselbank-Maaskantje-Exam-Dag3-dev-dag03\resources\views\FoodPackages\volunteer\food-packages.blade.php --}}
<x-app-layout>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="font-semibold text-xl text-green-600 leading-tight">
                            {{ __('Overzicht gezinnen met voedselpakketten') }}
                        </h2>
                        
                        <div class="flex items-center">
                            <form action="{{ route('volunteer.food-packages') }}" method="GET" class="flex items-center">
                                <div class="relative inline-block">
                                    <select name="diet_preference" id="filterSelect"
                                        class="border-gray-300 rounded-md shadow-sm pl-3 pr-10 py-2">
                                        <option value="">Selecteer Eetwens</option>
                                        @foreach($dietPreferences ?? [] as $dietPreference)
                                            <option value="{{ $dietPreference->id }}" {{ $selectedDietPreference == $dietPreference->id ? 'selected' : '' }}>
                                                {{ $dietPreference->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit"
                                    class="ml-4 px-4 py-2 bg-gray-600 text-white rounded-md">
                                    {{ __('Toon Gezinnen') }}
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    @if(isset($error))
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                            <span class="block sm:inline">{{ $error }}</span>
                        </div>
                    @endif

                    @if (count($packages) > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full">
                                <thead>
                                    <tr class="border-b">
                                        <th class="py-3 px-4 text-left font-medium">{{ __('Pakketnummer') }}</th>
                                        <th class="py-3 px-4 text-left font-medium">{{ __('Gezin') }}</th>
                                        <th class="py-3 px-4 text-left font-medium">{{ __('Vertegenwoordiger') }}</th>
                                        <th class="py-3 px-4 text-left font-medium">{{ __('Datum samenstelling') }}</th>
                                        <th class="py-3 px-4 text-left font-medium">{{ __('Datum uitgifte') }}</th>
                                        <th class="py-3 px-4 text-left font-medium">{{ __('Status') }}</th>
                                        <th class="py-3 px-4 text-left font-medium">{{ __('Aantal producten') }}</th>
                                        <th class="py-3 px-4 text-center font-medium">{{ __('Details Bekijken') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($packages as $package)
                                        <tr class="border-b hover:bg-gray-50">
                                            <td class="py-3 px-4">{{ $package->package_number }}</td>
                                            <td class="py-3 px-4">{{ $package->family_name }}</td>
                                            <td class="py-3 px-4">{{ $package->representative_name ?? '~~~~' }}</td>
                                            <td class="py-3 px-4">{{ $package->date_composed ? date('d-m-Y', strtotime($package->date_composed)) : '~~~~' }}</td>
                                            <td class="py-3 px-4">{{ $package->date_issued ? date('d-m-Y', strtotime($package->date_issued)) : '~~~~' }}</td>
                                            <td class="py-3 px-4">
                                                @if($package->status == 'Uitgereikt')
                                                    Uitgereikt
                                                @elseif($package->status == 'NietUitgereikt')
                                                    Niet Uitgereikt
                                                @else
                                                    Niet Meer Ingeschreven
                                                @endif
                                            </td>
                                            <td class="py-3 px-4">{{ $package->product_count }}</td>
                                            <td class="py-3 px-4 text-center">
                                                <a href="{{ route('volunteer.food-packages.family', $package->family_id) }}" class="text-blue-300 flex justify-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-box" viewBox="0 0 16 16">
                                                      <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5 8 5.961 14.154 3.5zM15 4.239l-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464z"/>
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