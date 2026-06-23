<x-admin.layout>
    <div class="p-4 sm:p-6 md:p-8">
        <!-- Header Section -->
        <div class="mb-5 rounded-xl bg-gradient-to-br from-cyan-500/10 via-blue-500/5 to-purple-500/10 px-4 py-3 sm:px-5 sm:py-4 backdrop-blur-sm border border-cyan-500/20 dark:border-cyan-500/10">
            <div class="flex items-center justify-between flex-wrap gap-3">
                <div>
                    <h1 class="text-xl sm:text-2xl font-bold bg-gradient-to-r from-cyan-600 to-blue-600 dark:from-cyan-400 dark:to-blue-400 bg-clip-text text-transparent">
                        Vehicles
                    </h1>
                    <p class="mt-0.5 text-sm text-slate-600 dark:text-slate-400 flex items-center gap-2">
                        <i data-lucide="truck" class="h-4 w-4"></i>
                        Manage your fleet inventory
                    </p>
                </div>
                <a href="{{ route('admin.vehicles.create') }}"
                    class="group flex items-center gap-2 rounded-xl bg-gradient-to-r from-cyan-500 to-blue-600 px-5 py-2.5 text-sm font-medium text-white shadow-lg transition-all hover:shadow-xl">
                    <i data-lucide="plus" class="h-5 w-5 transition-transform group-hover:rotate-90"></i>
                    Add New Vehicle
                </a>
            </div>
        </div>

        <!-- Search and Filter -->
        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div class="relative flex-1 max-w-md">
                <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400"></i>
                <input type="text" id="searchInput" placeholder="Search by model, brand, or license plate..."
                    class="w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 pl-9 pr-4 py-2.5 text-sm">
            </div>
            <div class="flex gap-2">
                <select id="statusFilter"
                    class="rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-4 py-2.5 text-sm">
                    <option value="">All Status</option>
                    <option value="available">Available</option>
                    <option value="rented">Rented</option>
                    <option value="maintenance">Maintenance</option>
                </select>
                <button id="reloadBtn"
                    class="rounded-xl border border-slate-300 dark:border-slate-600 px-4 py-2.5 text-sm text-slate-700 dark:text-slate-300">
                    <i data-lucide="refresh-cw" class="h-4 w-4"></i>
                </button>
            </div>
        </div>

        <!-- Vehicles Table -->
        <div class="rounded-2xl border border-slate-200/60 dark:border-slate-700/60 bg-white/90 dark:bg-slate-800/90 shadow-xl p-4">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-slate-200/60 dark:border-slate-700/60 bg-slate-50/50 dark:bg-slate-900/30">
                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Vehicle</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">License Plate</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Status</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="vehiclesTableBody" class="divide-y divide-slate-100 dark:divide-slate-700/50 text-sm text-slate-700 dark:text-slate-300">
                        <tr>
                            <td colspan="4" class="py-6 text-center text-slate-400">Loading vehicles...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const $tableBody = $('#vehiclesTableBody');
                const $search = $('#searchInput');
                const $status = $('#statusFilter');
                const $reload = $('#reloadBtn');

                function renderRows(items) {
                    if (!items || items.length === 0) {
                        $tableBody.html('<tr><td colspan="4" class="py-6 text-center text-slate-400">No vehicles found.</td></tr>');
                        return;
                    }
                    let rows = '';
                    items.forEach(vehicle => {
                        rows += `
                            <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-700/20 transition-colors">
                                <td class="py-3 px-4 font-medium text-slate-900 dark:text-white">${vehicle.brand} ${vehicle.model}</td>
                                <td class="py-3 px-4">${vehicle.license_plate}</td>
                                <td class="py-3 px-4">${vehicle.status}</td>
                                <td class="py-3 px-4 text-right">
                                    <a href="/admin/vehicles/${vehicle.id}" class="inline-flex items-center px-3 py-1 rounded-lg border">View</a>
                                </td>
                            </tr>`;
                    });
                    $tableBody.html(rows);
                    if (typeof window.initLucideIcons === 'function') window.initLucideIcons();
                }

                function loadVehicles() {
                    const params = {};
                    if ($search.val().trim()) params.q = $search.val().trim();
                    if ($status.val()) params.status = $status.val();

                    // Use shared axios wrapper
                    if (window.api && window.api.get) {
                        window.api.get('/api/vehicles', { params })
                            .then(resp => renderRows(resp.data.data || resp.data))
                            .catch(err => {
                                window.toast?.error(err.response?.data?.message || 'Failed to load vehicles');
                            });
                    } else {
                        // fallback to jQuery ajax
                        $.ajax({ url: '/api/vehicles', method: 'GET', data: params })
                            .done(resp => renderRows(resp.data || resp))
                            .fail(xhr => window.toast?.error(xhr.responseJSON?.message || 'Failed to load vehicles'));
                    }
                }

                $search.on('keyup', debounce(() => loadVehicles(), 350));
                $status.on('change', loadVehicles);
                $reload.on('click', function() { loadVehicles(); });

                // simple debounce
                function debounce(fn, wait) {
                    let t;
                    return function() { clearTimeout(t); const args = arguments; t = setTimeout(() => fn.apply(this, args), wait); };
                }

                loadVehicles();
            });
        </script>
    @endpush
</x-admin.layout>
