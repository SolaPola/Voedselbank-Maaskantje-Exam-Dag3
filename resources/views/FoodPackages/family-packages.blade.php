<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Overzicht Voedselpakketten') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Family information section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <span class="text-sm font-medium text-gray-500">{{ __('Naam:') }}</span>
                            <p class="font-medium">{{ $family->name }}</p>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-500">{{ __('Omschrijving:') }}</span>
                            <p class="font-medium">{{ $family->description }}</p>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-500">{{ __('Totaal aantal Personen:') }}</span>
                            <p class="font-medium">{{ $family->total_number_of_people }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Success message -->
            @if(session('success'))
                <div id="success-message" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-md mb-6" role="alert">
                    <p class="text-center">{{ session('success') }}</p>
                </div>
                <script>
                    // Hide success message after 3 seconds and redirect
                    setTimeout(function() {
                        document.getElementById('success-message').style.display = 'none';
                    }, 3000);
                </script>
            @endif

            <!-- Food packages table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        {{ __('Pakketnummer') }}
                                    </th>
                                    <th class="px-6 py-3 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        {{ __('Datum samenstelling') }}
                                    </th>
                                    <th class="px-6 py-3 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        {{ __('Datum uitgifte') }}
                                    </th>
                                    <th class="px-6 py-3 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        {{ __('Status') }}
                                    </th>
                                    <th class="px-6 py-3 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        {{ __('Aantal producten') }}
                                    </th>
                                    <th class="px-6 py-3 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        {{ __('Wijzig Status') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($packages as $package)
                                <tr @if(session('status_changed') && session('status_changed')['package_id'] == $package->id) class="bg-green-50" @endif>
                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                        {{ $package->package_number }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                        {{ $package->date_composed ? date('d-m-Y', strtotime($package->date_composed)) : '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                        {{ $package->date_issued ? date('d-m-Y', strtotime($package->date_issued)) : '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                        @if($package->status == 'Uitgereikt')
                                            Uitgereikt
                                        @elseif($package->status == 'NietUitgereikt')
                                            Niet Uitgereikt
                                        @else
                                            Niet Meer Ingeschreven
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                        {{ $package->product_count }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-center">
                                        <a href="{{ route('food-packages.edit', $package->id) }}" class="text-blue-600 hover:text-blue-900">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-center">
                                        {{ __('Geen voedselpakketten gevonden') }}
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4 flex justify-end space-x-2">
                        <a href="{{ route('FoodPackages.food-packages') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            {{ __('terug') }}
                        </a>
                        <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            {{ __('home') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

