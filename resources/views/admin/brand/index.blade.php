<x-admin.layout>
    <div class="p-4 sm:p-6 md:p-8">
        <!-- Header Section -->
        <div class="mb-5 rounded-xl bg-gradient-to-br from-cyan-500/10 via-blue-500/5 to-purple-500/10 px-4 py-3 sm:px-5 sm:py-4 backdrop-blur-sm border border-cyan-500/20 dark:border-cyan-500/10">
            <div class="flex items-center justify-between flex-wrap gap-3">
                <div>
                    <h1 class="text-xl sm:text-2xl font-bold bg-gradient-to-r from-cyan-600 to-blue-600 dark:from-cyan-400 dark:to-blue-400 bg-clip-text text-transparent">
                        Vehicle Brands
                    </h1>
                    <p class="mt-0.5 text-sm text-slate-600 dark:text-slate-400 flex items-center gap-2">
                        <i data-lucide="layers-3" class="h-4 w-4"></i>
                        Manage your fleet labels seamlessly on a single dashboard workspace.
                    </p>
                </div>
                <a href="{{ route('admin.brands.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-cyan-500 px-4 py-2 text-sm font-medium text-white">
                    <i data-lucide="plus" class="h-4 w-4"></i>
                    New Brand
                </a>
            </div>
        </div>

        <div id="alertContainer" class="mb-5 space-y-3">
            <div id="successBox" class="hidden rounded-xl border border-green-200 bg-green-50 p-4 dark:border-green-900 dark:bg-green-950">
                <div class="flex items-start gap-3">
                    <i data-lucide="check-circle" class="h-5 w-5 flex-shrink-0 text-green-600 dark:text-green-400"></i>
                    <div class="flex-1">
                        <h3 class="font-semibold text-green-800 dark:text-green-200">Success!</h3>
                        <p id="successText" class="mt-1 text-sm text-green-700 dark:text-green-300"></p>
                    </div>
                    <button type="button" class="close-alert text-green-500 hover:text-green-700 dark:hover:text-green-300">
                        <i data-lucide="x" class="h-4 w-4"></i>
                    </button>
                </div>
            </div>

            <div id="errorBox" class="hidden rounded-xl border border-red-200 bg-red-50 p-4 dark:border-red-900 dark:bg-red-950">
                <div class="flex items-start gap-3">
                    <i data-lucide="x-circle" class="h-5 w-5 flex-shrink-0 text-red-600 dark:text-red-400"></i>
                    <div class="flex-1">
                        <h3 class="font-semibold text-red-800 dark:text-red-200">Action Blocked</h3>
                        <p id="errorText" class="mt-1 text-sm text-red-700 dark:text-green-300"></p>
                    </div>
                    <button type="button" class="close-alert text-red-500 hover:text-red-700 dark:hover:text-red-300">
                        <i data-lucide="x" class="h-4 w-4"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="mb-6 flex items-center justify-between gap-4">
            <div class="relative w-full max-w-md">
                <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400"></i>
                <input id="searchInput" type="text" placeholder="Search brands..." class="w-full pl-9 pr-4 py-2.5 rounded-xl border border-slate-300">
            </div>
            <div class="flex gap-2">
                <button id="reloadBtn" class="rounded-xl border border-slate-300 px-4 py-2.5 text-sm">Reload</button>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200/60 dark:border-slate-700/60 bg-white/90 dark:bg-slate-800/90 shadow-xl p-4">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-slate-200/60 dark:border-slate-700/60 bg-slate-50/50 dark:bg-slate-900/30">
                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500">Brand</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500">Country</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-slate-500">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="brandsTableBody" class="divide-y divide-slate-100 dark:divide-slate-700/50 text-sm text-slate-700 dark:text-slate-300">
                        <tr><td colspan="3" class="py-6 text-center text-slate-400">Loading brands...</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const $body = $('#brandsTableBody');
                const $search = $('#searchInput');
                const $reload = $('#reloadBtn');

                function renderRows(items) {
                    if (!items || items.length === 0) {
                        $body.html('<tr><td colspan="3" class="py-6 text-center text-slate-400">No brands found.</td></tr>');
                        return;
                    }
                    let rows = '';
                    items.forEach(item => {
                        rows += `
                            <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-700/20 transition-colors">
                                <td class="py-3 px-4 font-medium text-slate-900 dark:text-white">${item.name}</td>
                                <td class="py-3 px-4">${item.country || '—'}</td>
                                <td class="py-3 px-4 text-right">
                                    <a href="/admin/brands/${item.id}/edit" class="inline-flex items-center px-3 py-1 rounded-lg border">Edit</a>
                                    <button onclick="window.deleteBrand(${item.id})" class="inline-flex items-center px-3 py-1 rounded-lg border ml-2">Delete</button>
                                </td>
                            </tr>`;
                    });
                    $body.html(rows);
                    if (typeof window.initLucideIcons === 'function') window.initLucideIcons();
                }

                function loadBrands() {
                    const params = {};
                    if ($search.val().trim()) params.q = $search.val().trim();

                    if (window.api && window.api.get) {
                        window.api.get('/api/brands', { params })
                            .then(resp => renderRows(resp.data.data || resp.data))
                            .catch(err => {
                                window.toast?.error(err.response?.data?.message || 'Failed to load brands');
                            });
                    } else {
                        $.get('/api/brands', params).done(function(resp){ renderRows(resp.data || resp); }).fail(function(xhr){ window.toast?.error(xhr.responseJSON?.message || 'Failed to load brands'); });
                    }
                }

                window.deleteBrand = function(id) {
                    if (!confirm('Delete this brand? This cannot be undone.')) return;
                    if (window.api && window.api.delete) {
                        window.api.delete(`/api/brands/${id}`)
                            .then(resp => { window.toast?.success(resp.data?.message || 'Brand deleted'); loadBrands(); })
                            .catch(err => window.toast?.error(err.response?.data?.message || 'Failed to delete brand'));
                    } else {
                        $.ajax({ url: `/api/brands/${id}`, method: 'DELETE' }).done(function(){ loadBrands(); }).fail(function(xhr){ window.toast?.error(xhr.responseJSON?.message || 'Failed to delete brand'); });
                    }
                }

                // simple debounce
                function debounce(fn, wait) { let t; return function() { clearTimeout(t); const args = arguments; t = setTimeout(() => fn.apply(this, args), wait); }; }

                $search.on('keyup', debounce(loadBrands, 300));
                $reload.on('click', loadBrands);

                // close-alert handlers
                $(document).on('click', '.close-alert', function(){ $(this).closest('[id$="Box"]').hide(); });

                loadBrands();
            });
        </script>
    @endpush
</x-admin.layout>
