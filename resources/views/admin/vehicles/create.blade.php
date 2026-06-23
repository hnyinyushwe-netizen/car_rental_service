<x-admin.layout>
    <div class="p-4 sm:p-6 md:p-8">
        <!-- Header Section -->
        <div class="mb-5 rounded-xl bg-gradient-to-br from-cyan-500/10 via-blue-500/5 to-purple-500/10 px-4 py-3 sm:px-5 sm:py-4 backdrop-blur-sm border border-cyan-500/20 dark:border-cyan-500/10">
            <div class="flex items-center justify-between flex-wrap gap-3">
                <div>
                    <h1 class="text-xl sm:text-2xl font-bold bg-gradient-to-r from-cyan-600 to-blue-600 dark:from-cyan-400 dark:to-blue-400 bg-clip-text text-transparent">
                        Add New Vehicle
                    </h1>
                    <p class="mt-0.5 text-sm text-slate-600 dark:text-slate-400 flex items-center gap-2">
                        <i data-lucide="plus-circle" class="h-4 w-4"></i>
                        Create a new vehicle for your fleet
                    </p>
                </div>
                <a href="{{ route('admin.vehicles.index') }}"
                    class="flex items-center gap-2 rounded-lg border border-slate-300 dark:border-slate-600 px-3 py-2 text-sm font-medium text-slate-700 dark:text-slate-300 transition hover:bg-slate-50">
                    <i data-lucide="arrow-left" class="h-4 w-4"></i>
                    Back
                </a>
            </div>
        </div>

        <form id="vehicleForm" class="space-y-5" enctype="multipart/form-data">
            @csrf
            <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-slate-800">
                <h2 class="mb-4 text-base font-bold text-slate-900 dark:text-white">Basic Information</h2>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Brand</label>
                        <select name="brand_id" id="vehicleBrand"
                            class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm focus:border-cyan-500">
                            <option value="">Loading Brands...</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Model</label>
                        <input type="text" name="model" id="vehicleModel" placeholder="e.g., 7 Series"
                            class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm">
                    </div>
                    <!-- other fields omitted for brevity -->
                </div>
            </section>

            <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-slate-800">
                <h2 class="mb-4 text-base font-bold text-slate-900 dark:text-white">Pricing & Media</h2>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Price Per Day ($)</label>
                        <input type="number" step="0.01" name="price_per_day" id="vehiclePrice" placeholder="150.00"
                            class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Vehicle Image</label>
                        <input type="file" name="image" id="imageInput" accept="image/*">
                    </div>
                </div>
            </section>

            <div class="flex justify-end">
                <button type="submit" id="submitVehicleBtn" class="px-6 py-2 rounded-md bg-cyan-500 text-white">Save Vehicle</button>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const $form = $('#vehicleForm');
                const $brand = $('#vehicleBrand');
                const $submit = $('#submitVehicleBtn');

                function loadBrands() {
                    if (window.api && window.api.get) {
                        window.api.get('/api/brands')
                            .then(resp => {
                                const data = resp.data.data || resp.data;
                                let opts = '<option value="">Select Brand</option>';
                                data.forEach(b => opts += `<option value="${b.id}">${b.name}</option>`);
                                $brand.html(opts);
                                if (typeof window.initLucideIcons === 'function') window.initLucideIcons();
                            })
                            .catch(err => window.toast?.error(err.response?.data?.message || 'Failed to load brands'));
                    } else {
                        $.get('/api/brands').done(function(resp){ const data = resp.data || resp; let opts = '<option value="">Select Brand</option>'; data.forEach(b=>opts+=`<option value="${b.id}">${b.name}</option>`); $brand.html(opts); });
                    }
                }

                $form.on('submit', function(e) {
                    e.preventDefault();

                    const formData = new FormData(this);
                    $submit.prop('disabled', true);

                    if (window.api && window.api.instance) {
                        window.api.instance.post('/api/vehicles', formData, { headers: { 'Content-Type': 'multipart/form-data' } })
                            .then(resp => {
                                window.toast?.success(resp.data?.message || 'Vehicle created');
                                window.location.href = '/admin/vehicles';
                            })
                            .catch(err => {
                                window.toast?.error(err.response?.data?.message || 'Failed to create vehicle');
                            })
                            .finally(() => $submit.prop('disabled', false));
                    } else {
                        $.ajax({ url: '/api/vehicles', method: 'POST', data: formData, processData: false, contentType: false })
                            .done(resp => { window.toast?.success(resp.message || 'Vehicle created'); window.location.href = '/admin/vehicles'; })
                            .fail(xhr => window.toast?.error(xhr.responseJSON?.message || 'Failed to create vehicle'))
                            .always(() => $submit.prop('disabled', false));
                    }
                });

                loadBrands();
            });
        </script>
    @endpush
</x-admin.layout>
