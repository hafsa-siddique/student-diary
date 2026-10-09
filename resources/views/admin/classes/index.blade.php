@extends('layouts.admin')

@section('title', 'Class Directory')

@section('content')
<div class="flex flex-col gap-space-lg w-full">
    <div class="flex flex-col gap-1">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-space-md mt-2">
            <div>
                <h1 class="font-headline-lg text-headline-lg text-on-surface tracking-tight">Classes</h1>
                <p class="font-body-md text-body-md text-on-surface-variant mt-0.5">Manage classes belonging to your institute.</p>
            </div>
            <button type="button" id="openModalBtn" class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-primary-container text-on-primary hover:bg-primary transition-all rounded-lg shadow-sm font-label-lg text-label-lg active:scale-[0.98]">
                <span class="material-symbols-outlined text-[20px]">add</span> Add Class
            </button>
        </div>
    </div>

    <div class="space-y-space-md">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <div class="bg-surface-container-lowest p-space-md rounded-xl shadow-sm flex items-center justify-between">
                <div class="flex flex-col">
                    <span class="font-label-sm text-label-sm text-outline uppercase tracking-wider">Total Classes</span>
                    <span id="totalClasses" class="font-display-lg text-display-lg text-on-surface mt-1 font-tabular-numeric">—</span>
                    <span id="session" class="font-body-sm text-body-sm text-primary flex items-center gap-1 mt-0.5">
                        <span class="material-symbols-outlined text-[16px]">groups</span> All institute classes
                    </span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-surface-container flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined text-[26px]">school</span>
                </div>
            </div>

            <div class="bg-surface-container-lowest p-space-md rounded-xl shadow-sm flex items-center justify-between">
                <div class="flex flex-col">
                    <span class="font-label-sm text-label-sm text-outline uppercase tracking-wider">Active Classes</span>
                    <span id="activeClasses" class="font-display-lg text-display-lg text-secondary mt-1 font-tabular-numeric">—</span>
                    <span id="activePercentage" class="font-body-sm text-body-sm text-on-surface-variant flex items-center gap-1 mt-0.5">Loading...</span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-surface-container flex items-center justify-center text-secondary">
                    <span class="material-symbols-outlined text-[26px]">check_circle</span>
                </div>
            </div>

            <div class="bg-surface-container-lowest p-space-md rounded-xl shadow-sm flex items-center justify-between">
                <div class="flex flex-col">
                    <span class="font-label-sm text-label-sm text-outline uppercase tracking-wider">Inactive Classes</span>
                    <span id="inactiveClasses" class="font-display-lg text-display-lg text-tertiary mt-1 font-tabular-numeric">—</span>
                    <span class="font-body-sm text-body-sm text-on-surface-variant flex items-center gap-1 mt-0.5">Inactive classes</span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-tertiary-fixed flex items-center justify-center text-tertiary">
                    <span class="material-symbols-outlined text-[26px]">cancel</span>
                </div>
            </div>
        </div>

        <div class="bg-surface-container-lowest p-space-md rounded-xl shadow-sm flex flex-col lg:flex-row items-stretch lg:items-center gap-space-md">
            <div class="flex flex-1 flex-col sm:flex-row items-stretch sm:items-center gap-3">
                <div class="relative flex-1 min-w-[280px]">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[20px]">search</span>
                    <input type="text" id="searchInput" class="w-full h-10 pl-10 pr-4 rounded-lg bg-surface text-on-surface font-body-sm text-body-sm placeholder:text-outline focus:outline-none focus:bg-surface-container-lowest focus:shadow-sm transition-all" placeholder="Search classes by name">
                </div>
                <div class="relative">
                    <select id="statusFilter" class="h-10 pl-3 pr-8 rounded-lg bg-surface font-label-md text-label-md text-on-surface appearance-none cursor-pointer focus:outline-none">
                        <option value="all">All Status</option><option value="active">Active</option><option value="inactive">Inactive</option>
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
                            <th class="py-3 px-10">Class</th>
                            <th class="py-3 px-4 text-center">Sections</th>
                            <th class="py-3 px-4 text-center">Students</th>
                            <th class="py-3 px-4 text-center">Status</th>
                            <th class="py-3 px-4 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="classTableBody" class="divide-y divide-surface-container font-body-md text-body-md text-on-surface">
                        <tr>
                            <td colspan="6" class="py-10 text-center text-on-surface-variant">
                                <div class="flex items-center justify-center gap-2">
                                    <span class="material-symbols-outlined animate-spin text-[22px]">progress_activity</span> Loading classes...
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="p-space-md bg-surface-container-lowest flex flex-col sm:flex-row items-center justify-between gap-space-md border-t border-surface-container">
                <div id="classPaginationInfo" class="font-body-sm text-body-sm text-on-surface-variant">Loading...</div>
                <div id="classPagination" class="flex items-center gap-1 font-label-md text-label-md"></div>
            </div>
        </div>
    </div>
