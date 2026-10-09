@extends('layouts.admin')

@section('title', 'Parent Directory')

@section('content')

<div class="flex flex-col gap-space-lg w-full">
    <div class="flex flex-col gap-1">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-space-md mt-2">
            <div>
                <h1 class="font-headline-lg text-headline-lg text-on-surface tracking-tight">Parents</h1>
                <p class="font-body-md text-body-md text-on-surface-variant mt-0.5">
                    Manage parents belonging to your institute.
                </p>
            </div>
        <button type="button" id="openModalBtn"
            class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-primary-container text-on-primary hover:bg-primary transition-all rounded-lg shadow-sm font-label-lg text-label-lg active:scale-[0.98]">
            <span class="material-symbols-outlined text-[20px]">add</span>
            Add Parent
        </button>
    </div>
</div>

<div class="space-y-space-md">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <div class="bg-surface-container-lowest p-space-md rounded-xl shadow-sm flex items-center justify-between">
            <div class="flex flex-col">
                <span class="font-label-sm text-label-sm text-outline uppercase tracking-wider">Total Parents</span>
                <span id="totalParents" class="font-display-lg text-display-lg text-on-surface mt-1 font-tabular-numeric">—</span>
                <span id="session" class="font-body-sm text-body-sm text-primary flex items-center gap-1 mt-0.5">
                    <span class="material-symbols-outlined text-[16px]">groups</span>
                        All institute parents
                </span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-surface-container flex items-center justify-center text-primary">
                <span class="material-symbols-outlined text-[26px]">groups</span>
            </div>
        </div>

        <div class="bg-surface-container-lowest p-space-md rounded-xl shadow-sm flex items-center justify-between">
            <div class="flex flex-col">
                <span class="font-label-sm text-label-sm text-outline uppercase tracking-wider">Active Parents</span>
                <span id="activeParents" class="font-display-lg text-display-lg text-secondary mt-1 font-tabular-numeric">—</span>
                <span id="activePercentage" class="font-body-sm text-body-sm text-on-surface-variant flex items-center gap-1 mt-0.5">Loading...</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-surface-container flex items-center justify-center text-secondary">
                <span class="material-symbols-outlined text-[26px]">how_to_reg</span>
            </div>
        </div>

        <div class="bg-surface-container-lowest p-space-md rounded-xl shadow-sm flex items-center justify-between">
            <div class="flex flex-col">
                <span class="font-label-sm text-label-sm text-outline uppercase tracking-wider">Inactive Parents</span>
                <span id="inactiveParents" class="font-display-lg text-display-lg text-tertiary mt-1 font-tabular-numeric">—</span>
                <span class="font-body-sm text-body-sm text-on-surface-variant flex items-center gap-1 mt-0.5">
                    <span class="material-symbols-outlined text-[16px]">person_off</span>
                    Inactive accounts
                </span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-tertiary-fixed flex items-center justify-center text-tertiary">
                <span class="material-symbols-outlined text-[26px]">person_off</span>
            </div>
        </div>

        
    </div>

    <div class="bg-surface-container-lowest p-space-md rounded-xl shadow-sm flex flex-col lg:flex-row items-stretch lg:items-center gap-space-md">
        <div class="flex flex-1 flex-col sm:flex-row items-stretch sm:items-center gap-3">
            <div class="relative flex-1 min-w-[280px]">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[20px]">search</span>
                <input type="text" id="searchInput"
                    class="w-full h-10 pl-10 pr-4 rounded-lg bg-surface text-on-surface font-body-sm text-body-sm placeholder:text-outline focus:outline-none focus:bg-surface-container-lowest focus:shadow-sm transition-all"
                    placeholder="Search parents by name or email">
            </div>

            <div class="relative">
                <select id="statusFilter"
                    class="h-10 pl-3 pr-8 rounded-lg bg-surface font-label-md text-label-md text-on-surface appearance-none cursor-pointer focus:outline-none">
                    <option value="all">All Status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
                <span class="material-symbols-outlined absolute right-2.5 top-1/2 -translate-y-1/2 text-outline text-[18px] pointer-events-none">expand_more</span>
            </div>
        </div>
    </div>

    <div class="bg-surface-container-lowest rounded-xl shadow-sm overflow-hidden flex flex-col">
        <div class="overflow-x-auto w-full">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-container-low text-on-surface-variant font-label-sm text-label-sm uppercase tracking-wider">
                        <th class="py-3 px-4 w-12 text-center">#</th>
                        <th class="py-3 px-10">Parent</th>
                        <th class="py-3 px-4">Email</th>
                        <th class="py-3 px-4">Contact Info</th>
                        <th class="py-3 px-4 text-center">Relationship</th>
                        <th class="py-3 px-4 text-center">Status</th>
                        <th class="py-3 px-4 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody id="parentTableBody"
                    class="divide-y divide-surface-container font-body-md text-body-md text-on-surface">
                    <tr>
                        <td colspan="7" class="py-10 text-center text-on-surface-variant">Loading parents...</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="p-space-md bg-surface-container-lowest flex flex-col sm:flex-row items-center justify-between gap-space-md border-t border-surface-container">
            <div id="parentPaginationInfo" class="font-body-sm text-body-sm text-on-surface-variant">Loading...</div>
            <div id="parentPagination" class="flex items-center gap-1 font-label-md text-label-md"></div>
        </div>
    </div>
