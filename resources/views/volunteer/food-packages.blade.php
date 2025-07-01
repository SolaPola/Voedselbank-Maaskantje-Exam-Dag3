<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Overzicht Voedselpakketten voor Vrijwilligers') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(isset($error))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ $error }}</span>
                </div>
            @endif

            <!-- Pending Packages Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4 text-yellow-600">
                        {{ __('Uit te reiken Voedselpakketten') }}
                    </h3>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr>
                                    <th class="py-3 px-4 border-b text-left text-sm font-medium text-gray-600">PAKKETNUMMER</th>
                                    <th class="py-3 px-4 border-b text-left text-sm font-medium text-gray-600">GEZIN</th>
                                    <th class="py-3 px-4 border-b text-left text-sm font-medium text-gray-600">VERTEGENWOORDIGER</th>
                                    <th class="py-3 px-4 border-b text-left text-sm font-medium text-gray-600">DATUM SAMENSTELLING</th>
                                    <th class="py-3 px-4 border-b text-left text-sm font-medium text-gray-600">AANTAL PRODUCTEN</th>
                                    <th class="py-3 px-4 border-b text-left text-sm font-medium text-gray-600">WIJZIG STATUS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pendingPackages as $package)
                                <tr>
                                    <td class="py-3 px-4 border-b">{{ $package->package_number }}</td>
                                    <td class="py-3 px-4 border-b">{{ $package->family_name }}</td>
                                    <td class="py-3 px-4 border-b">{{ $package->representative_name ?? 'N/A' }}</td>
                                    <td class="py-3 px-4 border-b">{{ $package->date_composed ? date('d-m-Y', strtotime($package->date_composed)) : 'N/A' }}</td>
                                    <td class="py-3 px-4 border-b">{{ $package->product_count }}</td>
                                    <td class="py-3 px-4 border-b">
                                        <a href="{{ route('food-packages.edit', $package->id) }}" class="text-blue-600 hover:text-blue-900">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="py-3 px-4 border-b text-center">
                                        {{ __('Geen uit te reiken voedselpakketten gevonden') }}
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Issued Packages Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4 text-green-600">
                        {{ __('Uitgereikt Voedselpakketten') }}
                    </h3>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr>
                                    <th class="py-3 px-4 border-b text-left text-sm font-medium text-gray-600">PAKKETNUMMER</th>
                                    <th class="py-3 px-4 border-b text-left text-sm font-medium text-gray-600">GEZIN</th>
                                    <th class="py-3 px-4 border-b text-left text-sm font-medium text-gray-600">DATUM SAMENSTELLING</th>
                                    <th class="py-3 px-4 border-b text-left text-sm font-medium text-gray-600">DATUM UITGIFTE</th>
                                    <th class="py-3 px-4 border-b text-left text-sm font-medium text-gray-600">AANTAL PRODUCTEN</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($issuedPackages as $package)
                                <tr>
                                    <td class="py-3 px-4 border-b">{{ $package->package_number }}</td>
                                    <td class="py-3 px-4 border-b">{{ $package->family_name }}</td>
                                    <td class="py-3 px-4 border-b">{{ $package->date_composed ? date('d-m-Y', strtotime($package->date_composed)) : 'N/A' }}</td>
                                    <td class="py-3 px-4 border-b">{{ $package->date_issued ? date('d-m-Y', strtotime($package->date_issued)) : 'N/A' }}</td>
                                    <td class="py-3 px-4 border-b">{{ $package->product_count }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="py-3 px-4 border-b text-center">
                                        {{ __('Geen uitgereikt voedselpakketten gevonden') }}
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Canceled Packages Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4 text-red-600">
                        {{ __('Niet Meer Ingeschreven Voedselpakketten') }}
                    </h3>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr>
                                    <th class="py-3 px-4 border-b text-left text-sm font-medium text-gray-600">PAKKETNUMMER</th>
                                    <th class="py-3 px-4 border-b text-left text-sm font-medium text-gray-600">GEZIN</th>
                                    <th class="py-3 px-4 border-b text-left text-sm font-medium text-gray-600">DATUM SAMENSTELLING</th>
                                    <th class="py-3 px-4 border-b text-left text-sm font-medium text-gray-600">AANTAL PRODUCTEN</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($canceledPackages as $package)
                                <tr>
                                    <td class="py-3 px-4 border-b">{{ $package->package_number }}</td>
                                    <td class="py-3 px-4 border-b">{{ $package->family_name }}</td>
                                    <td class="py-3 px-4 border-b">{{ $package->date_composed ? date('d-m-Y', strtotime($package->date_composed)) : 'N/A' }}</td>
                                    <td class="py-3 px-4 border-b">{{ $package->product_count }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="py-3 px-4 border-b text-center">
                                        {{ __('Geen niet meer ingeschreven voedselpakketten gevonden') }}
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="mt-4 flex justify-end">
                <a href="{{ route('volunteer.dashboard') }}" class="px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('home') }}
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
