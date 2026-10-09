@extends('layouts.admin')

@section('title', 'Subject Directory')

@section('content')

<div class="flex flex-col gap-space-lg w-full">
    <div class="flex flex-col gap-1">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-space-md mt-2">
            <div>
                <h1 class="font-headline-lg text-headline-lg text-on-surface tracking-tight">Subjects</h1>
                <p class="font-body-md text-body-md text-on-surface-variant mt-0.5">
                    Manage subjects belonging to your institute.
                </p>
            </div>
            <button type="button" id="openModalBtn"
                class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-primary-container text-on-primary hover:bg-primary transition-all rounded-lg shadow-sm font-label-lg text-label-lg active:scale-[0.98]">
                <span class="material-symbols-outlined text-[20px]">add</span>
                Add Subject
            </button>
        </div>
    </div>
    <div class="space-y-space-md">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <div class="bg-surface-container-lowest p-space-md rounded-xl shadow-sm flex items-center justify-between">
                <div class="flex flex-col">
                    <span class="font-label-sm text-label-sm text-outline uppercase tracking-wider">
                        Total Subjects
                    </span>

                    <span id="totalSubjects"
                        class="font-display-lg text-display-lg text-on-surface mt-1 font-tabular-numeric">
                        —
                    </span>

                    <span id="session"
                        class="font-body-sm text-body-sm text-primary flex items-center gap-1 mt-0.5">
                        <span class="material-symbols-outlined text-[16px]">menu_book</span>
                        All institute subjects
                    </span>
                </div>

                <div class="w-12 h-12 rounded-xl bg-surface-container flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined text-[26px]">menu_book</span>
                </div>
            </div>

            <div class="bg-surface-container-lowest p-space-md rounded-xl shadow-sm flex items-center justify-between">
                <div class="flex flex-col">
                    <span class="font-label-sm text-label-sm text-outline uppercase tracking-wider">
                        Active Subjects
                    </span>

                    <span id="activeSubjects"
                        class="font-display-lg text-display-lg text-secondary mt-1 font-tabular-numeric">
                        —
                    </span>

                    <span id="activePercentage"
                        class="font-body-sm text-body-sm text-on-surface-variant flex items-center gap-1 mt-0.5">
                        Loading...
                    </span>
                </div>

                <div class="w-12 h-12 rounded-xl bg-surface-container flex items-center justify-center text-secondary">
                    <span class="material-symbols-outlined text-[26px]">check_circle</span>
                </div>
            </div>

            <div class="bg-surface-container-lowest p-space-md rounded-xl shadow-sm flex items-center justify-between">
                <div class="flex flex-col">
                    <span class="font-label-sm text-label-sm text-outline uppercase tracking-wider">
                        Inactive Subjects
                    </span>

                    <span id="inactiveSubjects"
                        class="font-display-lg text-display-lg text-tertiary mt-1 font-tabular-numeric">
                        —
                    </span>

                    <span class="font-body-sm text-body-sm text-on-surface-variant flex items-center gap-1 mt-0.5">
                        Inactive subjects
                    </span>
                </div>

                <div class="w-12 h-12 rounded-xl bg-tertiary-fixed flex items-center justify-center text-tertiary">
                    <span class="material-symbols-outlined text-[26px]">cancel</span>
                </div>
            </div>

        </div>

        <div class="bg-surface-container-lowest p-space-md rounded-xl shadow-sm flex flex-col lg:flex-row items-stretch lg:items-center gap-space-md">

            <div class="flex flex-1 flex-col sm:flex-row items-stretch sm:items-center gap-3">

                <div class="relative flex-1 min-w-[280px]">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[20px]">
                        search
                    </span>

                    <input type="text" id="searchInput"
                        class="w-full h-10 pl-10 pr-4 rounded-lg bg-surface text-on-surface font-body-sm text-body-sm placeholder:text-outline focus:outline-none focus:bg-surface-container-lowest focus:shadow-sm transition-all"
                        placeholder="Search subjects by name">
                </div>

                <div class="relative">
                    <select id="statusFilter"
                        class="h-10 pl-3 pr-8 rounded-lg bg-surface font-label-md text-label-md text-on-surface appearance-none cursor-pointer focus:outline-none">
                        <option value="all">All Status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>

                    <span class="material-symbols-outlined absolute right-2.5 top-1/2 -translate-y-1/2 text-outline text-[18px] pointer-events-none">
                        expand_more
                    </span>
                </div>

            </div>

        </div>

        <div class="bg-surface-container-lowest rounded-xl shadow-sm overflow-hidden flex flex-col">

            <div class="overflow-x-auto w-full">

                <table class="w-full text-left border-collapse">

                    <thead>
                        <tr class="bg-surface-container-low text-on-surface-variant font-label-sm text-label-sm uppercase tracking-wider">
                            <th class="py-3 px-4 w-12 text-center">#</th>
                            <th class="py-3 px-10">Subject</th>
                            <th class="py-3 px-10">Code</th>
                            <th class="py-3 px-4 text-center">Status</th>
                            <th class="py-3 px-4 text-center">Actions</th>
                        </tr>
                    </thead>

                    <tbody id="subjectTableBody"
                        class="divide-y divide-surface-container font-body-md text-body-md text-on-surface">

                        <tr>
                            <td colspan="5" class="py-10 text-center text-on-surface-variant">
                                <div class="flex items-center justify-center gap-2">
                                    <span class="material-symbols-outlined animate-spin text-[22px]">
                                        progress_activity
                                    </span>
                                Loading subjects...
                                </div>
                            </td>
                        </tr>

                    </tbody>

                </table>

            </div>

            <div class="p-space-md bg-surface-container-lowest flex flex-col sm:flex-row items-center justify-between gap-space-md border-t border-surface-container">

                <div id="subjectPaginationInfo"
                    class="font-body-sm text-body-sm text-on-surface-variant">
                    Loading...
                </div>

                <div id="subjectPagination"
                    class="flex items-center gap-1 font-label-md text-label-md">
                </div>

            </div>

        </div>

    </div>

