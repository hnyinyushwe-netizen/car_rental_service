<x-admin.layout>
    <div class="p-4 sm:p-6 md:p-8">
        <!-- Header Section -->
        <div class="mb-5 rounded-xl bg-gradient-to-br from-cyan-500/10 via-blue-500/5 to-purple-500/10 px-4 py-3 sm:px-5 sm:py-4 backdrop-blur-sm border border-cyan-500/20 dark:border-cyan-500/10">
            <div class="flex items-center justify-between flex-wrap gap-3">
                <div>
                    <h1 class="text-xl sm:text-2xl font-bold bg-gradient-to-r from-cyan-600 to-blue-600 dark:from-cyan-400 dark:to-blue-400 bg-clip-text text-transparent">
                        Vehicle Categories
                    </h1>
                    <p class="mt-0.5 text-sm text-slate-600 dark:text-slate-400 flex items-center gap-2">
                        <i data-lucide="layers-3" class="h-4 w-4"></i>
                        Manage your fleet labels seamlessly on a single dashboard workspace.
                    </p>
                </div>
            </div>
        </div>

        <div id="alertContainer" class="mb-5 space-y-3">
            <div id="successBox"
                class="hidden rounded-xl border border-green-200 bg-green-50 p-4 dark:border-green-900 dark:bg-green-950">
                <div class="flex items-start gap-3">
                    <i data-lucide="check-circle" class="h-5 w-5 flex-shrink-0 text-green-600 dark:text-green-400"></i>
                    <div class="flex-1">
                        <h3 class="font-semibold text-green-800 dark:text-green-200">Success!</h3>
                        <p id="successText" class="mt-1 text-sm text-green-700 dark:text-green-300"></p>
                    </div>
                    <button type="button"
                        class="close-alert text-green-500 hover:text-green-700 dark:hover:text-green-300">
                        <i data-lucide="x" class="h-4 w-4"></i>
                    </button>
                </div>
            </div>

            <div id="errorBox"
                class="hidden rounded-xl border border-red-200 bg-red-50 p-4 dark:border-red-900 dark:bg-red-950">
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

        <div class="grid gap-6 lg:grid-cols-[1fr_22rem]">
            <section
                class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-700 dark:bg-slate-800">
                <div class="mb-5 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <h2 class="text-lg font-bold text-slate-900 dark:text-white">Active Categories</h2>

                    <div class="relative w-full sm:w-64">
                        <span
                            class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400 dark:text-slate-500">
                            <i data-lucide="search" class="h-4 w-4"></i>
                        </span>
                        <input type="text" id="tableSearchInput" placeholder="Search categories..."
                            class="h-9 w-full rounded-xl border border-slate-300 bg-white pl-9 pr-4 text-xs font-medium text-slate-800 shadow-sm transition focus:border-cyan-500 focus:outline-none" />
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr
                                class="border-b border-slate-200 dark:border-slate-700 text-xs font-semibold uppercase text-slate-400 tracking-wider">
                                <th class="py-3 px-4 w-16">No</th>
                                <th class="py-3 px-4">Name</th>
                                <th class="py-3 px-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="categoriesTableBody"
                            class="divide-y divide-slate-100 dark:divide-slate-700/50 text-sm text-slate-700 dark:text-slate-300">
                            <tr>
                                <td colspan="3" class="py-6 text-center text-slate-400">Loading fleet records...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <aside class="space-y-6">
                <section
                    class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-700 dark:bg-slate-800">
                    <div class="mb-4 flex items-center gap-3">
                        <div
                            class="flex h-10 w-10 items-center justify-center rounded-xl bg-cyan-500/10 text-cyan-600 dark:text-cyan-300">
                            <i id="formIcon" data-lucide="folder-plus" class="h-5 w-5"></i>
                        </div>
                        <div>
                            <h3 id="formTitle" class="text-base font-bold text-slate-900 dark:text-white">New Category
                            </h3>
                            <p id="formSubtitle" class="text-xs text-slate-500">Add a unique classification label.</p>
                        </div>
                    </div>

                    <form id="categoryForm" class="space-y-4">
                        <input type="hidden" id="category_id" value="">
                        <div>
                            <label for="category_name"
                                class="mb-1.5 block text-xs font-semibold text-slate-600 dark:text-slate-400">Category
                                Name</label>
                            <input type="text" id="category_name" placeholder="Example: SUV, Sedan, Van" required
                                class="h-11 w-full rounded-xl border border-slate-300 bg-white px-4 text-sm font-medium text-slate-800 shadow-sm transition focus:border-cyan-500 focus:outline-none" />
                        </div>

                        <div class="flex gap-2 pt-2">
                            <button type="button" id="cancelBtn"
                                class="hidden w-1/3 h-10 text-xs font-bold rounded-xl border border-slate-200 text-slate-600 transition hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300">
                                Cancel
                            </button>
                            <button type="submit" id="saveBtn"
                                class="w-full h-10 text-xs font-bold text-white rounded-xl bg-gradient-to-r from-cyan-500 to-blue-600 shadow-md transition hover:-translate-y-0.5">
                                Save Record
                            </button>
                        </div>
                    </form>
                </section>
            </aside>
        </div>
    </div>

    <div id="deleteConfirmationModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"></div>
        <div
            class="relative w-full max-w-md transform overflow-hidden rounded-2xl bg-white p-6 shadow-xl transition-all dark:bg-slate-800 border border-slate-200 dark:border-slate-700 animate-in">
            <div class="flex flex-col items-center text-center">
                <div
                    class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400 mb-4">
                    <i data-lucide="alert-triangle" class="h-6 w-6"></i>
                </div>
                <h3 class="text-lg font-bold text-slate-900 dark:text-white">Confirm Removal</h3>
                <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Are you completely sure you want to remove
                    this vehicle category? This action cannot be undone.</p>
            </div>
            <div class="mt-6 flex justify-end gap-3">
                <button type="button" id="closeDeleteModalBtn"
                    class="px-4 h-10 text-xs font-bold rounded-xl border border-slate-200 text-slate-600 transition hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300">
                    Keep Record
                </button>
                <button type="button" id="confirmDeleteBtn"
                    class="px-5 h-10 text-xs font-bold text-white rounded-xl bg-red-600 hover:bg-red-700 shadow-md transition">
                    Delete Permanently
                </button>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Use the shared api and toast modules exposed by resources/js/app.js
            document.addEventListener('DOMContentLoaded', function() {
                const tableBody = document.getElementById('categoriesTableBody');
                const form = document.getElementById('categoryForm');
                const categoryIdInput = document.getElementById('category_id');
                const categoryNameInput = document.getElementById('category_name');
                const saveBtn = document.getElementById('saveBtn');
                const cancelBtn = document.getElementById('cancelBtn');
                const formTitle = document.getElementById('formTitle');
                const formSubtitle = document.getElementById('formSubtitle');
                const searchInput = document.getElementById('tableSearchInput');

                const successBox = document.getElementById('successBox');
                const successText = document.getElementById('successText');
                const errorBox = document.getElementById('errorBox');
                const errorText = document.getElementById('errorText');

                const deleteModal = document.getElementById('deleteConfirmationModal');
                const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
                const closeDeleteModalBtn = document.getElementById('closeDeleteModalBtn');
                let targetDeleteId = null;

                function showLegacyAlert(type, message) {
                    // keep legacy UI blocks in sync but prefer toast
                    if (type === 'success') {
                        successText.textContent = message;
                        successBox.classList.remove('hidden');
                        errorBox.classList.add('hidden');
                    } else {
                        errorText.textContent = message;
                        errorBox.classList.remove('hidden');
                        successBox.classList.add('hidden');
                    }
                    if (window.toast) {
                        if (type === 'success') window.toast.success(message);
                        else window.toast.error(message);
                    }
                    if (window.initLucideIcons) window.initLucideIcons();
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }

                function clearLegacyAlerts() {
                    successBox.classList.add('hidden');
                    errorBox.classList.add('hidden');
                }

                // Live search (client-side)
                searchInput?.addEventListener('input', function() {
                    const q = this.value.toLowerCase().trim();
                    tableBody.querySelectorAll('tr').forEach(row => {
                        if (row.querySelector('td[colspan]')) return; // skip placeholder
                        const text = row.textContent.toLowerCase();
                        row.style.display = text.includes(q) ? '' : 'none';
                    });
                });

                // Load categories
                async function loadCategories() {
                    try {
                        const res = await window.api.get('{{ url('/api/categories') }}');
                        const data = res.data || [];
                        if (data.length === 0) {
                            tableBody.innerHTML = `<tr><td colspan="3" class="py-6 text-center text-slate-400">No active categories found.</td></tr>`;
                        } else {
                            let rows = '';
                            data.forEach((category, index) => {
                                rows += `
                                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-700/20 transition-colors">
                                        <td class="py-3 px-4 font-semibold text-slate-400 dark:text-slate-500">${index+1}</td>
                                        <td class="py-3 px-4 font-medium text-slate-900 dark:text-white">${category.name}</td>
                                        <td class="py-3 px-4 text-right space-x-1">
                                            <button data-id="${category.id}" data-name="${category.name}" class="edit-btn inline-flex items-center justify-center h-8 w-8 rounded-lg border border-slate-200 bg-white text-slate-500 hover:bg-slate-50" title="Edit">
                                                <i class="h-4 w-4" data-lucide="pencil"></i>
                                            </button>
                                            <button data-id="${category.id}" class="delete-btn inline-flex items-center justify-center h-8 w-8 rounded-lg border border-slate-200 bg-white text-red-600 hover:bg-red-50" title="Delete">
                                                <i class="h-4 w-4" data-lucide="trash-2"></i>
                                            </button>
                                        </td>
                                    </tr>`;
                            });
                            tableBody.innerHTML = rows;
                        }
                        if (window.initLucideIcons) window.initLucideIcons();
                    } catch (err) {
                        console.error(err);
                        showLegacyAlert('error', err?.message || 'Failed to fetch categories.');
                    }
                }

                // Form submit (create/update)
                form?.addEventListener('submit', async function(e) {
                    e.preventDefault();
                    const id = categoryIdInput.value;
                    const name = categoryNameInput.value.trim();
                    if (!name) return showLegacyAlert('error', 'Name is required');
                    try {
                        if (id) {
                            const res = await window.api.put(`{{ url('/api/categories') }}/${id}`, { name });
                            showLegacyAlert('success', res.message || 'Category updated successfully.');
                        } else {
                            const res = await window.api.post('{{ url('/api/categories') }}', { name });
                            showLegacyAlert('success', res.message || 'Category created successfully.');
                        }
                        resetForm();
                        loadCategories();
                    } catch (err) {
                        console.error(err);
                        showLegacyAlert('error', err?.response?.message || err?.message || 'Validation or processing error.');
                    }
                });

                // Delegated click handlers for edit/delete
                tableBody?.addEventListener('click', function(e) {
                    const btn = e.target.closest('button');
                    if (!btn) return;
                    const id = btn.getAttribute('data-id');
                    if (btn.classList.contains('edit-btn')) {
                        const name = btn.getAttribute('data-name');
                        categoryIdInput.value = id;
                        categoryNameInput.value = name;
                        formTitle.textContent = 'Edit Category';
                        formSubtitle.textContent = `Modifying entry identity #${id}`;
                        saveBtn.textContent = 'Update Changes';
                        cancelBtn.classList.remove('hidden');
                        saveBtn.classList.remove('w-full');
                        saveBtn.classList.add('w-2/3');
                    } else if (btn.classList.contains('delete-btn')) {
                        targetDeleteId = id;
                        deleteModal.classList.remove('hidden');
                        deleteModal.classList.add('flex');
                    }
                });

                closeDeleteModalBtn?.addEventListener('click', function() {
                    deleteModal.classList.add('hidden');
                    deleteModal.classList.remove('flex');
                    targetDeleteId = null;
                });

                confirmDeleteBtn?.addEventListener('click', async function() {
                    if (!targetDeleteId) return;
                    try {
                        const res = await window.api.delete(`{{ url('/api/categories') }}/${targetDeleteId}`);
                        deleteModal.classList.add('hidden');
                        deleteModal.classList.remove('flex');
                        targetDeleteId = null;
                        showLegacyAlert('success', res.message || 'Category deleted successfully.');
                        loadCategories();
                    } catch (err) {
                        console.error(err);
                        deleteModal.classList.add('hidden');
                        deleteModal.classList.remove('flex');
                        showLegacyAlert('error', err?.response?.message || err?.message || 'Could not execute target delete.');
                    }
                });

                function resetForm() {
                    form.reset();
                    categoryIdInput.value = '';
                    formTitle.textContent = 'New Category';
                    formSubtitle.textContent = 'Add a unique classification label.';
                    saveBtn.textContent = 'Save Record';
                    cancelBtn.classList.add('hidden');
                    saveBtn.classList.remove('w-2/3');
                    saveBtn.classList.add('w-full');
                    clearLegacyAlerts();
                }

                cancelBtn?.addEventListener('click', resetForm);

                // Initial load
                loadCategories();
                if (window.initLucideIcons) window.initLucideIcons();
            });
        </script>
    @endpush
</x-admin.layout>
