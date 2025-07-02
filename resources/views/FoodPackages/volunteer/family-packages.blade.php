<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-green-600 leading-tight">
            {{ __('Overzicht Voedselpakketten') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">
                <!-- Family information section -->
                <div class="mb-6 border-b pb-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-gray-600">Naam:</p>
                            <p>{{ $family->name }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Omschrijving:</p>
                            <p>{{ $family->description }}</p>
                        </div>
                    </div>
                    <div class="mt-3">
                        <p class="text-gray-600">Totaal aantal Personen:</p>
                        <p>{{ $family->total_number_of_people }}</p>
                    </div>
                </div>

                <!-- Food packages table -->
                <div>
                    <table class="min-w-full border-collapse">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 border-b-2 text-left">Pakketnummer</th>
                                <th class="px-4 py-2 border-b-2 text-left">Datum samenstelling</th>
                                <th class="px-4 py-2 border-b-2 text-left">Datum uitgifte</th>
                                <th class="px-4 py-2 border-b-2 text-left">Status</th>
                                <th class="px-4 py-2 border-b-2 text-left">Aantal producten</th>
                                <th class="px-4 py-2 border-b-2 text-center">Wijzig Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($packages as $package)
                            <tr @if(session('status_changed') && session('status_changed')['package_id'] == $package->id) class="bg-green-50" @endif>
                                <td class="px-4 py-2 border-b">{{ $package->package_number }}</td>
                                <td class="px-4 py-2 border-b">{{ $package->date_composed ? date('d-m-Y', strtotime($package->date_composed)) : '-' }}</td>
                                <td class="px-4 py-2 border-b">{{ $package->date_issued ? date('d-m-Y', strtotime($package->date_issued)) : '-' }}</td>
                                <td class="px-4 py-2 border-b">
                                    @if($package->status == 'Uitgereikt')
                                        Uitgereikt
                                    @elseif($package->status == 'NietUitgereikt')
                                        Niet Uitgereikt
                                    @else
                                        Niet Meer Ingeschreven
                                    @endif
                                </td>
                                <td class="px-4 py-2 border-b">{{ $package->product_count }}</td>
                                <td class="px-4 py-2 border-b text-center">
                                    <a href="{{ route('volunteer.food-packages.edit', $package->id) }}" class="text-blue-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-4 py-2 border-b text-center">
                                    {{ __('Geen voedselpakketten gevonden') }}
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-6 flex justify-end space-x-2">
                    <a href="{{ route('volunteer.food-packages') }}" class="px-4 py-2 bg-blue-500 text-white rounded-md">
                        {{ __('terug') }}
                    </a>
                    <a href="{{ route('volunteer.dashboard') }}" class="px-4 py-2 bg-indigo-500 text-white rounded-md">
                        {{ __('home') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    @if(session('success'))
        <div id="success-message" class="fixed top-0 left-0 right-0 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded z-50 text-center" style="margin: 1rem auto; max-width: 500px;">
            <strong>{{ session('success') }}</strong>
        </div>

        <script>
            // Hide success message after 3 seconds
            setTimeout(function() {
                const element = document.getElementById('success-message');
                if (element) {
                    element.style.opacity = '0';
                    element.style.transition = 'opacity 0.5s';
                    setTimeout(function() {
                        element.remove();
                    }, 500);
                }
            }, 3000);
        </script>
    @endif
</x-app-layout>