</div>

</div>

<!-- Add/Edit Modal -->

<div id="parentModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
    <div class="w-full max-w-3xl max-h-[90vh] overflow-hidden rounded-2xl bg-surface-container-lowest shadow-xl flex flex-col">
        <div class="flex items-center justify-between border-b border-outline-variant p-5">
            <div>
                <h2 id="modalTitle" class="font-headline-md text-headline-md text-on-surface">Add New Parent</h2>
                <p id="modalSubtitle" class="mt-1 text-sm text-on-surface-variant">Register a parent for this institute.</p>
            </div>
            <button type="button" id="closeModalBtn" class="rounded-lg p-2 text-on-surface-variant hover:bg-surface-container">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

    <form id="parentForm" class="flex flex-col min-h-0">
        <input type="hidden" id="formParentId">

        <div class="grid grid-cols-1 gap-4 p-5 sm:grid-cols-2 overflow-y-auto">
            <div class="sm:col-span-2">
                <label for="formName" class="mb-1 block text-sm font-medium text-on-surface">Parent Full Name <span class="text-error">*</span></label>
                <input type="text" id="formName" class="w-full rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface" required>
            </div>

            <div>
                <label for="formEmail" class="mb-1 block text-sm font-medium text-on-surface">Email <span class="text-error">*</span></label>
                <input type="email" id="formEmail" class="w-full rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface" required>
            </div>

            <div>
                <label for="formPhone" class="mb-1 block text-sm font-medium text-on-surface">Phone <span class="text-error">*</span></label>
                <input type="text" id="formPhone" class="w-full rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface" required>
            </div>

            <div class="sm:col-span-2">
                <label for="formRelationship" class="mb-1 block text-sm font-medium text-on-surface">Relationship <span class="text-error">*</span></label>
                <input type="text" id="formRelationship" class="w-full rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface" placeholder="Mother, Father, Guardian" required>
            </div>

            <div>
                <label for="formPassword" class="mb-1 block text-sm font-medium text-on-surface">Password <span id="passwordRequired" class="text-error">*</span></label>
                <input type="password" id="formPassword" class="w-full rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface">
            </div>

            <div>
                <label for="formConfirmPassword" class="mb-1 block text-sm font-medium text-on-surface">Confirm Password <span id="confirmPasswordRequired" class="text-error">*</span></label>
                <input type="password" id="formConfirmPassword" class="w-full rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface">
            </div>

            <div class="sm:col-span-2 flex items-center justify-between rounded-lg bg-surface-container-low p-3">
                <div>
                    <span class="text-sm font-semibold text-on-surface">Account Status</span>
                    <span class="mt-0.5 block text-sm text-on-surface-variant">Allow parent access to the system.</span>
                </div>
                <label class="relative inline-flex cursor-pointer items-center">
                    <input type="checkbox" id="formStatusToggle" class="sr-only peer" checked>
                    <div class="h-6 w-11 rounded-full bg-outline after:absolute after:left-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:bg-white after:transition-all after:content-[''] peer-checked:bg-primary peer-checked:after:translate-x-full"></div>
                </label>
            </div>
        </div>

        <div id="formError" class="hidden mx-5 mb-4 rounded-lg bg-red-50 p-3 text-sm text-red-700"></div>

        <div class="flex justify-end gap-3 border-t border-outline-variant p-5">
            <button type="button" id="cancelModalBtn" class="rounded-lg border border-outline-variant px-4 py-2 text-sm font-medium text-on-surface">Cancel</button>
            <button type="submit" id="saveParentBtn" class="rounded-lg bg-primary px-5 py-2 text-sm font-semibold text-white">
                <span id="saveParentText">Save Parent</span>
            </button>
        </div>
    </form>
