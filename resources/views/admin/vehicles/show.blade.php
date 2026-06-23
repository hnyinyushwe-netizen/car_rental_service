<x-admin.layout>
    @php
        $vehicles = [
            1 => ['name' => 'Toyota Land Cruiser', 'category' => 'SUV', 'brand' => 'Toyota', 'model' => 'Land Cruiser 300', 'plate' => 'SKL-101', 'price' => 129, 'status' => 'Available', 'fuel' => 'Petrol', 'transmission' => 'Automatic', 'seats' => 7, 'vin' => 'VIN111'],
            2 => ['name' => 'Tesla Model S', 'category' => 'Electric', 'brand' => 'Tesla', 'model' => 'Model S Plaid', 'plate' => 'EV-204', 'price' => 189, 'status' => 'Rented', 'fuel' => 'Electric', 'transmission' => 'Automatic', 'seats' => 5, 'vin' => 'VIN222'],
        ];

        $vehicle = $vehicles[$vehicleId] ?? $vehicles[1];
        $statusClass = match ($vehicle['status']) {
            'Available' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-950 dark:text-emerald-300',
            'Rented' => 'bg-cyan-100 text-cyan-700 dark:bg-cyan-950 dark:text-cyan-300',
            default => 'bg-amber-100 text-amber-700 dark:bg-amber-950 dark:text-amber-300',
        };
    @endphp

    <div class="p-4 sm:p-6 md:p-8">
        <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <a href="{{ route('admin.vehicle.index') }}" class="mb-3 inline-flex items-center gap-2 text-sm font-semibold text-cyan-600 hover:text-cyan-700 dark:text-cyan-400">
                    <i data-lucide="arrow-left" class="h-4 w-4"></i>
                    Back to vehicles
                </a>
                <h1 class="text-3xl font-bold text-slate-900 dark:text-white">{{ $vehicle['name'] }}</h1>
                <p class="mt-1 text-slate-600 dark:text-slate-400">{{ $vehicle['brand'] }} {{ $vehicle['model'] }} vehicle profile and fleet details.</p>
            </div>

            <div class="flex flex-wrap gap-3">
                <button type="button" class="inline-flex items-center justify-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm">
                    <i data-lucide="edit-2" class="h-4 w-4"></i>
                    Edit
                </button>
                <button type="button" class="inline-flex items-center justify-center gap-2 rounded-lg bg-gradient-to-r from-cyan-500 to-blue-600 px-4 py-2.5 text-sm font-bold text-white shadow-lg">
                    <i data-lucide="calendar-plus" class="h-4 w-4"></i>
                    New Booking
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
            <section class="xl:col-span-2 overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-800">
                <div class="flex aspect-[16/7] items-center justify-center bg-gradient-to-br from-cyan-500 via-blue-600 to-slate-900">
                    <i data-lucide="car" class="h-24 w-24 text-white/70"></i>
                </div>
                <div class="p-6">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                        <div>
                            <h2 class="text-xl font-bold text-slate-900 dark:text-white">{{ $vehicle['brand'] }} {{ $vehicle['model'] }}</h2>
                            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">{{ $vehicle['category'] }} fleet class</p>
                        </div>
                        <span class="inline-flex w-fit items-center gap-2 rounded-full px-3 py-1 text-xs font-bold {{ $statusClass }}">
                            <span class="h-2 w-2 rounded-full bg-current"></span>
                            {{ $vehicle['status'] }}
                        </span>
                    </div>

                    <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                        <div class="rounded-xl bg-slate-50 p-4 dark:bg-slate-900">
                            <p class="text-xs font-medium text-slate-500 dark:text-slate-400">Daily Rate</p>
                            <p class="mt-2 text-2xl font-bold text-slate-900 dark:text-white">${{ $vehicle['price'] }}</p>
                        </div>
                        <div class="rounded-xl bg-slate-50 p-4 dark:bg-slate-900">
                            <p class="text-xs font-medium text-slate-500 dark:text-slate-400">Plate Number</p>
                            <p class="mt-2 text-lg font-bold text-slate-900 dark:text-white">{{ $vehicle['plate'] }}</p>
                        </div>
                        <div class="rounded-xl bg-slate-50 p-4 dark:bg-slate-900">
                            <p class="text-xs font-medium text-slate-500 dark:text-slate-400">Mileage</p>
                            <p class="mt-2 text-lg font-bold text-slate-900 dark:text-white">{{ $vehicle['mileage'] ?? '—' }}</p>
                        </div>
                        <div class="rounded-xl bg-slate-50 p-4 dark:bg-slate-900">
                            <p class="text-xs font-medium text-slate-500 dark:text-slate-400">Location</p>
                            <p class="mt-2 text-lg font-bold text-slate-900 dark:text-white">{{ $vehicle['location'] ?? 'Unknown' }}</p>
                        </div>
                    </div>
                </div>
            </section>

            <aside class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-700 dark:bg-slate-800">
                <h2 class="text-lg font-bold text-slate-900 dark:text-white">Specifications</h2>
                <div class="mt-5 space-y-4">
                    @foreach ([
                        'Category' => $vehicle['category'],
                        'Brand' => $vehicle['brand'],
                        'Model' => $vehicle['model'],
                        'Fuel Type' => $vehicle['fuel'],
                        'Transmission' => $vehicle['transmission'],
                        'Seats' => $vehicle['seats'],
                        'VIN' => $vehicle['vin'],
                    ] as $label => $value)
                        <div class="flex items-start justify-between gap-4 border-b border-slate-100 pb-3 last:border-0 dark:border-slate-700">
                            <span class="text-sm text-slate-500 dark:text-slate-400">{{ $label }}</span>
                            <span class="text-sm font-medium text-slate-900 dark:text-white">{{ $value }}</span>
                        </div>
                    @endforeach
                </div>
            </aside>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Ensure icons are rendered after any dynamic changes
                if (typeof window.initLucideIcons === 'function') window.initLucideIcons();

                // Expose simple action examples using shared api/toast
                window.deleteVehicle = function(vehicleId) {
                    if (!confirm('Are you sure you want to delete this vehicle? This action is irreversible.')) return;
                    if (window.api && window.api.delete) {
                        window.api.delete(`/api/vehicles/${vehicleId}`)
                            .then(resp => { window.toast?.success(resp.data?.message || 'Vehicle removed'); window.location.reload(); })
                            .catch(err => window.toast?.error(err.response?.data?.message || 'Failed to delete vehicle'));
                    } else {
                        $.ajax({ url: `/api/vehicles/${vehicleId}`, method: 'DELETE' }).done(function(){ window.location.reload(); }).fail(function(xhr){ window.toast?.error(xhr.responseJSON?.message || 'Failed to delete vehicle'); });
                    }
                }
            });
        </script>
    @endpush
</x-admin.layout>