</div>


<!-- Add/Edit Modal -->

<div id="subjectModal"
    class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4"
    role="dialog"
    aria-modal="true"
    aria-labelledby="subjectModalTitle">

    <div class="w-full max-w-3xl max-h-[90vh] overflow-hidden rounded-2xl bg-surface-container-lowest shadow-xl flex flex-col">

        <div class="flex items-center justify-between border-b border-outline-variant p-5 shrink-0">

            <div>
                <h2 id="subjectModalTitle"
                    class="font-headline-md text-headline-md text-on-surface">
                    Add New Subject
                </h2>

                <p id="subjectModalSubtitle"
                    class="mt-1 text-sm text-on-surface-variant">
                    Create a new subject.
                </p>
            </div>

            <button type="button"
                id="closeSubjectModalBtn"
                class="rounded-lg p-2 text-on-surface-variant hover:bg-surface-container"
                aria-label="Close modal">

                <span class="material-symbols-outlined">close</span>

            </button>

        </div>

        <form id="subjectForm" class="flex flex-col min-h-0">

            <input type="hidden" id="formSubjectId" value="">

            <div class="p-5 overflow-y-auto">

                <!-- Subject Name -->

                <div>
                    <label for="subjectName"
                        class="mb-1 block text-sm font-medium text-on-surface">
                        Subject Name *
                    </label>

                    <input type="text"
                        id="subjectName"
                        name="name"
                        required
                        maxlength="100"
                        class="w-full rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface"
                        placeholder="e.g. Mathematics">
                </div>

                <!-- Subject Code -->

                <div class="mt-4">

                    <label for="subjectCode"
                        class="mb-1 block text-sm font-medium text-on-surface">
                        Subject Code *
                    </label>

                    <input type="text"
                        id="subjectCode"
                        name="code"
                        required
                        maxlength="50"
                        class="w-full rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface"
                        placeholder="e.g. MATH">
                </div>


                <!-- Description -->

                <div class="mt-4">

                    <label for="subjectDescription"
                        class="mb-1 block text-sm font-medium text-on-surface">
                        Description
                    </label>

                    <textarea id="subjectDescription"
                        name="description"
                        rows="3"
                        maxlength="1000"
                        class="w-full rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface resize-none"
                        placeholder="Enter subject description (optional)"></textarea>

                </div>


                <!-- Subject Status -->

                <div class="mt-5">

                    <div class="flex items-center justify-between rounded-lg bg-surface-container-low p-4">

                        <div>
                            <span class="block text-sm font-semibold text-on-surface">
                                Subject Status
                            </span>

                            <span class="mt-1 block text-sm text-on-surface-variant">
                                Allow this subject to be used in the system.
                            </span>
                        </div>

                        <label class="relative inline-flex cursor-pointer items-center">

                            <input type="checkbox"
                                id="subjectStatusToggle"
                                name="status"
                                class="sr-only peer"
                                checked>

                            <div class="h-6 w-11 rounded-full bg-outline after:absolute after:left-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:bg-white after:transition-all after:content-[''] peer-checked:bg-primary peer-checked:after:translate-x-full">
                            </div>

                        </label>

                    </div>

                </div>


                <!-- Error -->

                <div id="subjectFormError"
                    class="hidden mt-4 rounded-lg bg-red-50 p-3 text-sm text-red-700"
                    role="alert">
                </div>

            </div>


            <!-- Modal Footer -->

            <div class="flex justify-end gap-3 border-t border-outline-variant p-5 shrink-0 bg-surface-container-lowest">

                <button type="button"
                    id="cancelSubjectModalBtn"
                    class="rounded-lg border border-outline-variant px-4 py-2 text-sm font-medium text-on-surface hover:bg-surface-container">
                    Cancel
                </button>

                <button type="submit"
                    id="saveSubjectBtn"
                    class="rounded-lg bg-primary px-5 py-2 text-sm font-semibold text-white hover:opacity-90">

                    <span id="saveSubjectText">
                        Save Subject
                    </span>

                </button>

            </div>

        </form>

    </div>