</div>

</div>

<!-- Delete Modal -->

<div id="deleteParentModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
    <div class="w-full max-w-md rounded-2xl bg-surface-container-lowest shadow-xl">
        <div class="border-b border-outline-variant p-5">
            <h2 class="font-headline-md text-headline-md text-on-surface">Delete Parent</h2>
        </div>

    <div class="p-5">
        <div id="deleteParentMessage" class="rounded-lg p-4 text-sm"></div>
    </div>

    <div class="flex justify-end gap-3 border-t border-outline-variant p-5">
        <button type="button" id="cancelDeleteParentButton"
            class="rounded-lg border border-outline-variant px-4 py-2 text-sm font-medium text-on-surface">
            Cancel
        </button>
        <button type="button" id="confirmDeleteParentButton"
            class="hidden rounded-lg bg-red-600 px-5 py-2 text-sm font-semibold text-white">
            Delete Parent
        </button>
        <button type="button" id="confirmDeactivateParentButton"
            class="hidden rounded-lg bg-primary px-5 py-2 text-sm font-semibold text-white">
            Deactivate Parent
        </button>
    </div>
</div>

</div>

<!-- View Modal -->

<div id="viewParentModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
    <div class="w-full max-w-lg rounded-2xl bg-surface-container-lowest shadow-xl">
        <div class="flex items-center justify-between border-b border-outline-variant p-5">
            <div>
                <h2 class="font-headline-md text-headline-md text-on-surface">Parent Details</h2>
                <p class="mt-1 text-sm text-on-surface-variant">View parent information</p>
            </div>
            <button type="button" id="closeViewParentModal" class="rounded-lg p-2 text-on-surface-variant hover:bg-surface-container">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

    <div class="p-5">
        <div class="flex items-center gap-4 pb-5">
            <div id="viewParentAvatar"></div>
            <div class="flex-1 min-w-0">
                <div class="flex items-center justify-between gap-4 flex-wrap">
                    <h3 id="viewParentName" class="text-lg font-semibold text-on-surface">—</h3>
                    <div id="viewParentStatus">—</div>
                </div>
                <p id="viewParentRelationship" class="mt-1 text-sm text-on-surface-variant">—</p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="rounded-lg bg-surface-container-low p-4">
                <p class="text-xs text-on-surface-variant">Email</p>
                <p id="viewParentEmail" class="mt-1 font-medium text-on-surface">—</p>
            </div>

            <div class="rounded-lg bg-surface-container-low p-4">
                <p class="text-xs text-on-surface-variant">Phone No</p>
                <p id="viewParentPhone" class="mt-1 font-medium text-on-surface">—</p>
            </div>

            <div class="rounded-lg bg-surface-container-low p-4 sm:col-span-2">
                <p class="text-xs text-on-surface-variant">Children</p>
                <div id="viewParentChildren" class="space-y-3 mt-2"></div>
            </div>
        </div>
    </div>

    <div class="flex justify-end border-t border-outline-variant p-5">
        <button type="button" id="closeViewParentButton"
            class="rounded-lg border border-outline-variant px-4 py-2 text-sm font-medium text-on-surface">
            Close
        </button>
    </div>
</div>

</div>