</div>

<div id="classModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4" role="dialog" aria-modal="true" aria-labelledby="classModalTitle">
    <div class="w-full max-w-3xl max-h-[90vh] overflow-hidden rounded-2xl bg-surface-container-lowest shadow-xl flex flex-col">
        <div class="flex items-center justify-between border-b border-outline-variant p-5 shrink-0">
            <div>
                <h2 id="classModalTitle" class="font-headline-md text-headline-md text-on-surface">Add New Class</h2>
                <p id="classModalSubtitle" class="mt-1 text-sm text-on-surface-variant">Create a new class and its sections.</p>
            </div>
            <button type="button" id="closeClassModalBtn" class="rounded-lg p-2 text-on-surface-variant hover:bg-surface-container" aria-label="Close modal">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <form id="classForm" class="flex flex-col min-h-0">
            <input type="hidden" id="formClassId" value="">
            <div class="p-5 overflow-y-auto">
                <div>
                    <label for="className" class="mb-1 block text-sm font-medium text-on-surface">Class Name *</label>
                    <input type="text" id="className" name="name" required maxlength="255" class="w-full rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface" placeholder="e.g. Class 5">
                </div>

                <div class="mt-4">
                    <label for="classDescription" class="mb-1 block text-sm font-medium text-on-surface">Description</label>
                    <textarea id="classDescription" name="description" rows="3" maxlength="1000" class="w-full rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface resize-none" placeholder="Enter class description (optional)"></textarea>
                </div>

                <div class="mt-5">
                    <div class="flex items-center justify-between mb-2">
                        <div>
                            <label class="block text-sm font-medium text-on-surface">Sections *</label>
                            <p class="mt-1 text-xs text-on-surface-variant">Add at least one section for this class.</p>
                        </div>
                        <button type="button" id="addSectionBtn" class="flex items-center gap-1 rounded-lg bg-secondary-container px-3 py-2 text-sm font-semibold text-on-secondary-container hover:opacity-90">
                            <span class="material-symbols-outlined text-[18px]">add</span> Add Section
                        </button>
                    </div>
                    <div id="sectionsContainer" class="space-y-3"></div>
                </div>

                <div class="mt-5">
                    <div class="flex items-center justify-between rounded-lg bg-surface-container-low p-4">
                        <div>
                            <span class="block text-sm font-semibold text-on-surface">Class Status</span>
                            <span class="mt-1 block text-sm text-on-surface-variant">Allow this class to be used in the system.</span>
                        </div>
                        <label class="relative inline-flex cursor-pointer items-center">
                            <input type="checkbox" id="classStatusToggle" name="status" class="sr-only peer" checked>
                            <div class="h-6 w-11 rounded-full bg-outline after:absolute after:left-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:bg-white after:transition-all after:content-[''] peer-checked:bg-primary peer-checked:after:translate-x-full"></div>
                        </label>
                    </div>
                </div>

                <div id="classFormError" class="hidden mt-4 rounded-lg bg-red-50 p-3 text-sm text-red-700" role="alert"></div>
            </div>

            <div class="flex justify-end gap-3 border-t border-outline-variant p-5 shrink-0 bg-surface-container-lowest">
                <button type="button" id="cancelClassModalBtn" class="rounded-lg border border-outline-variant px-4 py-2 text-sm font-medium text-on-surface hover:bg-surface-container">Cancel</button>
                <button type="submit" id="saveClassBtn" class="rounded-lg bg-primary px-5 py-2 text-sm font-semibold text-white hover:opacity-90">
                    <span id="saveClassText">Save Class</span>
                </button>
            </div>
        </form>
    </div>