</div>


<!-- Delete Modal -->

<div id="deleteSubjectModal"
    class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">

    <div class="w-full max-w-md rounded-2xl bg-surface-container-lowest shadow-xl">

        <div class="border-b border-outline-variant p-5">

            <h2 class="font-headline-md text-headline-md text-on-surface">
                Delete Subject
            </h2>

        </div>

        <div class="p-5">

            <div id="deleteSubjectMessage"
                class="rounded-lg p-4 text-sm">
            </div>

        </div>

        <div class="flex justify-end gap-3 border-t border-outline-variant p-5">

            <button type="button"
                id="cancelDeleteSubjectButton"
                class="rounded-lg border border-outline-variant px-4 py-2 text-sm font-medium text-on-surface">
                Cancel
            </button>

            <button type="button"
                id="confirmDeleteSubjectButton"
                class="hidden rounded-lg bg-red-600 px-5 py-2 text-sm font-semibold text-white">
                Delete Subject
            </button>

            <button type="button"
                id="confirmDeactivateSubjectButton"
                class="hidden rounded-lg bg-primary px-5 py-2 text-sm font-semibold text-white">
                Deactivate Subject
            </button>

        </div>

    </div>

</div>


<!-- View Modal -->

<div id="viewSubjectModal"
    class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">

    <div class="w-full max-w-lg rounded-2xl bg-surface-container-lowest shadow-xl">

        <div class="flex items-center justify-between border-b border-outline-variant p-5">

            <div>

                <h2 class="font-headline-md text-headline-md text-on-surface">
                    Subject Details
                </h2>

                <p class="mt-1 text-sm text-on-surface-variant">
                    View subject information
                </p>

            </div>

            <button type="button"
                id="closeViewSubjectModal"
                class="rounded-lg p-2 text-on-surface-variant hover:bg-surface-container">

                <span class="material-symbols-outlined">
                    close
                </span>

            </button>

        </div>


        <div class="p-5">

            <div class="flex items-center gap-4 pb-5">

                <div id="viewSubjectAvatar"></div>

                <div class="flex-1 min-w-0">

                    <div class="flex items-center justify-between gap-4 flex-wrap">

                        <h3 id="viewSubjectName"
                            class="text-lg font-semibold text-on-surface">
                            —
                        </h3>

                        <div id="viewSubjectStatus">
                            —
                        </div>

                    </div>

                    <p id="viewSubjectDescription"
                        class="mt-1 text-sm text-on-surface-variant">
                        —
                    </p>

                </div>

            </div>

        </div>


        <div class="flex justify-end border-t border-outline-variant p-5">

            <button type="button"
                id="closeViewSubjectButton"
                class="rounded-lg border border-outline-variant px-4 py-2 text-sm font-medium text-on-surface">
                Close
            </button>

        </div>

    </div>