<div id="toastNotification"
    class="fixed bottom-6 right-6 z-50 bg-inverse-surface text-inverse-on-surface px-4 py-3 rounded-lg shadow-lg flex items-center gap-3 translate-y-16 opacity-0 pointer-events-none transition-all duration-300">
    <span id="toastIcon" class="material-symbols-outlined text-secondary-fixed text-[20px]">check_circle</span>
    <span id="toastMessage" class="font-body-sm text-body-sm"></span>
</div>

<script>
(() => {
    const API_URL = '/api/v1/admin/parents';
    const token = localStorage.getItem('student_diary_token');

    if (!token) {
        window.location.replace('/');
        return;
    }

    const headers = {
        Accept: 'application/json',
        Authorization: `Bearer ${token}`
    };

    const $ = id => document.getElementById(id);

    const tableBody = $('parentTableBody');
    const searchInput = $('searchInput');
    const statusFilter = $('statusFilter');
    const pagination = $('parentPagination');
    const paginationInfo = $('parentPaginationInfo');

    const modal = $('parentModal');
    const form = $('parentForm');
    const formId = $('formParentId');
    const formName = $('formName');
    const formEmail = $('formEmail');
    const formPhone = $('formPhone');
    const formRelationship = $('formRelationship');
    const formPassword = $('formPassword');
    const formConfirmPassword = $('formConfirmPassword');
    const formStatus = $('formStatusToggle');
    const formError = $('formError');

    const viewModal = $('viewParentModal');
    const viewAvatar = $('viewParentAvatar');
    const viewName = $('viewParentName');
    const viewRelationship = $('viewParentRelationship');
    const viewEmail = $('viewParentEmail');
    const viewPhone = $('viewParentPhone');
    const viewStatus = $('viewParentStatus');
    const viewChildren = $('viewParentChildren');

    const deleteModal = $('deleteParentModal');
    const deleteMessage = $('deleteParentMessage');
    const deleteButton = $('confirmDeleteParentButton');
    const deactivateButton = $('confirmDeactivateParentButton');

    let allParents = [];
    let currentPage = 1;
    let lastPage = 1;
    let selectedParentId = null;
    let searchTimer;

    function logout() {
        localStorage.removeItem('student_diary_token');
        localStorage.removeItem('student_diary_user');
        localStorage.removeItem('student_diary_institute_code');
        window.location.replace('/');
    }

    async function loadParents(page = 1) {
        try {
            tableBody.innerHTML = `<tr><td colspan="7" class="py-10 text-center text-on-surface-variant">Loading parents...</td></tr>`;

            const params = new URLSearchParams({ page });
            const search = searchInput.value.trim();
            const status = statusFilter.value;

            if (search) params.set('search', search);
            if (status !== 'all') params.set('status', status);

            const response = await fetch(`${API_URL}?${params}`, { headers });

            if (response.status === 401) return logout();

            const result = await response.json();

            if (!response.ok || !result.status) {
                throw new Error(result.message || 'Failed to load parents.');
            }

            allParents = Array.isArray(result.data) ? result.data : [];

            const meta = result.meta || {};
            currentPage = Number(meta.current_page || page);
            lastPage = Number(meta.last_page || 1);

            updateStatistics(result);
            renderParents();
            renderPagination(meta);
        } catch (error) {
            tableBody.innerHTML = `<tr><td colspan="7" class="py-10 text-center text-error">${escapeHtml(error.message)}</td></tr>`;
        }
    }

    function updateStatistics(result) {
        const stats = result.statistics || {};
        const total = Number(stats.total || 0);
        const active = Number(stats.active || 0);
        const inactive = Number(stats.inactive || 0);
        const percentage = total ? ((active / total) * 100).toFixed(1) : '0.0';
        totalParents.textContent = total;
        activeParents.textContent = active;
        inactiveParents.textContent = inactive;

        activePercentage.innerHTML = `
            <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span>
            ${percentage}% active
        `;
    }

    function renderParents() {
        if (!allParents.length) {
            tableBody.innerHTML = `<tr><td colspan="7" class="py-10 text-center text-on-surface-variant">No parents found.</td></tr>`;
            return;
        }

        tableBody.innerHTML = allParents.map((parent, index) => {
            const active = Number(parent.status) === 1;

            return `
                <tr>
                    <td class="py-3 px-4 text-center">${((currentPage - 1) * 5) + index + 1}</td>
                    <td class="py-3 px-10">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-primary text-on-primary flex items-center justify-center font-semibold">
                                ${escapeHtml(getInitials(parent.name))}
                            </div>
                            <div class="font-medium text-on-surface">${escapeHtml(parent.name || '—')}</div>
                        </div>
                    </td>
                    <td class="py-3 px-4">${escapeHtml(parent.email || '—')}</td>
                    <td class="py-3 px-4">${escapeHtml(parent.phone || '—')}</td>
                    <td class="py-3 px-4 text-center">${escapeHtml(parent.relationship || '—')}</td>
                    <td class="py-3 px-4 text-center">
                        <span class="inline-flex items-center gap-1.5 text-xs font-semibold ${active ? 'text-secondary' : 'text-outline'}">
                            <span class="w-1.5 h-1.5 rounded-full ${active ? 'bg-secondary' : 'bg-outline'}"></span>
                            ${active ? 'Active' : 'Inactive'}
                        </span>
                    </td>
                    <td class="py-3 px-4">
                        <div class="flex items-center justify-end gap-1">
                            <button type="button" onclick="viewParent(${parent.id})" class="p-2 rounded-lg text-on-surface-variant hover:bg-surface-container" title="View">
                                <span class="material-symbols-outlined text-[20px]">visibility</span>
                            </button>
                            <button type="button" onclick="editParent(${parent.id})" class="p-2 rounded-lg text-on-surface-variant hover:bg-surface-container" title="Edit">
                                <span class="material-symbols-outlined text-[20px]">edit</span>
                            </button>
                            <button type="button" onclick="toggleParentStatus(${parent.id})" class="p-2 rounded-lg text-on-surface-variant hover:bg-surface-container" title="${active ? 'Deactivate' : 'Activate'}">
                                <span class="material-symbols-outlined text-[20px]">${active ? 'person_off' : 'how_to_reg'}</span>
                            </button>
                            <button type="button" onclick="deleteParent(${parent.id})" class="p-2 rounded-lg text-error hover:bg-red-50" title="Delete">
                                <span class="material-symbols-outlined text-[20px]">delete</span>
                            </button>
                        </div>
                    </td>
                </tr>`;
        }).join('');
    }

    function renderPagination(meta) {
        pagination.innerHTML = '';

        const total = Number(meta.total || 0);
        const from = Number(meta.from || 0);
        const to = Number(meta.to || 0);

        paginationInfo.textContent = total
            ? `Showing ${from}–${to} of ${total} parents`
            : 'Showing 0 parents';

        if (lastPage <= 1) return;

        const button = (text, disabled, action, active = false) => {
            const el = document.createElement('button');
            el.type = 'button';
            el.innerHTML = text;
            el.disabled = disabled;
            el.className = `min-w-8 px-2 py-1.5 rounded-lg text-sm ${
                active ? 'bg-primary text-on-primary' : 'text-on-surface hover:bg-surface-container'
            } disabled:opacity-40`;
            el.onclick = action;
            pagination.appendChild(el);
        };

        button('<span class="material-symbols-outlined text-[18px]">chevron_left</span>',
            currentPage === 1, () => loadParents(currentPage - 1));

        for (let page = 1; page <= lastPage; page++) {
            button(page, false, () => loadParents(page), page === currentPage);
        }

        button('<span class="material-symbols-outlined text-[18px]">chevron_right</span>',
            currentPage === lastPage, () => loadParents(currentPage + 1));
    }

    searchInput.addEventListener('input', () => {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(() => loadParents(1), 300);
    });

    statusFilter.addEventListener('change', () => loadParents(1));

    $('openModalBtn').addEventListener('click', () => {
        form.reset();
        formId.value = '';
        formStatus.checked = true;
        $('modalTitle').textContent = 'Add New Parent';
        $('modalSubtitle').textContent = 'Register a parent for this institute.';
        formPassword.required = true;
        formConfirmPassword.required = true;
        formError.classList.add('hidden');
        modal.classList.remove('hidden');
    });

    function closeModal() {
        modal.classList.add('hidden');
    }

    $('closeModalBtn').addEventListener('click', closeModal);
    $('cancelModalBtn').addEventListener('click', closeModal);

    window.editParent = async id => {
        try {
            const response = await fetch(`${API_URL}/${id}`, { headers });
            if (response.status === 401) return logout();

            const result = await response.json();
            if (!response.ok || !result.status) throw new Error(result.message || 'Unable to load parent.');

            const parent = result.data;

            formId.value = parent.id;
            formName.value = parent.name || '';
            formEmail.value = parent.email || '';
            formPhone.value = parent.phone || '';
            formRelationship.value = parent.relationship || '';
            formPassword.value = '';
            formConfirmPassword.value = '';
            formStatus.checked = Number(parent.status) === 1;

            $('modalTitle').textContent = 'Edit Parent';
            $('modalSubtitle').textContent = 'Update parent information.';
            formPassword.required = false;
            formConfirmPassword.required = false;
            formError.classList.add('hidden');
            modal.classList.remove('hidden');
        } catch (error) {
            showToast(error.message, 'error');
        }
    };

    window.viewParent = async id => {
        viewModal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');

        viewName.textContent = 'Loading...';
        viewRelationship.textContent = 'Loading...';
        viewEmail.textContent = '—';
        viewPhone.textContent = '—';
        viewStatus.innerHTML = 'Loading...';
        viewChildren.innerHTML = '<p class="text-sm text-on-surface-variant">Loading children...</p>';

        try {
            const parentResponse = await fetch(`${API_URL}/${id}`, { headers });
            if (parentResponse.status === 401) return logout();

            const parentResult = await parentResponse.json();
            if (!parentResponse.ok || !parentResult.status) {
                throw new Error(parentResult.message || 'Unable to load parent.');
            }

            const parent = parentResult.data;
            const active = Number(parent.status) === 1;

            viewName.textContent = parent.name || '—';
            viewRelationship.textContent = parent.relationship || '—';
            viewEmail.textContent = parent.email || '—';
            viewPhone.textContent = parent.phone || '—';

            viewAvatar.innerHTML = `
                <div class="w-16 h-16 rounded-full bg-primary text-on-primary flex items-center justify-center font-semibold text-xl">
                    ${escapeHtml(getInitials(parent.name))}
                </div>`;

            viewStatus.innerHTML = `
                <span class="inline-flex items-center gap-1.5 text-xs font-semibold ${active ? 'text-secondary' : 'text-outline'}">
                    <span class="w-1.5 h-1.5 rounded-full ${active ? 'bg-secondary' : 'bg-outline'}"></span>
                    ${active ? 'Active' : 'Inactive'}
                </span>`;

            const studentsResponse = await fetch(`${API_URL}/${id}/students`, { headers });
            if (studentsResponse.status === 401) return logout();

            const studentsResult = await studentsResponse.json();
            if (!studentsResponse.ok || !studentsResult.status) {
                throw new Error(studentsResult.message || 'Unable to load children.');
            }

            const students = Array.isArray(studentsResult.data?.data)
                ? studentsResult.data.data
                : Array.isArray(studentsResult.data) ? studentsResult.data : [];

            if (!students.length) {
                viewChildren.innerHTML = '<p class="text-sm text-on-surface-variant">No children found.</p>';
                return;
            }

            viewChildren.innerHTML = students.map(student => {
                const name = student.name || student.full_name || 'Unknown Student';
                const code = student.student_code || student.code || '—';
                const className = student.class?.name || '—';
                const section = student.section?.name || '—';
                const active = Number(student.status) === 1;

                return `
                    <div class="flex items-center justify-between gap-3 rounded-lg bg-surface-container-low p-3">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-10 h-10 shrink-0 rounded-full bg-primary text-on-primary flex items-center justify-center font-semibold">
                                ${escapeHtml(getInitials(name))}
                            </div>
                            <div class="min-w-0">
                                <p class="font-medium text-on-surface truncate">${escapeHtml(name)}</p>
                                <p class="text-xs text-on-surface-variant mt-0.5">Student Code: ${escapeHtml(code)}</p>
                                <p class="text-xs text-on-surface-variant mt-0.5">
                                    Class: <span class="font-medium text-on-surface">${escapeHtml(className)}</span>
                                    <span class="mx-1">•</span>
                                    Section: <span class="font-medium text-on-surface">${escapeHtml(section)}</span>
                                </p>
                            </div>
                        </div>
                        <span class="shrink-0 text-xs font-semibold ${active ? 'text-secondary' : 'text-outline'}">
                            ${active ? 'Active' : 'Inactive'}
                        </span>
                    </div>`;
            }).join('');
        } catch (error) {
            viewChildren.innerHTML = `<div class="rounded-lg bg-red-50 p-4 text-sm text-red-700">${escapeHtml(error.message)}</div>`;
        }
    };

    function closeViewModal() {
        viewModal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    $('closeViewParentModal').addEventListener('click', closeViewModal);
    $('closeViewParentButton').addEventListener('click', closeViewModal);
    viewModal.addEventListener('click', e => {
        if (e.target === viewModal) closeViewModal();
    });

    form.addEventListener('submit', async e => {
        e.preventDefault();

        formError.classList.add('hidden');

        const id = formId.value;
        const editing = Boolean(id);

        if ((!editing || formPassword.value) && formPassword.value !== formConfirmPassword.value) {
            formError.textContent = 'Password and confirmation password do not match.';
            formError.classList.remove('hidden');
            return;
        }

        const payload = {
            name: formName.value.trim(),
            email: formEmail.value.trim(),
            phone: formPhone.value.trim(),
            relationship: formRelationship.value.trim(),
            status: formStatus.checked ? 1 : 0
        };

        if (formPassword.value) {
            payload.password = formPassword.value;
            payload.password_confirmation = formConfirmPassword.value;
        }

        const button = $('saveParentBtn');
        button.disabled = true;
        $('saveParentText').textContent = editing ? 'Updating...' : 'Saving...';

        try {
            const response = await fetch(editing ? `${API_URL}/${id}` : API_URL, {
                method: editing ? 'PUT' : 'POST',
                headers: { ...headers, 'Content-Type': 'application/json' },
                body: JSON.stringify(payload)
            });

            if (response.status === 401) return logout();

            const result = await response.json();

            if (!response.ok || !result.status) {
                if (result.errors) throw new Error(Object.values(result.errors).flat().join(' '));
                throw new Error(result.message || 'Unable to save parent.');
            }

            closeModal();
            showToast(editing ? 'Parent updated successfully.' : 'Parent created successfully.');
            await loadParents(currentPage);
        } catch (error) {
            formError.textContent = error.message;
            formError.classList.remove('hidden');
        } finally {
            button.disabled = false;
            $('saveParentText').textContent = editing ? 'Update Parent' : 'Save Parent';
        }
    });

    window.toggleParentStatus = async id => {
        try {
            const response = await fetch(`${API_URL}/${id}/status`, {
                method: 'PATCH',
                headers
            });

            if (response.status === 401) return logout();

            const result = await response.json();
            if (!response.ok || !result.status) throw new Error(result.message || 'Unable to update parent status.');

            showToast(result.message || 'Parent status updated successfully.');
            await loadParents(currentPage);
        } catch (error) {
            showToast(error.message, 'error');
        }
    };

    window.deleteParent = async id => {
        selectedParentId = id;

        deleteMessage.className = 'rounded-lg bg-amber-50 p-4 text-sm text-amber-700';
        deleteMessage.textContent = 'Checking parent student records...';
        deleteButton.classList.add('hidden');
        deactivateButton.classList.add('hidden');

        deleteModal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');

        try {
            const [parentResponse, studentsResponse] = await Promise.all([
                fetch(`${API_URL}/${id}`, { headers }),
                fetch(`${API_URL}/${id}/students`, { headers })
            ]);

            if (parentResponse.status === 401 || studentsResponse.status === 401) return logout();

            const parentResult = await parentResponse.json();
            const studentsResult = await studentsResponse.json();

            if (!parentResponse.ok || !parentResult.status) {
                throw new Error(parentResult.message || 'Unable to load parent.');
            }

            if (!studentsResponse.ok || !studentsResult.status) {
                throw new Error(studentsResult.message || 'Unable to check student records.');
            }

            const studentCount = Number(
                studentsResult.data?.meta?.total ??
                studentsResult.meta?.total ??
                studentsResult.data?.data?.length ??
                studentsResult.data?.length ??
                0
            );

            if (studentCount > 0) {
                deleteMessage.textContent =
                    `Parent "${parentResult.data.name}" cannot be deleted because they have ${studentCount} student${studentCount === 1 ? '' : 's'} record${studentCount === 1 ? '' : 's'}. You can deactivate the parent instead.`;
                deactivateButton.classList.remove('hidden');
            } else {
                deleteMessage.className = 'rounded-lg bg-red-50 p-4 text-sm text-red-700';
                deleteMessage.textContent =
                    `Are you sure you want to delete "${parentResult.data.name}"? This action cannot be undone.`;
                deleteButton.classList.remove('hidden');
            }
        } catch (error) {
            deleteMessage.className = 'rounded-lg bg-red-50 p-4 text-sm text-red-700';
            deleteMessage.textContent = error.message;
        }
    };

    function closeDeleteModal() {
        deleteModal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
        selectedParentId = null;
        deleteButton.classList.add('hidden');
        deactivateButton.classList.add('hidden');
    }

    $('cancelDeleteParentButton').addEventListener('click', closeDeleteModal);

    deleteButton.addEventListener('click', () => deleteParentAction(false));
    deactivateButton.addEventListener('click', () => deleteParentAction(true));

    async function deleteParentAction(deactivate) {
        if (!selectedParentId) return;

        const id = selectedParentId;
        const button = deactivate ? deactivateButton : deleteButton;

        button.disabled = true;
        button.textContent = deactivate ? 'Deactivating...' : 'Deleting...';

        try {
            const response = await fetch(
                deactivate ? `${API_URL}/${id}/status` : `${API_URL}/${id}`,
                {
                    method: deactivate ? 'PATCH' : 'DELETE',
                    headers
                }
            );

            if (response.status === 401) return logout();

            const result = await response.json();

            if (!response.ok || !result.status) {
                throw new Error(result.message || 'Operation failed.');
            }

            closeDeleteModal();
            showToast(result.message || 'Operation completed successfully.');
            await loadParents(currentPage);
        } catch (error) {
            deleteMessage.className = 'rounded-lg bg-red-50 p-4 text-sm text-red-700';
            deleteMessage.textContent = error.message;
        } finally {
            button.disabled = false;
            button.textContent = deactivate ? 'Deactivate Parent' : 'Delete Parent';
        }
    }

    function showToast(message, icon = 'check_circle') {
        const toast = $('toastNotification');
        $('toastMessage').textContent = message;
        $('toastIcon').textContent = icon;

        toast.classList.remove('translate-y-16', 'opacity-0', 'pointer-events-none');
        toast.classList.add('translate-y-0', 'opacity-100');

        setTimeout(() => {
            toast.classList.add('translate-y-16', 'opacity-0', 'pointer-events-none');
            toast.classList.remove('translate-y-0', 'opacity-100');
        }, 3000);
    }

    function getInitials(name) {
        return String(name || '')
            .trim()
            .split(/\s+/)
            .map(word => word.charAt(0))
            .join('')
            .substring(0, 2)
            .toUpperCase();
    }

    function escapeHtml(value) {
        return String(value ?? '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    loadParents();
    setInterval(() => {
        const modalOpen =
            !modal.classList.contains('hidden') ||
            !viewModal.classList.contains('hidden') ||
            !deleteModal.classList.contains('hidden');

        const searching = document.activeElement === searchInput;

        if (!modalOpen && !searching) {
            loadParents(currentPage);
        }
    }, 10000);
})();
</script>

@endsection