</div>

<div id="deleteClassModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
    <div class="w-full max-w-md rounded-2xl bg-surface-container-lowest shadow-xl">
        <div class="border-b border-outline-variant p-5"><h2 class="font-headline-md text-headline-md text-on-surface">Delete Class</h2></div>
        <div class="p-5"><div id="deleteClassMessage" class="rounded-lg p-4 text-sm"></div></div>
        <div class="flex justify-end gap-3 border-t border-outline-variant p-5">
            <button type="button" id="cancelDeleteClassButton" class="rounded-lg border border-outline-variant px-4 py-2 text-sm font-medium text-on-surface">Cancel</button>
            <button type="button" id="confirmDeleteClassButton" class="hidden rounded-lg bg-red-600 px-5 py-2 text-sm font-semibold text-white">Delete Class</button>
            <button type="button" id="confirmDeactivateClassButton" class="hidden rounded-lg bg-primary px-5 py-2 text-sm font-semibold text-white">Deactivate Class</button>
        </div>
    </div>
</div>

<div id="viewClassModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
    <div class="w-full max-w-lg rounded-2xl bg-surface-container-lowest shadow-xl">
        <div class="flex items-center justify-between border-b border-outline-variant p-5">
            <div>
                <h2 class="font-headline-md text-headline-md text-on-surface">Class Details</h2>
                <p class="mt-1 text-sm text-on-surface-variant">View class information</p>
            </div>
            <button type="button" id="closeViewClassModal" class="rounded-lg p-2 text-on-surface-variant hover:bg-surface-container">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <div class="p-5">
            <div class="flex items-center gap-4 pb-5">
                <div id="viewClassAvatar"></div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center justify-between gap-4 flex-wrap">
                        <h3 id="viewClassName" class="text-lg font-semibold text-on-surface">—</h3>
                        <div id="viewClassStatus">—</div>
                    </div>
                    <p id="viewClassSession" class="mt-1 text-sm text-on-surface-variant">—</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="rounded-lg bg-surface-container-low p-4"><p class="text-xs text-on-surface-variant">Sections</p><p id="viewClassSectionsCount" class="mt-1 font-medium text-on-surface">—</p></div>
                <div class="rounded-lg bg-surface-container-low p-4"><p class="text-xs text-on-surface-variant">Students</p><p id="viewClassStudentsCount" class="mt-1 font-medium text-on-surface">—</p></div>
                <div class="rounded-lg bg-surface-container-low p-4 sm:col-span-2">
                    <p class="text-xs text-on-surface-variant">Sections</p>
                    <div id="viewClassSections" class="space-y-3 mt-2"></div>
                </div>
            </div>
        </div>

        <div class="flex justify-end border-t border-outline-variant p-5">
            <button type="button" id="closeViewClassButton" class="rounded-lg border border-outline-variant px-4 py-2 text-sm font-medium text-on-surface">Close</button>
        </div>
    </div>
</div>

<div id="toastNotification" class="fixed bottom-6 right-6 z-50 bg-inverse-surface text-inverse-on-surface px-4 py-3 rounded-lg shadow-lg flex items-center gap-3 translate-y-16 opacity-0 pointer-events-none transition-all duration-300">
    <span id="toastIcon" class="material-symbols-outlined text-secondary-fixed text-[20px]">check_circle</span>
    <span id="toastMessage" class="font-body-sm text-body-sm"></span>
</div>

