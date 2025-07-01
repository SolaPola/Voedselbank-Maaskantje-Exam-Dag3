<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-green-600 leading-tight">
            {{ __('Overzicht Voedselpakketten voor Vrijwilligers') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(isset($error))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ $error }}</span>
                </div>
            @endif

            <!-- Single table layout -->
            <div class="bg-white overflow-hidden mb-6">
                <table class="min-w-full border-collapse">
                    <thead>
                        <tr>
                            <th class="border px-4 py-2 text-left">Pakketnummer</th>
                            <th class="border px-4 py-2 text-left">Gezin</th>
                            <th class="border px-4 py-2 text-left">Vertegenwoordiger</th>
                            <th class="border px-4 py-2 text-left">Datum samenstelling</th>
                            <th class="border px-4 py-2 text-left">Datum uitgifte</th>
                            <th class="border px-4 py-2 text-left">Status</th>
                            <th class="border px-4 py-2 text-left">Aantal producten</th>
                            <th class="border px-4 py-2 text-center">Details Bekijken</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($packages as $package)
                        <tr>
                            <td class="border px-4 py-2">{{ $package->package_number }}</td>
                            <td class="border px-4 py-2">{{ $package->family_name }}</td>
                            <td class="border px-4 py-2">{{ $package->representative_name ?? '-' }}</td>
                            <td class="border px-4 py-2">{{ $package->date_composed ? date('d-m-Y', strtotime($package->date_composed)) : '-' }}</td>
                            <td class="border px-4 py-2">{{ $package->date_issued ? date('d-m-Y', strtotime($package->date_issued)) : '-' }}</td>
                            <td class="border px-4 py-2">
                                @if($package->status == 'Uitgereikt')
                                    Uitgereikt
                                @elseif($package->status == 'NietUitgereikt')
                                    Niet Uitgereikt
                                @else
                                    Niet Meer Ingeschreven
                                @endif
                            </td>
                            <td class="border px-4 py-2">{{ $package->product_count }}</td>
                            <td class="border px-4 py-2 text-center">
                                <a href="{{ route('volunteer.food-packages.family', $package->family_id) }}" class="text-blue-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="border px-4 py-2 text-center">
                                {{ __('Geen voedselpakketten gevonden') }}
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4 flex justify-end">
                <a href="{{ route('volunteer.dashboard') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md">
                    home
                </a>
            </div>
        </div>
    </div>
</x-app-layout>