</div>


<div id="toastNotification"
    class="fixed bottom-6 right-6 z-50 bg-inverse-surface text-inverse-on-surface px-4 py-3 rounded-lg shadow-lg flex items-center gap-3 translate-y-16 opacity-0 pointer-events-none transition-all duration-300">

    <span id="toastIcon"
        class="material-symbols-outlined text-secondary-fixed text-[20px]">
        check_circle
    </span>

    <span id="toastMessage"
        class="font-body-sm text-body-sm">
    </span>

</div>


<script>

(() => {

    const API_URL = '/api/v1/admin/subjects';

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


    const tableBody = $('subjectTableBody');
    const searchInput = $('searchInput');
    const statusFilter = $('statusFilter');
    const pagination = $('subjectPagination');
    const paginationInfo = $('subjectPaginationInfo');


    const modal = $('subjectModal');
    const form = $('subjectForm');
    const formId = $('formSubjectId');
    const formName = $('subjectName');
    const formCode = $('subjectCode');
    const formDescription = $('subjectDescription');
    const formStatus = $('subjectStatusToggle');
    const formError = $('subjectFormError');
    const modalTitle = $('subjectModalTitle');
    const modalSubtitle = $('subjectModalSubtitle');


    const viewModal = $('viewSubjectModal');
    const viewAvatar = $('viewSubjectAvatar');
    const viewName = $('viewSubjectName');
    const viewDescription = $('viewSubjectDescription');
    const viewStatus = $('viewSubjectStatus');


    const deleteModal = $('deleteSubjectModal');
    const deleteMessage = $('deleteSubjectMessage');
    const deleteButton = $('confirmDeleteSubjectButton');

    let allSubjects = [];
    let currentPage = 1;
    let lastPage = 1;
    let selectedSubjectId = null;
    let searchTimer;


    function logout() {

        localStorage.removeItem('student_diary_token');
        localStorage.removeItem('student_diary_user');
        localStorage.removeItem('student_diary_institute_code');

        window.location.replace('/');
    }


    async function loadSubjects(page = 1) {

        try {

            tableBody.innerHTML = `
                <tr>
                    <td colspan="5"
                        class="py-10 text-center text-on-surface-variant">
                        Loading subjects...
                    </td>
                </tr>`;


            const params = new URLSearchParams({ page });

            const search = searchInput.value.trim();
            const status = statusFilter.value;


            if (search) {
                params.set('search', search);
            }

            if (status !== 'all') {
                params.set('status', status);
            }


            const response = await fetch(
                `${API_URL}?${params}`,
                { headers }
            );


            if (response.status === 401) {
                return logout();
            }


            const result = await response.json();


            if (!response.ok || !result.status) {
                throw new Error(
                    result.message || 'Failed to load subjects.'
                );
            }


            allSubjects = Array.isArray(result.data)
                ? result.data
                : [];


            const meta = result.meta || {};

            currentPage = Number(
                meta.current_page || page
            );

            lastPage = Number(
                meta.last_page || 1
            );


            updateStatistics(result);
            renderSubjects();
            renderPagination(meta);


        } catch (error) {

            console.error(error);

            tableBody.innerHTML = `
                <tr>
                    <td colspan="5"
                        class="py-10 text-center text-error">
                        ${escapeHtml(error.message)}
                    </td>
                </tr>`;
        }
    }


    function updateStatistics(result) {

        const stats = result.statistics || {};

        const total = Number(stats.total || 0);
        const active = Number(stats.active || 0);
        const inactive = Number(stats.inactive || 0);

        const percentage = total
            ? ((active / total) * 100).toFixed(1)
            : '0.0';


        $('totalSubjects').textContent = total;
        $('activeSubjects').textContent = active;
        $('inactiveSubjects').textContent = inactive;

        $('activePercentage').innerHTML = `
            <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span>
            ${percentage}% active`;
    }


    function renderSubjects() {

    if (!allSubjects.length) {

        tableBody.innerHTML = `
            <tr>
                <td colspan="5"
                    class="py-10 text-center text-on-surface-variant">
                    No subjects found.
                </td>
            </tr>`;

        return;
    }

    tableBody.innerHTML = allSubjects.map((subject, index) => {

        const active = Number(subject.status) === 1;

        return `
            <tr>

                <td class="py-3 px-4 text-center">
                    ${((currentPage - 1) * 5) + index + 1}
                </td>

                <td class="py-3 px-10">

                    <div class="flex items-center gap-3">

                        <div class="w-9 h-9 rounded-lg bg-primary text-on-primary flex items-center justify-center font-semibold">
                            ${escapeHtml(getInitials(subject.name))}
                        </div>

                        <div class="font-medium text-on-surface">
                            ${escapeHtml(subject.name || '—')}
                        </div>

                    </div>

                </td>

                <td class="py-3 px-10">
                    <span class="font-medium text-on-surface">
                        ${escapeHtml(subject.code || '—')}
                    </span>
                </td>

                <td class="py-3 px-4 text-center">

                    <span class="inline-flex items-center gap-1.5 text-xs font-semibold ${active ? 'text-secondary' : 'text-outline'}">

                        <span class="w-1.5 h-1.5 rounded-full ${active ? 'bg-secondary' : 'bg-outline'}"></span>

                        ${active ? 'Active' : 'Inactive'}

                    </span>

                </td>

                <td class="py-3 px-4">

                    <div class="flex items-center justify-center gap-1">

                        <button type="button"
                            onclick="viewSubject(${subject.id})"
                            class="p-2 rounded-lg text-on-surface-variant hover:bg-surface-container"
                            title="View">

                            <span class="material-symbols-outlined text-[20px]">
                                visibility
                            </span>

                        </button>

                        <button type="button"
                            onclick="editSubject(${subject.id})"
                            class="p-2 rounded-lg text-on-surface-variant hover:bg-surface-container"
                            title="Edit">

                            <span class="material-symbols-outlined text-[20px]">
                                edit
                            </span>

                        </button>

                        <button type="button"
                            onclick="toggleSubjectStatus(${subject.id})"
                            class="p-2 rounded-lg text-on-surface-variant hover:bg-surface-container"
                            title="${active ? 'Deactivate' : 'Activate'}">

                            <span class="material-symbols-outlined text-[20px]">
                                ${active ? 'person_off' : 'how_to_reg'}
                            </span>

                        </button>

                        <button type="button"
                            onclick="deleteSubject(${subject.id})"
                            class="p-2 rounded-lg text-error hover:bg-red-50"
                            title="Delete">

                            <span class="material-symbols-outlined text-[20px]">
                                delete
                            </span>

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
            ? `Showing ${from}–${to} of ${total} subjects`
            : 'Showing 0 subjects';


        if (lastPage <= 1) {
            return;
        }


        const button = (
            text,
            disabled,
            action,
            active = false
        ) => {

            const el = document.createElement('button');

            el.type = 'button';
            el.innerHTML = text;
            el.disabled = disabled;

            el.className = `
                min-w-8 px-2 py-1.5 rounded-lg text-sm
                ${active
                    ? 'bg-primary text-on-primary'
                    : 'text-on-surface hover:bg-surface-container'}
                disabled:opacity-40`;

            el.onclick = action;

            pagination.appendChild(el);
        };


        button(
            '<span class="material-symbols-outlined text-[18px]">chevron_left</span>',
            currentPage === 1,
            () => loadSubjects(currentPage - 1)
        );


        for (let page = 1; page <= lastPage; page++) {

            button(
                page,
                false,
                () => loadSubjects(page),
                page === currentPage
            );
        }


        button(
            '<span class="material-symbols-outlined text-[18px]">chevron_right</span>',
            currentPage === lastPage,
            () => loadSubjects(currentPage + 1)
        );
    }


    searchInput.addEventListener('input', () => {

        clearTimeout(searchTimer);

        searchTimer = setTimeout(() => {
            loadSubjects(1);
        }, 300);

    });


    statusFilter.addEventListener('change', () => {
        loadSubjects(1);
    });


    $('openModalBtn').addEventListener('click', () => {

        form.reset();

        formId.value = '';
        formStatus.checked = true;

        modalTitle.textContent = 'Add New Subject';

        modalSubtitle.textContent =
            'Create a new subject.';

        $('saveSubjectText').textContent =
            'Save Subject';

        formError.classList.add('hidden');
        formError.textContent = '';

        modal.classList.remove('hidden');

        document.body.classList.add('overflow-hidden');
    });


    function closeModal() {

        modal.classList.add('hidden');

        document.body.classList.remove('overflow-hidden');

        formError.classList.add('hidden');
        formError.textContent = '';
    }


    $('closeSubjectModalBtn')
        .addEventListener('click', closeModal);

    $('cancelSubjectModalBtn')
        .addEventListener('click', closeModal);


    modal.addEventListener('click', event => {

        if (event.target === modal) {
            closeModal();
        }

    });


    window.editSubject = async id => {

        try {

            const response = await fetch(
                `${API_URL}/${id}`,
                { headers }
            );


            if (response.status === 401) {
                return logout();
            }


            const result = await response.json();


            if (!response.ok || !result.status) {
                throw new Error(
                    result.message || 'Unable to load subject.'
                );
            }


            const subject = result.data;


            formId.value = subject.id;

            formName.value =
                subject.name || '';
            
            formCode.value =
                subject.code || '';

            formDescription.value =
                subject.description || '';

            formStatus.checked =
                Number(subject.status) === 1;


            modalTitle.textContent =
                'Edit Subject';

            modalSubtitle.textContent =
                'Update subject information.';

            $('saveSubjectText').textContent =
                'Update Subject';


            formError.classList.add('hidden');
            formError.textContent = '';


            modal.classList.remove('hidden');

            document.body.classList.add('overflow-hidden');


        } catch (error) {

            console.error(error);

            showToast(error.message, 'error');
        }
    };


    form.addEventListener('submit', async event => {

        event.preventDefault();


        formError.classList.add('hidden');
        formError.textContent = '';


        const id = formId.value || '';
        const editing = Boolean(id);


        const payload = {

            name: formName.value.trim(),
            code: formCode.value.trim(),
            description:
                formDescription.value.trim() || null,

            status:
                formStatus.checked ? 1 : 0
        };


        const button = $('saveSubjectBtn');
        const buttonText = $('saveSubjectText');


        button.disabled = true;

        buttonText.textContent =
            editing
                ? 'Updating...'
                : 'Creating...';


        try {

            const response = await fetch(

                editing
                    ? `${API_URL}/${id}`
                    : API_URL,

                {

                    method:
                        editing
                            ? 'PUT'
                            : 'POST',

                    headers: {
                        ...headers,
                        'Content-Type':
                            'application/json'
                    },

                    body:
                        JSON.stringify(payload)
                }
            );


            if (response.status === 401) {

                logout();
                return;
            }


            const result =
                await response.json();


            if (!response.ok || !result.status) {

                throw new Error(
                    result.message ||
                    'Unable to save subject.'
                );
            }


            closeModal();

            form.reset();

            formId.value = '';

            formStatus.checked = true;


            await loadSubjects(currentPage);


            showToast(
                result.message ||
                (
                    editing
                        ? 'Subject updated successfully.'
                        : 'Subject created successfully.'
                )
            );


        } catch (error) {

            console.error(error);

            formError.textContent =
                error.message;

            formError.classList.remove('hidden');


        } finally {

            button.disabled = false;

            buttonText.textContent =
                editing
                    ? 'Update Subject'
                    : 'Save Subject';
        }

    });


    window.viewSubject = async id => {

        viewModal.classList.remove('hidden');

        document.body.classList.add('overflow-hidden');


        viewName.textContent = 'Loading...';
        viewDescription.textContent = 'Loading...';
        viewStatus.innerHTML = 'Loading...';


        try {

            const response = await fetch(
                `${API_URL}/${id}`,
                { headers }
            );


            if (response.status === 401) {
                return logout();
            }


            const result =
                await response.json();


            if (!response.ok || !result.status) {

                throw new Error(
                    result.message ||
                    'Unable to load subject.'
                );
            }


            const subject = result.data;

            const active =
                Number(subject.status) === 1;


            viewName.textContent =
                subject.name || '—';


            viewDescription.textContent =
                subject.description || 'No description available.';


            viewStatus.innerHTML = `
                <span class="inline-flex items-center gap-1.5 text-xs font-semibold ${active ? 'text-secondary' : 'text-outline'}">

                    <span class="w-1.5 h-1.5 rounded-full ${active ? 'bg-secondary' : 'bg-outline'}"></span>

                    ${active ? 'Active' : 'Inactive'}

                </span>`;


            viewAvatar.innerHTML = `
                <div class="w-16 h-16 rounded-lg bg-primary text-on-primary flex items-center justify-center font-semibold text-xl">
                    ${escapeHtml(getInitials(subject.name))}
                </div>`;


        } catch (error) {

            console.error(error);

            viewDescription.textContent =
                error.message;
        }
    };


    function closeViewModal() {

        viewModal.classList.add('hidden');

        document.body.classList.remove('overflow-hidden');
    }


    $('closeViewSubjectModal')
        .addEventListener('click', closeViewModal);

    $('closeViewSubjectButton')
        .addEventListener('click', closeViewModal);


    viewModal.addEventListener('click', event => {

        if (event.target === viewModal) {
            closeViewModal();
        }

    });


    window.toggleSubjectStatus = async id => {

        try {

            const response = await fetch(
                `${API_URL}/${id}/status`,
                {
                    method: 'PATCH',
                    headers
                }
            );


            if (response.status === 401) {
                return logout();
            }


            const result =
                await response.json();


            if (!response.ok || !result.status) {

                throw new Error(
                    result.message ||
                    'Unable to update subject status.'
                );
            }


            showToast(
                result.message ||
                'Subject status updated successfully.'
            );


            await loadSubjects(currentPage);


        } catch (error) {

            console.error(error);

            showToast(
                error.message,
                'error'
            );
        }
    };

    window.deleteSubject = async id => {
        selectedSubjectId = id;
        deleteMessage.className =
            'rounded-lg bg-amber-50 p-4 text-sm text-amber-700';
        deleteMessage.textContent =
            'Checking subject records...';
        deleteButton.classList.add('hidden');
        deleteModal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
        try {
            const response = await fetch(
                `${API_URL}/${id}`,
                { headers }
            );
            if (response.status === 401) {
                return logout();
            }
            const result = await response.json();
            if (!response.ok || !result.status) {
                throw new Error(
                    result.message || 'Unable to load subject.'
                );
            }
            const subject = result.data;
            const classNames = Array.isArray(subject.class_names)
                ? subject.class_names
                : [];
            const hasClasses = classNames.length > 0;
            const hasTeacherAssignments =
                Number(subject.teacher_assignments_count || 0) > 0;
            if (hasClasses) {
                deleteMessage.className =
                    'rounded-lg bg-red-50 p-4 text-sm text-red-700';
                deleteMessage.innerHTML = `
                    <strong>You cannot delete this subject.</strong>
                    <br>
                    It is assigned to:
                    <strong>${classNames.map(escapeHtml).join(', ')}</strong>.
                `;
                return;
            }
            if (hasTeacherAssignments) {
                deleteMessage.className =
                    'rounded-lg bg-red-50 p-4 text-sm text-red-700';
                deleteMessage.innerHTML = `
                    <strong>You cannot delete this subject.</strong>
                    <br>
                    It has teacher assignments.
                `;
                return;
            }
            deleteMessage.className =
                'rounded-lg bg-red-50 p-4 text-sm text-red-700';
            deleteMessage.innerHTML = `
                Are you sure you want to delete
                <strong>${escapeHtml(subject.name)}</strong>?
                This action cannot be undone.
            `;
            deleteButton.classList.remove('hidden');
        } catch (error) {
            console.error(error);
            deleteMessage.className =
                'rounded-lg bg-red-50 p-4 text-sm text-red-700';
            deleteMessage.textContent =
                error.message;
        }
    };
    deleteButton.addEventListener(
        'click',
        deleteSubjectAction
    );

    async function deleteSubjectAction() {

    if (!selectedSubjectId) {
        return;
    }

    const id = selectedSubjectId;

    deleteButton.disabled = true;
    deleteButton.textContent = 'Deleting...';

    try {

        const response = await fetch(
            `${API_URL}/${id}`,
            {
                method: 'DELETE',
                headers
            }
        );

        if (response.status === 401) {
            return logout();
        }

        const result = await response.json();

        if (!response.ok || !result.status) {

            deleteMessage.className =
                'rounded-lg bg-red-50 p-4 text-sm text-red-700';

            deleteMessage.textContent =
                result.message || 'Subject cannot be deleted.';

            return;
        }

        closeDeleteModal();

        showToast(
            result.message || 'Subject deleted successfully.'
        );

        await loadSubjects(currentPage);

    } catch (error) {

        console.error(error);

        deleteMessage.className =
            'rounded-lg bg-red-50 p-4 text-sm text-red-700';

        deleteMessage.textContent =
            error.message;

    } finally {

        deleteButton.disabled = false;
        deleteButton.textContent = 'Delete Subject';
    }
}
    function closeDeleteModal() {
        deleteModal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
        selectedSubjectId = null;
        deleteButton.disabled = false;
        deleteButton.textContent = 'Delete Subject';
    }

    $('cancelDeleteSubjectButton')
    .addEventListener('click', closeDeleteModal);

    function showToast(
        message,
        icon = 'check_circle'
    ) {

        const toast =
            $('toastNotification');


        $('toastMessage').textContent =
            message;

        $('toastIcon').textContent =
            icon;


        toast.classList.remove(
            'translate-y-16',
            'opacity-0',
            'pointer-events-none'
        );


        toast.classList.add(
            'translate-y-0',
            'opacity-100'
        );


        setTimeout(() => {

            toast.classList.add(
                'translate-y-16',
                'opacity-0',
                'pointer-events-none'
            );

            toast.classList.remove(
                'translate-y-0',
                'opacity-100'
            );

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


    loadSubjects();

})();

</script>

@endsection