<script>
(() => {
    const API_URL = '/api/v1/admin/classes', token = localStorage.getItem('student_diary_token');
    if (!token) { window.location.replace('/'); return; }

    const headers = { Accept: 'application/json', Authorization: `Bearer ${token}` }, $ = id => document.getElementById(id);
    const tableBody = $('classTableBody'), searchInput = $('searchInput'), statusFilter = $('statusFilter');
    const pagination = $('classPagination'), paginationInfo = $('classPaginationInfo'), modal = $('classModal'), form = $('classForm');
    const formId = $('formClassId'), formName = $('className'), formDescription = $('classDescription'), formStatus = $('classStatusToggle');
    const formError = $('classFormError'), modalTitle = $('classModalTitle'), modalSubtitle = $('classModalSubtitle');
    const sectionsContainer = $('sectionsContainer'), addSectionBtn = $('addSectionBtn'), viewModal = $('viewClassModal');
    const viewAvatar = $('viewClassAvatar'), viewName = $('viewClassName'), viewSession = $('viewClassSession'), viewStatus = $('viewClassStatus');
    const viewSectionsCount = $('viewClassSectionsCount'), viewStudentsCount = $('viewClassStudentsCount'), viewSections = $('viewClassSections');
    const deleteModal = $('deleteClassModal'), deleteMessage = $('deleteClassMessage'), deleteButton = $('confirmDeleteClassButton');
    const deactivateButton = $('confirmDeactivateClassButton');

    let allClasses = [], currentPage = 1, lastPage = 1, selectedClassId = null, searchTimer;

    function logout() {
        localStorage.removeItem('student_diary_token');
        localStorage.removeItem('student_diary_user');
        localStorage.removeItem('student_diary_institute_code');
        window.location.replace('/');
    }

    async function loadClasses(page = 1) {
        try {
            tableBody.innerHTML = `<tr><td colspan="6" class="py-10 text-center text-on-surface-variant">Loading classes...</td></tr>`;
            const params = new URLSearchParams({ page }), search = searchInput.value.trim(), status = statusFilter.value;
            if (search) params.set('search', search);
            if (status !== 'all') params.set('status', status);

            const response = await fetch(`${API_URL}?${params}`, { headers });
            if (response.status === 401) return logout();

            const result = await response.json();
            if (!response.ok || !result.status) throw new Error(result.message || 'Failed to load classes.');

            allClasses = Array.isArray(result.data) ? result.data : [];
            const meta = result.meta || {};
            currentPage = Number(meta.current_page || page);
            lastPage = Number(meta.last_page || 1);
            updateStatistics(result); renderClasses(); renderPagination(meta);
        } catch (error) {
            console.error(error);
            tableBody.innerHTML = `<tr><td colspan="6" class="py-10 text-center text-error">${escapeHtml(error.message)}</td></tr>`;
        }
    }

    function updateStatistics(result) {
        const stats = result.statistics || {}, total = Number(stats.total || 0), active = Number(stats.active || 0), inactive = Number(stats.inactive || 0);
        const percentage = total ? ((active / total) * 100).toFixed(1) : '0.0';
        $('totalClasses').textContent = total;
        $('activeClasses').textContent = active;
        $('inactiveClasses').textContent = inactive;
        $('activePercentage').innerHTML = `<span class="w-1.5 h-1.5 rounded-full bg-secondary"></span> ${percentage}% active`;
    }

    function renderClasses() {
        if (!allClasses.length) {
            tableBody.innerHTML = `<tr><td colspan="6" class="py-10 text-center text-on-surface-variant">No classes found.</td></tr>`;
            return;
        }

        tableBody.innerHTML = allClasses.map((classItem, index) => {
            const active = Number(classItem.status) === 1;
            const sectionCount = Number(classItem.sections_count ?? classItem.section_count ?? classItem.sections?.length ?? 0);
            const studentCount = Number(classItem.students_count ?? classItem.student_count ?? 0);

            return `
                <tr>
                    <td class="py-3 px-4 text-center">${((currentPage - 1) * 10) + index + 1}</td>
                    <td class="py-3 px-10">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-lg bg-primary text-on-primary flex items-center justify-center font-semibold">${escapeHtml(getInitials(classItem.name))}</div>
                            <div class="font-medium text-on-surface">${escapeHtml(classItem.name || '—')}</div>
                        </div>
                    </td>
                    <td class="py-3 px-4 text-center"><span class="inline-flex items-center justify-center min-w-8 px-2.5 py-1 rounded-full bg-surface-container text-sm font-semibold text-on-surface">${sectionCount}</span></td>
                    <td class="py-3 px-4 text-center"><span class="inline-flex items-center justify-center min-w-8 px-2.5 py-1 rounded-full bg-surface-container text-sm font-semibold text-on-surface">${studentCount}</span></td>
                    <td class="py-3 px-4 text-center">
                        <span class="inline-flex items-center gap-1.5 text-xs font-semibold ${active ? 'text-secondary' : 'text-outline'}">
                            <span class="w-1.5 h-1.5 rounded-full ${active ? 'bg-secondary' : 'bg-outline'}"></span>${active ? 'Active' : 'Inactive'}
                        </span>
                    </td>
                    <td class="py-3 px-4">
                        <div class="flex items-center justify-center gap-1">
                            <button type="button" onclick="viewClass(${classItem.id})" class="p-2 rounded-lg text-on-surface-variant hover:bg-surface-container" title="View"><span class="material-symbols-outlined text-[20px]">visibility</span></button>
                            <button type="button" onclick="editClass(${classItem.id})" class="p-2 rounded-lg text-on-surface-variant hover:bg-surface-container" title="Edit"><span class="material-symbols-outlined text-[20px]">edit</span></button>
                            <button type="button" onclick="toggleClassStatus(${classItem.id})" class="p-2 rounded-lg text-on-surface-variant hover:bg-surface-container" title="${active ? 'Deactivate' : 'Activate'}"><span class="material-symbols-outlined text-[20px]">${active ? 'person_off' : 'how_to_reg'}</span></button>
                            <button type="button" onclick="deleteClass(${classItem.id})" class="p-2 rounded-lg text-error hover:bg-red-50" title="Delete"><span class="material-symbols-outlined text-[20px]">delete</span></button>
                        </div>
                    </td>
                </tr>`;
        }).join('');
    }

    function renderPagination(meta) {
        pagination.innerHTML = '';
        const total = Number(meta.total || 0), from = Number(meta.from || 0), to = Number(meta.to || 0);
        paginationInfo.textContent = total ? `Showing ${from}–${to} of ${total} classes` : 'Showing 0 classes';
        if (lastPage <= 1) return;

        const button = (text, disabled, action, active = false) => {
            const el = document.createElement('button');
            el.type = 'button'; el.innerHTML = text; el.disabled = disabled;
            el.className = `min-w-8 px-2 py-1.5 rounded-lg text-sm ${active ? 'bg-primary text-on-primary' : 'text-on-surface hover:bg-surface-container'} disabled:opacity-40`;
            el.onclick = action; pagination.appendChild(el);
        };

        button('<span class="material-symbols-outlined text-[18px]">chevron_left</span>', currentPage === 1, () => loadClasses(currentPage - 1));
        for (let page = 1; page <= lastPage; page++) button(page, false, () => loadClasses(page), page === currentPage);
        button('<span class="material-symbols-outlined text-[18px]">chevron_right</span>', currentPage === lastPage, () => loadClasses(currentPage + 1));
    }

    searchInput.addEventListener('input', () => {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(() => loadClasses(1), 300);
    });

    statusFilter.addEventListener('change', () => loadClasses(1));

    function addSectionInput(value = '', id = '', status = true) {
        const row = document.createElement('div');
        row.className = 'flex items-center gap-2';
        row.innerHTML = `
            <input type="hidden" class="section-id" value="${id}">
            <input type="text" value="${escapeHtml(value)}" maxlength="100" required class="section-input w-full rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface" placeholder="e.g. Section A">
            <label class="flex items-center gap-2 shrink-0 text-sm"><input type="checkbox" class="section-status" ${Number(status) === 1 || status === true ? 'checked' : ''}> Active</label>
            <button type="button" class="removeSectionBtn shrink-0 rounded-lg border border-outline-variant p-2 text-on-surface-variant hover:bg-surface-container" title="Remove section"><span class="material-symbols-outlined text-[20px]">delete</span></button>`;
        sectionsContainer.appendChild(row); updateRemoveSectionButtons();
    }

    function updateRemoveSectionButtons() {
        const rows = sectionsContainer.children;
        Array.from(rows).forEach(row => row.querySelector('.removeSectionBtn').classList.toggle('hidden', rows.length === 1));
    }

    addSectionBtn.addEventListener('click', () => addSectionInput());

    sectionsContainer.addEventListener('click', event => {
        const button = event.target.closest('.removeSectionBtn');
        if (!button) return;
        button.closest('.flex.items-center').remove();
        updateRemoveSectionButtons();
    });

    function resetSections() {
        sectionsContainer.innerHTML = '';
        addSectionInput();
    }

    $('openModalBtn').addEventListener('click', () => {
        form.reset();
        if (formId) formId.value = '';
        formStatus.checked = true; resetSections();
        modalTitle.textContent = 'Add New Class';
        modalSubtitle.textContent = 'Create a new class and its sections.';
        $('saveClassText').textContent = 'Save Class';
        formError.classList.add('hidden'); formError.textContent = '';
        modal.classList.remove('hidden');
    });

    function closeModal() {
        modal.classList.add('hidden');
        formError.classList.add('hidden'); formError.textContent = '';
    }

    $('closeClassModalBtn').addEventListener('click', closeModal);
    $('cancelClassModalBtn').addEventListener('click', closeModal);
    modal.addEventListener('click', event => { if (event.target === modal) closeModal(); });

    window.editClass = async id => {
        try {
            const response = await fetch(`${API_URL}/${id}`, { headers });
            if (response.status === 401) return logout();
            const result = await response.json();
            if (!response.ok || !result.status) throw new Error(result.message || 'Unable to load class.');

            const classItem = result.data;
            formId.value = classItem.id;
            formName.value = classItem.name || '';
            formDescription.value = classItem.description || '';
            formStatus.checked = Number(classItem.status) === 1;
            sectionsContainer.innerHTML = '';

            const sectionsResponse = await fetch(`${API_URL}/${id}/sections`, { headers });
            if (sectionsResponse.status === 401) return logout();
            const sectionsResult = await sectionsResponse.json();
            if (!sectionsResponse.ok || !sectionsResult.status) throw new Error(sectionsResult.message || 'Unable to load sections.');

            const sections = Array.isArray(sectionsResult.data?.data) ? sectionsResult.data.data : Array.isArray(sectionsResult.data) ? sectionsResult.data : [];
            sections.forEach(section => addSectionInput(section.name || '', section.id || '', section.status));
            if (!sections.length) addSectionInput();

            modalTitle.textContent = 'Edit Class';
            modalSubtitle.textContent = 'Update class information.';
            $('saveClassText').textContent = 'Update Class';
            formError.classList.add('hidden'); formError.textContent = '';
            modal.classList.remove('hidden'); document.body.classList.add('overflow-hidden');
        } catch (error) {
            console.error(error); showToast(error.message, 'error');
        }
    };

    form.addEventListener('submit', async event => {
        event.preventDefault();
        formError.classList.add('hidden'); formError.textContent = '';

        const id = formId?.value || '', editing = Boolean(id), sections = [];

        sectionsContainer.querySelectorAll('.section-input').forEach(input => {
            const value = input.value.trim();
            if (!value) return;

            if (editing) {
                const row = input.closest('.flex.items-center');
                sections.push({ id: row.querySelector('.section-id')?.value || null, name: value });
            } else sections.push(value);
        });

        if (!sections.length) {
            formError.textContent = 'Please add at least one section.';
            formError.classList.remove('hidden');
            return;
        }

        const payload = { name: formName.value.trim(), description: formDescription.value.trim() || null, status: formStatus.checked ? 1 : 0, sections };
        const button = $('saveClassBtn'), buttonText = $('saveClassText');
        button.disabled = true; buttonText.textContent = editing ? 'Updating...' : 'Creating...';

        try {
            const response = await fetch(editing ? `${API_URL}/${id}` : API_URL, {
                method: editing ? 'PUT' : 'POST',
                headers: { ...headers, 'Content-Type': 'application/json' },
                body: JSON.stringify(payload)
            });

            if (response.status === 401) { logout(); return; }
            const result = await response.json();
            if (!response.ok || !result.status) throw new Error(result.message || 'Unable to save class.');

            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
            form.reset(); formId.value = ''; sectionsContainer.innerHTML = '';
            addSectionInput();
            await loadClasses();

            showToast(result.message || (editing ? 'Class updated successfully.' : 'Class and sections created successfully.'));
        } catch (error) {
            console.error(error);
            formError.textContent = error.message; formError.classList.remove('hidden');
        } finally {
            button.disabled = false;
            buttonText.textContent = editing ? 'Update Class' : 'Create Class';
        }
    });

    window.viewClass = async id => {
        viewModal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
        viewName.textContent = 'Loading...';
        viewSession.textContent = 'Loading...';
        viewStatus.innerHTML = 'Loading...';
        viewSectionsCount.textContent = '—';
        viewStudentsCount.textContent = '—';
        viewSections.innerHTML = `<p class="text-sm text-on-surface-variant">Loading sections...</p>`;

        try {
            const response = await fetch(`${API_URL}/${id}`, { headers });
            if (response.status === 401) return logout();
            const result = await response.json();
            if (!response.ok || !result.status) throw new Error(result.message || 'Unable to load class.');

            const classItem = result.data, active = Number(classItem.status) === 1;
            viewName.textContent = classItem.name || '—';
            viewSession.textContent = classItem.academic_session?.name ? `Session: ${classItem.academic_session.name}` : 'Session: —';

            viewStatus.innerHTML = `<span class="inline-flex items-center gap-1.5 text-xs font-semibold ${active ? 'text-secondary' : 'text-outline'}"><span class="w-1.5 h-1.5 rounded-full ${active ? 'bg-secondary' : 'bg-outline'}"></span>${active ? 'Active' : 'Inactive'}</span>`;
            viewAvatar.innerHTML = `<div class="w-16 h-16 rounded-lg bg-primary text-on-primary flex items-center justify-center font-semibold text-xl">${escapeHtml(getInitials(classItem.name))}</div>`;

            viewSectionsCount.textContent = classItem.sections_count ?? classItem.section_count ?? classItem.sections?.length ?? 0;
            viewStudentsCount.textContent = classItem.students_count ?? classItem.student_count ?? 0;

            let sections = Array.isArray(classItem.sections) ? classItem.sections : [];

            if (!sections.length) {
                const sectionsResponse = await fetch(`${API_URL}/${id}/sections`, { headers });
                if (sectionsResponse.status === 401) return logout();

                const sectionsResult = await sectionsResponse.json();
                if (!sectionsResponse.ok || !sectionsResult.status) throw new Error(sectionsResult.message || 'Unable to load sections.');

                sections = Array.isArray(sectionsResult.data?.data) ? sectionsResult.data.data : Array.isArray(sectionsResult.data) ? sectionsResult.data : [];
            }

            if (!sections.length) {
                viewSections.innerHTML = `<p class="text-sm text-on-surface-variant">No sections found.</p>`;
                return;
            }

            viewSections.innerHTML = sections.map(section => {
                const name = section.name || 'Unknown Section';
                const studentCount = Number(section.students_count ?? section.student_count ?? section.students?.length ?? 0);
                const active = Number(section.status) === 1;

                return `
                    <div class="flex items-center justify-between gap-3 rounded-lg bg-surface-container-low p-3">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-10 h-10 shrink-0 rounded-lg bg-primary text-on-primary flex items-center justify-center font-semibold">${escapeHtml(getInitials(name))}</div>
                            <div class="min-w-0">
                                <p class="font-medium text-on-surface truncate">${escapeHtml(name)}</p>
                                <p class="text-xs text-on-surface-variant mt-0.5">Students: <span class="font-medium text-on-surface">${studentCount}</span></p>
                            </div>
                        </div>
                        <span class="shrink-0 text-xs font-semibold ${active ? 'text-secondary' : 'text-outline'}">${active ? 'Active' : 'Inactive'}</span>
                    </div>`;
            }).join('');
        } catch (error) {
            console.error(error);
            viewSections.innerHTML = `<div class="rounded-lg bg-red-50 p-4 text-sm text-red-700">${escapeHtml(error.message)}</div>`;
        }
    };

    function closeViewModal() {
        viewModal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    $('closeViewClassModal').addEventListener('click', closeViewModal);
    $('closeViewClassButton').addEventListener('click', closeViewModal);
    viewModal.addEventListener('click', event => { if (event.target === viewModal) closeViewModal(); });

    window.toggleClassStatus = async id => {
        try {
            const response = await fetch(`${API_URL}/${id}/status`, { method: 'PATCH', headers });
            if (response.status === 401) return logout();

            const result = await response.json();
            if (!response.ok || !result.status) throw new Error(result.message || 'Unable to update class status.');

            showToast(result.message || 'Class status updated successfully.');
            await loadClasses(currentPage);
        } catch (error) {
            console.error(error); showToast(error.message, 'error');
        }
    };

    window.deleteClass = async id => {
        selectedClassId = id;
        deleteMessage.className = 'rounded-lg bg-amber-50 p-4 text-sm text-amber-700';
        deleteMessage.textContent = 'Checking class records...';
        deleteButton.classList.add('hidden');
        deactivateButton.classList.add('hidden');
        deleteModal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');

        try {
            const [classResponse, sectionsResponse] = await Promise.all([
                fetch(`${API_URL}/${id}`, { headers }), fetch(`${API_URL}/${id}/sections`, { headers })
            ]);

            if (classResponse.status === 401 || sectionsResponse.status === 401) return logout();

            const classResult = await classResponse.json(), sectionsResult = await sectionsResponse.json();
            if (!classResponse.ok || !classResult.status) throw new Error(classResult.message || 'Unable to load class.');
            if (!sectionsResponse.ok || !sectionsResult.status) throw new Error(sectionsResult.message || 'Unable to check class records.');

            const sectionCount = Number(sectionsResult.data?.meta?.total ?? sectionsResult.meta?.total ?? sectionsResult.data?.data?.length ?? sectionsResult.data?.length ?? 0);

            if (sectionCount > 0) {
                deleteMessage.textContent = `Class "${classResult.data.name}" cannot be deleted because it has ${sectionCount} section${sectionCount === 1 ? '' : 's'}. You can deactivate the class instead.`;
                deactivateButton.classList.remove('hidden');
            } else {
                deleteMessage.className = 'rounded-lg bg-red-50 p-4 text-sm text-red-700';
                deleteMessage.textContent = `Are you sure you want to delete "${classResult.data.name}"? This action cannot be undone.`;
                deleteButton.classList.remove('hidden');
            }
        } catch (error) {
            console.error(error);
            deleteMessage.className = 'rounded-lg bg-red-50 p-4 text-sm text-red-700';
            deleteMessage.textContent = error.message;
        }
    };

    function closeDeleteModal() {
        deleteModal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
        selectedClassId = null;
        deleteButton.classList.add('hidden');
        deactivateButton.classList.add('hidden');
    }

    $('cancelDeleteClassButton').addEventListener('click', closeDeleteModal);
    deleteButton.addEventListener('click', () => deleteClassAction(false));
    deactivateButton.addEventListener('click', () => deleteClassAction(true));

    async function deleteClassAction(deactivate) {
        if (!selectedClassId) return;

        const id = selectedClassId, button = deactivate ? deactivateButton : deleteButton;
        button.disabled = true;
        button.textContent = deactivate ? 'Deactivating...' : 'Deleting...';

        try {
            const response = await fetch(deactivate ? `${API_URL}/${id}/status` : `${API_URL}/${id}`, {
                method: deactivate ? 'PATCH' : 'DELETE', headers
            });

            if (response.status === 401) return logout();

            const result = await response.json();
            if (!response.ok || !result.status) throw new Error(result.message || 'Operation failed.');

            closeDeleteModal();
            showToast(result.message || 'Operation completed successfully.');
            await loadClasses(currentPage);
        } catch (error) {
            console.error(error);
            deleteMessage.className = 'rounded-lg bg-red-50 p-4 text-sm text-red-700';
            deleteMessage.textContent = error.message;
        } finally {
            button.disabled = false;
            button.textContent = deactivate ? 'Deactivate Class' : 'Delete Class';
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
        return String(name || '').trim().split(/\s+/).map(word => word.charAt(0)).join('').substring(0, 2).toUpperCase();
    }

    function escapeHtml(value) {
        return String(value ?? '').replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#039;');
    }

    resetSections();
    loadClasses();
})();
</script>
@endsection