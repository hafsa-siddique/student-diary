@extends('layouts.admin')

@section('title', 'Teacher Directory')

@section('content')

<div class="flex flex-col gap-space-lg w-full">

    <div class="flex flex-col gap-1">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-space-md mt-2">
            <div>
                <h1 class="font-headline-lg text-headline-lg text-on-surface tracking-tight">
                    Teachers
                </h1>
                <p class="font-body-md text-body-md text-on-surface-variant mt-0.5">
                    Manage teachers belonging to your institute and monitor faculty assignment status.
                </p>
            </div>

            <button
                type="button"
                id="openModalBtn"
                class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-primary-container text-on-primary hover:bg-primary transition-all rounded-lg shadow-sm font-label-lg text-label-lg active:scale-[0.98]">
                <span class="material-symbols-outlined text-[20px]">add</span>
                <span>Add Teacher</span>
            </button>
        </div>
    </div>

    <div class="space-y-space-md">
 
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

            <div class="bg-surface-container-lowest p-space-md rounded-xl shadow-sm flex items-center justify-between">
                <div class="flex flex-col">
                    <span class="font-label-sm text-label-sm text-outline uppercase tracking-wider">
                        Total Faculty
                    </span>
                    <span id="totalFaculty" class="font-display-lg text-display-lg text-on-surface mt-1 font-tabular-numeric">
                        —
                    </span>
                    <span class="font-body-sm text-body-sm text-primary flex items-center gap-1 mt-0.5">
                        <span class="material-symbols-outlined text-[16px]">groups</span>
                        All institute teachers
                    </span>
                </div>

                <div class="w-12 h-12 rounded-xl bg-surface-container flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined text-[26px]">groups</span>
                </div>
            </div>

            <div class="bg-surface-container-lowest p-space-md rounded-xl shadow-sm flex items-center justify-between">
                <div class="flex flex-col">
                    <span class="font-label-sm text-label-sm text-outline uppercase tracking-wider">
                        Active Staff
                    </span>
                    <span id="activeStaff" class="font-display-lg text-display-lg text-secondary mt-1 font-tabular-numeric">
                        —
                    </span>
                    <span id="activePercentage" class="font-body-sm text-body-sm text-on-surface-variant flex items-center gap-1 mt-0.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span>
                        Loading...
                    </span>
                </div>

                <div class="w-12 h-12 rounded-xl bg-surface-container flex items-center justify-center text-secondary">
                    <span class="material-symbols-outlined text-[26px]">how_to_reg</span>
                </div>
            </div>

            <div class="bg-surface-container-lowest p-space-md rounded-xl shadow-sm flex items-center justify-between">
                <div class="flex flex-col">
                    <span class="font-label-sm text-label-sm text-outline uppercase tracking-wider">
                        Inactive Staff
                    </span>
                    <span id="inactiveStaff" class="font-display-lg text-display-lg text-tertiary mt-1 font-tabular-numeric">
                        —
                    </span>
                    <span class="font-body-sm text-body-sm text-on-surface-variant flex items-center gap-1 mt-0.5">
                        <span class="material-symbols-outlined text-[16px]">person_off</span>
                        Inactive accounts
                    </span>
                </div>

                <div class="w-12 h-12 rounded-xl bg-tertiary-fixed flex items-center justify-center text-tertiary">
                    <span class="material-symbols-outlined text-[26px]">person_off</span>
                </div>
            </div>

            <div class="bg-surface-container-lowest p-space-md rounded-xl shadow-sm flex items-center justify-between">
                <div class="flex flex-col">
                    <span class="font-label-sm text-label-sm text-outline uppercase tracking-wider">
                        Current Assignments
                    </span>
                    <span id="assignmentCount" class="font-display-lg text-display-lg text-on-surface mt-1 font-tabular-numeric">
                        —
                    </span>
                    <span id="currentSessionName" class="font-body-sm text-body-sm text-on-surface-variant mt-0.5">
                        Loading session...
                    </span>
                </div>

                <div class="w-12 h-12 rounded-xl bg-surface-container flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined text-[26px]">menu_book</span>
                </div>
            </div>

        </div>

        <div class="bg-surface-container-lowest p-space-md rounded-xl shadow-sm flex flex-col lg:flex-row items-stretch lg:items-center justify-between gap-space-md">

            <div class="flex flex-1 flex-col sm:flex-row items-stretch sm:items-center gap-3">

                <div class="relative flex-1 min-w-[280px]">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[20px]">
                        search
                    </span>

                    <input
                        type="text"
                        id="searchInput"
                        class="w-full h-10 pl-10 pr-4 rounded-lg bg-surface text-on-surface font-body-sm text-body-sm placeholder:text-outline focus:outline-none focus:bg-surface-container-lowest focus:shadow-sm transition-all"
                        placeholder="Search teachers by name, email or employee code...">
                </div>

                <div class="relative">
                    <select
                        id="statusFilter"
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
                            <th class="py-3 px-10">Teacher</th>
                            <th class="py-3 px-4">Employee Code</th>
                            <th class="py-3 px-4">Contact Info</th>
                            <th class="py-3.5 px-4 text-center">Assignments</th>
                            <th class="py-3 px-4 text-center">Status</th>
                            <th class="py-3 px-4 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody
                        id="teacherTableBody"
                        class="divide-y divide-surface-container font-body-md text-body-md text-on-surface">
                        <tr>
                            <td colspan="7" class="py-10 text-center text-on-surface-variant">
                                <div class="flex items-center justify-center gap-2">
                                    <span class="material-symbols-outlined animate-spin text-[22px]">
                                        progress_activity
                                    </span>
                                    Loading teachers...
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="p-space-md bg-surface-container-lowest flex flex-col sm:flex-row items-center justify-between gap-space-md border-t border-surface-container">

                <div
                    id="teacherPaginationInfo"
                    class="font-body-sm text-body-sm text-on-surface-variant">
                    Loading...
                </div>

                <div
                    id="teacherPagination"
                    class="flex items-center gap-1 font-label-md text-label-md">
                </div>

            </div>

        </div>

    </div>
</div>

<div id="teacherModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
    <div class="w-full max-w-3xl max-h-[90vh] overflow-hidden rounded-2xl bg-surface-container-lowest shadow-xl flex flex-col">

        <div class="flex items-center justify-between border-b border-outline-variant p-5 shrink-0">
            <div>
                <h2 id="modalTitle" class="font-headline-md text-headline-md text-on-surface">Add New Teacher</h2>
                <p id="modalSubtitle" class="mt-1 text-sm text-on-surface-variant">Register a teaching faculty member for this institute.</p>
            </div>
            <button type="button" id="closeModalBtn" class="rounded-lg p-2 text-on-surface-variant hover:bg-surface-container" aria-label="Close modal">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <form id="teacherForm" class="flex flex-col min-h-0">
            <input type="hidden" id="formTeacherId">

            <div class="grid grid-cols-1 gap-4 p-5 sm:grid-cols-2 overflow-y-auto">
                <div class="sm:col-span-2">
                    <label for="formName" class="mb-1 block text-sm font-medium text-on-surface">Teacher Full Name <span class="text-error">*</span></label>
                    <input type="text" id="formName" class="w-full rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface placeholder:text-outline focus:outline-none" placeholder="Teacher full name" required>
                </div>

                <div>
                    <label for="formCode" class="mb-1 block text-sm font-medium text-on-surface">Employee Code <span class="text-error">*</span></label>
                    <input type="text" id="formCode" class="w-full rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface placeholder:text-outline focus:outline-none" placeholder="Generating..." required readonly>
                </div>

                <div>
                    <label for="formPhone" class="mb-1 block text-sm font-medium text-on-surface">Phone <span class="text-error">*</span></label>
                    <input type="text" id="formPhone" class="w-full rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface placeholder:text-outline focus:outline-none" placeholder="+92 300 1234567" required>
                </div>

                <div class="sm:col-span-2">
                    <label for="formEmail" class="mb-1 block text-sm font-medium text-on-surface">Email <span class="text-error">*</span></label>
                    <input type="email" id="formEmail" class="w-full rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface placeholder:text-outline focus:outline-none" placeholder="teacher@example.com" required>
                </div>

                <div>
                    <label for="formPassword" class="mb-1 block text-sm font-medium text-on-surface">Password <span id="passwordRequired" class="text-error">*</span></label>
                    <input type="password" id="formPassword" class="w-full rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface placeholder:text-outline focus:outline-none" placeholder="Temporary password">
                </div>

                <div>
                    <label for="formConfirmPassword" class="mb-1 block text-sm font-medium text-on-surface">Confirm Password <span id="confirmPasswordRequired" class="text-error">*</span></label>
                    <input type="password" id="formConfirmPassword" class="w-full rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface placeholder:text-outline focus:outline-none" placeholder="Confirm password">
                </div>

                <div class="sm:col-span-2 flex items-center justify-between rounded-lg bg-surface-container-low p-3">
                    <div>
                        <span class="text-sm font-semibold text-on-surface">Account Status</span>
                        <span class="mt-0.5 block text-sm text-on-surface-variant">Allow teacher access to the system.</span>
                    </div>
                    <label class="relative inline-flex cursor-pointer items-center">
                        <input type="checkbox" id="formStatusToggle" class="sr-only peer" checked>
                        <div class="h-6 w-11 rounded-full bg-outline after:absolute after:left-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:bg-white after:transition-all after:content-[''] peer-checked:bg-primary peer-checked:after:translate-x-full"></div>
                    </label>
                </div>

            </div>

            <div id="formError" class="hidden mx-5 mb-4 rounded-lg bg-red-50 p-3 text-sm text-red-700" role="alert"></div>

            <div class="flex justify-end gap-3 border-t border-outline-variant bg-surface-container-lowest p-5 shrink-0">
                <button type="button" id="cancelModalBtn" class="rounded-lg border border-outline-variant px-4 py-2 text-sm font-medium text-on-surface hover:bg-surface-container">Cancel</button>
                <button type="submit" id="saveTeacherBtn" class="rounded-lg bg-primary px-5 py-2 text-sm font-semibold text-white hover:opacity-90">
                    <span id="saveTeacherText">Save Teacher</span>
                </button>
            </div>
        </form>

    </div>
</div>

<div id="viewTeacherModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
    <div class="w-full max-w-lg rounded-2xl bg-surface-container-lowest shadow-xl">
        <div class="flex items-center justify-between border-b border-outline-variant p-5">
            <div>
                <h2 class="font-headline-md text-headline-md text-on-surface">Teacher Details</h2>
                <p class="mt-1 text-sm text-on-surface-variant">View teacher information</p>
            </div>
            <button type="button" id="closeViewTeacherModal" class="rounded-lg p-2 text-on-surface-variant hover:bg-surface-container">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

    <div class="p-5">
        <div class="flex items-center gap-4 pb-5">
            <div id="viewTeacherAvatar"></div>
            <div class="flex-1 min-w-0">
                <div class="flex items-center justify-between gap-4 flex-wrap">
                    <h3 id="viewTeacherName" class="text-lg font-semibold text-on-surface">—</h3>
                    <div id="viewTeacherStatus">—</div>
                </div>
                <p id="viewTeacherCode" class="mt-1 text-sm text-on-surface-variant">—</p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="rounded-lg bg-surface-container-low p-4">
                <p class="text-xs text-on-surface-variant">Email</p>
                <p id="viewTeacherEmail" class="mt-1 font-medium text-on-surface">—</p>
            </div>

            <div class="rounded-lg bg-surface-container-low p-4">
                <p class="text-xs text-on-surface-variant">Phone No</p>
                <p id="viewTeacherPhone" class="mt-1 font-medium text-on-surface">—</p>
            </div>

            <div class="rounded-lg bg-surface-container-low p-4 sm:col-span-2">
                <p class="text-xs text-on-surface-variant">Assignments</p>
                <div id="viewTeacherAssignments" class="space-y-3 mt-2"></div>
            </div>
        </div>
    </div>

    <div class="flex justify-end border-t border-outline-variant p-5">
        <button type="button" id="closeViewTeacherButton"
            class="rounded-lg border border-outline-variant px-4 py-2 text-sm font-medium text-on-surface">
            Close
        </button>
    </div>
</div>

</div>

<div
    id="deleteTeacherModal"
    class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4"
    role="dialog"
    aria-modal="true"
    aria-labelledby="deleteTeacherModalTitle"
>
    <div class="w-full max-w-md rounded-2xl bg-surface-container-lowest shadow-xl">

    <!-- Header -->
    <div class="flex items-center justify-between border-b border-outline-variant p-5">
        <div>
            <h2
                id="deleteTeacherModalTitle"
                class="font-headline-md text-headline-md text-on-surface"
            >
                Delete Teacher
            </h2>

            <p
                id="deleteTeacherModalSubtitle"
                class="mt-1 text-sm text-on-surface-variant"
            >
                Confirm this action.
            </p>
        </div>

        <button
            type="button"
            id="closeDeleteTeacherModal"
            class="rounded-lg p-2 text-on-surface-variant hover:bg-surface-container"
            aria-label="Close modal"
        >
            <span class="material-symbols-outlined">close</span>
        </button>
    </div>

    <!-- Body -->
    <div class="p-5">
        <div
            id="deleteTeacherMessage"
            class="rounded-lg bg-red-50 p-4 text-sm text-red-700"
        >
            Checking teachers assignments...
        </div>
    </div>

    <!-- Actions -->
    <div class="flex justify-end gap-3 border-t border-outline-variant p-5">

        <button
            type="button"
            id="cancelDeleteTeacher"
            class="rounded-lg border border-outline-variant px-4 py-2 text-sm font-medium text-on-surface hover:bg-surface-container"
        >
            Cancel
        </button>

        <button
            type="button"
            id="confirmDeleteTeacher"
            class="hidden rounded-lg bg-red-600 px-5 py-2 text-sm font-semibold text-white hover:bg-red-700"
        >
            Delete Teacher
        </button>

        <button
            type="button"
            id="confirmDeactivateTeacher"
            class="hidden rounded-lg bg-primary px-5 py-2 text-sm font-semibold text-white hover:opacity-90"
        >
            Deactivate Teacher
        </button>

    </div>
</div>

</div>

<div
    id="toastNotification"
    class="fixed bottom-6 right-6 z-50 bg-inverse-surface text-inverse-on-surface px-4 py-3 rounded-lg shadow-lg flex items-center gap-3 translate-y-16 opacity-0 pointer-events-none transition-all duration-300">

    <span id="toastIcon" class="material-symbols-outlined text-secondary-fixed text-[20px]">
        check_circle
    </span>

    <span id="toastMessage" class="font-body-sm text-body-sm">
        Operation completed successfully.
    </span>

</div>



<script>
(() => {
    const API_URL = '/api/v1/admin/teachers';
    const token = localStorage.getItem('student_diary_token');

    const headers = {
        Accept: 'application/json',
        Authorization: `Bearer ${token}`
    };
    async function apiRequest(url, options = {}) {
    const response = await fetch(url, {
        ...options,
        headers: {
            ...headers,
            ...(options.headers || {})
        }
    });

    // Token expired / unauthenticated
    if (response.status === 401) {
        logout();
        return;
    }

    const result = await response.json();

    // Laravel validation or API error
    if (!response.ok || result.status === false) {
        if (result.errors) {
            throw new Error(
                Object.values(result.errors)
                    .flat()
                    .join(' ')
            );
        }

        throw new Error(
            result.message || 'Something went wrong.'
        );
    }

    return result;
}
    const tableBody = document.getElementById('teacherTableBody');
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');

    const totalFaculty = document.getElementById('totalFaculty');
    const activeStaff = document.getElementById('activeStaff');
    const inactiveStaff = document.getElementById('inactiveStaff');
    const activePercentage = document.getElementById('activePercentage');
    const assignmentCount = document.getElementById('assignmentCount');
    const currentSessionName = document.getElementById('currentSessionName');

    const pagination = document.getElementById('teacherPagination');
    const paginationInfo = document.getElementById('teacherPaginationInfo');

    const modal = document.getElementById('teacherModal');
    const form = document.getElementById('teacherForm');

    const formId = document.getElementById('formTeacherId');
    const formName = document.getElementById('formName');
    const formCode = document.getElementById('formCode');
    const formEmail = document.getElementById('formEmail');
    const formPhone = document.getElementById('formPhone');
    const formPassword = document.getElementById('formPassword');
    const formConfirmPassword = document.getElementById('formConfirmPassword');
    const formStatus = document.getElementById('formStatusToggle');
    const formError = document.getElementById('formError');

    const viewTeacherModal = document.getElementById('viewTeacherModal');
    const closeViewTeacherModalButton =document.getElementById('closeViewTeacherModal');
    const closeViewTeacherButton =document.getElementById('closeViewTeacherButton');
    const viewTeacherAvatar = document.getElementById('viewTeacherAvatar');
    const viewTeacherName = document.getElementById('viewTeacherName');
    const viewTeacherCode = document.getElementById('viewTeacherCode');
    const viewTeacherEmail = document.getElementById('viewTeacherEmail');
    const viewTeacherPhone = document.getElementById('viewTeacherPhone');
    const viewTeacherStatus = document.getElementById('viewTeacherStatus');
    const viewTeacherAssignments = document.getElementById('viewTeacherAssignments');

    const deleteTeacherModal = document.getElementById('deleteTeacherModal');
    const closeDeleteTeacherModalButton = document.getElementById('closeDeleteTeacherModal');
    const cancelDeleteTeacherButton = document.getElementById('cancelDeleteTeacher');
    const confirmDeleteTeacherButton = document.getElementById('confirmDeleteTeacher');
    const confirmDeactivateTeacherButton = document.getElementById('confirmDeactivateTeacher');
    const deleteTeacherMessage = document.getElementById('deleteTeacherMessage');

    let allTeachers = [];
    let searchTimer;
    let currentPage = 1;
    let lastPage = 1;
    let selectedTeacherId = null;

    if (!token) {
        window.location.replace('/');
        return;
    }

    function logout() {
        localStorage.removeItem('student_diary_token');
        localStorage.removeItem('student_diary_user');
        localStorage.removeItem('student_diary_institute_code');
        window.location.replace('/');
    }

    async function loadNextEmployeeCode() {
        formCode.value = 'Loading...';
        formCode.readOnly = true;

        try {
            const response = await fetch('/api/v1/admin/teachers/next-code', {
                headers
            });
            if (response.status === 401) {
                logout();
                return;
            }
            const result = await response.json();
            if (!response.ok || !result.status) {
                throw new Error(result.message || 'Unable to generate employee code.');
            }
            formCode.value = result.employee_code;
        } catch (error) {
            formCode.value = '';
            formCode.readOnly = false;
            showToast(error.message, 'error');
        }
    }
    async function loadTeachers(page = 1) {
    tableBody.innerHTML = `
        <tr>
            <td colspan="7" class="px-6 py-10 text-center text-on-surface-variant">
                Loading teachers...
            </td>
        </tr>
    `;

    try {
        const params = new URLSearchParams();
        params.set('page', page);

        const search = searchInput.value.trim();
        const status = statusFilter.value;

        if (search) {
            params.set('search', search);
        }

        if (status !== 'all') {
            params.set('status', status);
        }

        const result = await apiRequest(
            `${API_URL}?${params.toString()}`
        );

        allTeachers = Array.isArray(result.data)
            ? result.data
            : [];

        const meta = result.meta || {};

        currentPage = Number(meta.current_page || page);
        lastPage = Number(meta.last_page || 1);

        updateStatistics(result);
        renderTeachers();
        renderPagination(meta);

    } catch (error) {
        console.error('Teacher loading error:', error);

        tableBody.innerHTML = `
            <tr>
                <td colspan="7" class="px-6 py-10 text-center text-red-500">
                    ${escapeHtml(error.message || 'Failed to load teachers.')}
                </td>
            </tr>
        `;
    }
}

    function updateStatistics(result) {
    const statistics = result.statistics ?? {};

    const total = Number(statistics.total_faculty ?? 0);
    const active = Number(statistics.active_staff ?? 0);
    const inactive = Number(statistics.inactive_staff ?? 0);

    totalFaculty.textContent = total;
    activeStaff.textContent = active;
    inactiveStaff.textContent = inactive;

    const percentage = total
        ? ((active / total) * 100).toFixed(1)
        : '0.0';

    activePercentage.innerHTML = `
        <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span>
        ${percentage}% operational
    `;

    assignmentCount.textContent =
        statistics.assignment_count ?? 0;

    currentSessionName.textContent =
        result.current_session?.name ?? 'No active session';
}
    
    function renderTeachers() {
    if (!allTeachers.length) {
        tableBody.innerHTML = `
            <tr>
                <td colspan="7" class="py-12 text-center text-on-surface-variant">
                    <div class="flex flex-col items-center gap-2">
                        <span class="material-symbols-outlined text-[34px]">
                            person_search
                        </span>
                        <span>No teachers found.</span>
                    </div>
                </td>
            </tr>
        `;
        return;
    }

    tableBody.innerHTML = allTeachers.map((teacher, index) => {
        const rowNumber = ((currentPage - 1) * 5) + index + 1;
        const active = Number(teacher.status) === 1;

        const name = teacher.name || 'Unknown Teacher';
        const email = teacher.email || '—';
        const phone = teacher.phone || '—';
        const code = teacher.employee_code || '—';

        const teacherAssignments =
            Number(teacher.current_assignment_count ?? 0);

        const initials = getInitials(name);

        const avatar = teacher.profile_picture
            ? `
                <img
                    src="${getProfilePictureUrl(teacher.profile_picture)}"
                    alt="${escapeHtml(name)}"
                    class="w-9 h-9 rounded-full object-cover">
            `
            : `
                <div class="w-9 h-9 rounded-full bg-primary text-on-primary flex items-center justify-center font-semibold">
                    ${escapeHtml(initials)}
                </div>
            `;

        return `
            <tr class="hover:bg-surface-container-low transition-colors">
                <td class="py-3.5 px-4 text-center">
                    ${rowNumber}
                </td>

                <td class="py-3.5 px-4">
                    <div class="flex items-center gap-3">
                        ${avatar}

                        <div class="min-w-0">
                            <div class="font-semibold text-on-surface truncate">
                                ${escapeHtml(name)}
                            </div>

                            <div class="text-xs text-on-surface-variant">
                                Teacher
                            </div>
                        </div>
                    </div>
                </td>

                <td class="py-3.5 px-4">
                    <span class="bg-surface-container px-2 py-1 rounded font-semibold">
                        ${escapeHtml(code)}
                    </span>
                </td>

                <td class="py-3.5 px-4">
                    <div>
                        <div class="text-sm">
                            ${escapeHtml(email)}
                        </div>

                        <div class="text-xs text-outline">
                            ${escapeHtml(phone)}
                        </div>
                    </div>
                </td>

                <td class="py-3.5 px-2 text-center">
                    <span class="inline-flex items-center justify-center min-w-8 px-2.5 py-1 rounded-full bg-surface-container text-sm font-semibold text-on-surface">
                        ${teacherAssignments}
                    </span>
                </td>

                <td class="py-3.5 px-4 text-center">
                    ${
                        active
                            ? `
                                <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded-full text-xs font-semibold text-secondary">
                                    <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span>
                                    Active
                                </span>
                            `
                            : `
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold text-outline">
                                    <span class="w-1.5 h-1.5 rounded-full bg-outline"></span>
                                    Inactive
                                </span>
                            `
                    }
                </td>

                <td class="py-3.5 px-4 text-right">
                    <button
                        type="button"
                        onclick="viewTeacher(${teacher.id})"
                        class="p-2 rounded-lg text-on-surface-variant hover:bg-surface-container"
                        title="View">
                        <span class="material-symbols-outlined text-[20px]">
                            visibility
                        </span>
                    </button>

                    <button
                        type="button"
                        onclick="editTeacher(${teacher.id})"
                        class="p-1.5 rounded hover:bg-surface-container text-outline hover:text-primary"
                        title="Edit">
                        <span class="material-symbols-outlined text-[18px]">
                            edit
                        </span>
                    </button>

                    <button
                        type="button"
                        onclick="toggleTeacherStatus(${teacher.id})"
                        class="p-2 rounded-lg text-on-surface-variant hover:bg-surface-container"
                        title="${active ? 'Deactivate' : 'Activate'}">
                        <span class="material-symbols-outlined text-[20px]">
                            ${active ? 'person_off' : 'how_to_reg'}
                        </span>
                    </button>

                    <button
                        type="button"
                        onclick="deleteTeacher(${teacher.id})"
                        class="p-2 rounded-lg text-error hover:bg-red-50"
                        title="Delete">
                        <span class="material-symbols-outlined text-[18px]">
                            delete
                        </span>
                    </button>
                </td>
            </tr>
        `;
    }).join('');
}
    function renderPagination(meta) {
    const from = Number(meta?.from || 0);
    const to = Number(meta?.to || 0);
    const total = Number(meta?.total || 0);

    paginationInfo.textContent = total
        ? `Showing ${from} - ${to} of ${total} teachers`
        : 'No teachers found';

    pagination.innerHTML = '';

    if (lastPage <= 1) {
        return;
    }

    const previousButton = document.createElement('button');

    previousButton.type = 'button';
    previousButton.textContent = '‹';
    previousButton.disabled = currentPage === 1;

    previousButton.className =
        `h-9 min-w-9 rounded-lg px-3 text-sm font-semibold ${
            currentPage === 1
                ? 'text-outline cursor-not-allowed'
                : 'text-on-surface-variant hover:bg-surface-container'
        }`;

    previousButton.addEventListener('click', () => {
        if (currentPage > 1) {
            loadTeachers(currentPage - 1);
        }
    });

    pagination.appendChild(previousButton);

    for (let page = 1; page <= lastPage; page++) {
        const button = document.createElement('button');

        button.type = 'button';
        button.textContent = page;

        button.className = page === currentPage
            ? 'h-9 min-w-9 rounded-lg bg-primary px-3 text-sm font-semibold text-white'
            : 'h-9 min-w-9 rounded-lg px-3 text-sm text-on-surface-variant hover:bg-surface-container';

        button.addEventListener('click', () => {
            loadTeachers(page);
        });

        pagination.appendChild(button);
    }

    const nextButton = document.createElement('button');

    nextButton.type = 'button';
    nextButton.textContent = '›';
    nextButton.disabled = currentPage === lastPage;

    nextButton.className =
        `h-9 min-w-9 rounded-lg px-3 text-sm font-semibold ${
            currentPage === lastPage
                ? 'text-outline cursor-not-allowed'
                : 'text-on-surface-variant hover:bg-surface-container'
        }`;

    nextButton.addEventListener('click', () => {
        if (currentPage < lastPage) {
            loadTeachers(currentPage + 1);
        }
    });

    pagination.appendChild(nextButton);
}
    searchInput.addEventListener('input', function () {
        clearTimeout(searchTimer);

        searchTimer = setTimeout(() => {
            loadTeachers(1);
        }, 300);
    });

    statusFilter.addEventListener('change', function () {
        loadTeachers(1);
    });

    document.getElementById('openModalBtn').addEventListener('click', function () {
        form.reset();

        formId.value = '';
        formStatus.checked = true;

        document.getElementById('modalTitle').textContent =
            'Add New Teacher';

        document.getElementById('modalSubtitle').textContent =
            'Register a teaching faculty member for this institute.';

        formPassword.required = true;
        formConfirmPassword.required = true;

        formError.classList.add('hidden');
        formError.textContent = '';

        modal.classList.remove('hidden');
        loadNextEmployeeCode();
    });

    document.getElementById('closeModalBtn').addEventListener(
        'click',
        closeModal
    );

    document.getElementById('cancelModalBtn').addEventListener(
        'click',
        closeModal
    );

    function closeModal() {
        modal.classList.add('hidden');
    }

    window.editTeacher = async function (id) {
        try {
            const response = await fetch(`${API_URL}/${id}`, {
                headers
            });

            if (response.status === 401) {
                logout();
                return;
            }

            const result = await response.json();

            if (!response.ok || !result.status) {
                throw new Error(
                    result.message || 'Unable to load teacher.'
                );
            }

            const teacher = result.data;

            formId.value = teacher.id;
            formName.value = teacher.name ?? '';
            formCode.value = teacher.employee_code ?? '';
            formEmail.value = teacher.email ?? '';
            formPhone.value = teacher.phone ?? '';
            formPassword.value = '';
            formConfirmPassword.value = '';
            formStatus.checked = Number(teacher.status) === 1;

            document.getElementById('modalTitle').textContent =
                'Edit Teacher';

            document.getElementById('modalSubtitle').textContent =
                'Update teacher information.';

            formPassword.required = false;
            formConfirmPassword.required = false;

            formError.classList.add('hidden');
            formError.textContent = '';

            modal.classList.remove('hidden');

        } catch (error) {
            showToast(error.message, 'error');
        }
    };

    form.addEventListener('submit', async function (event) {
        event.preventDefault();

        formError.classList.add('hidden');
        formError.textContent = '';

        const id = formId.value;
        const editing = Boolean(id);

        if (
            !editing &&
            formPassword.value !== formConfirmPassword.value
        ) {
            formError.textContent =
                'Password and confirmation password do not match.';

            formError.classList.remove('hidden');
            return;
        }

        if (
            editing &&
            formPassword.value &&
            formPassword.value !== formConfirmPassword.value
        ) {
            formError.textContent =
                'Password and confirmation password do not match.';

            formError.classList.remove('hidden');
            return;
        }

        const payload = {
            name: formName.value.trim(),
            employee_code: formCode.value.trim(),
            email: formEmail.value.trim(),
            phone: formPhone.value.trim(),
            status: formStatus.checked ? 1 : 0
        };

        if (formPassword.value) {
            payload.password = formPassword.value;
            payload.password_confirmation = formConfirmPassword.value;
        }

        const button = document.getElementById('saveTeacherBtn');

        button.disabled = true;

        document.getElementById('saveTeacherText').textContent =
            editing ? 'Updating...' : 'Saving...';

        try {
            const response = await fetch(
                editing ? `${API_URL}/${id}` : API_URL,
                {
                    method: editing ? 'PUT' : 'POST',
                    headers: {
                        ...headers,
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(payload)
                }
            );

            if (response.status === 401) {
                logout();
                return;
            }

            const result = await response.json();
            console.log(result);

            if (!response.ok || !result.status) {
                if (result.errors) {
                    throw new Error(
                        Object.values(result.errors)
                            .flat()
                            .join(' ')
                    );
                }

                throw new Error(
                    result.message || 'Unable to save teacher.'
                );
            }

            closeModal();

            showToast(
                editing
                    ? 'Teacher updated successfully.'
                    : 'Teacher created successfully.',
                'check_circle'
            );

            await loadTeachers();

        } catch (error) {
            formError.textContent = error.message;
            formError.classList.remove('hidden');

        } finally {
            button.disabled = false;

            document.getElementById('saveTeacherText').textContent =
                editing ? 'Update Teacher' : 'Save Teacher';
        }
    });

    window.viewTeacher = async function(id) {
        viewTeacherModal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');

        viewTeacherName.textContent = 'Loading...';
        viewTeacherCode.textContent = '';
        viewTeacherEmail.textContent = '—';
        viewTeacherPhone.textContent = '—';
        viewTeacherAssignments.textContent = '—';
        viewTeacherStatus.innerHTML = '';

        viewTeacherAvatar.innerHTML = `
            <div class="w-14 h-14 rounded-full bg-surface-container
                        flex items-center justify-center">
                <span class="material-symbols-outlined animate-spin text-primary">
                    progress_activity
                </span>
            </div>
        `;

        try {
            const result = await apiRequest(`${API_URL}/${id}`);
            const teacher = result.data;
            console.log('TEACHER DATA:', teacher);
            console.log('TEACHER ASSIGNMENTS:', teacher.assignments);

            const picture = getProfilePictureUrl(teacher.profile_picture);
            const initials = getInitials(teacher.name);

            viewTeacherAvatar.innerHTML = picture
                ? `
                    <img src="${picture}" alt="${escapeHtml(teacher.name)}"
                         class="w-14 h-14 rounded-full object-cover">
                `
                : `
                    <div class="w-14 h-14 rounded-full bg-primary text-on-primary
                                flex items-center justify-center text-lg font-semibold">
                        ${escapeHtml(initials)}
                    </div>
                `;

            viewTeacherName.textContent = teacher.name || '—';
            viewTeacherCode.textContent = teacher.employee_code || '—';

            viewTeacherStatus.innerHTML = teacher.status
                ? `
                    <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-secondary">
                        <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span>
                        Active
                    </span>
                `
                : `
                    <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-outline">
                        <span class="w-1.5 h-1.5 rounded-full bg-outline"></span>
                        Inactive
                    </span>
                `;

            viewTeacherEmail.textContent = teacher.email || '—';

            viewTeacherPhone.textContent = teacher.phone || '—';
            renderTeacherAssignments(teacher.assignments);
            function renderTeacherAssignments(assignments) {
                if (!Array.isArray(assignments) || assignments.length === 0) {
                    viewTeacherAssignments.innerHTML = `
                        <div class="py-4 text-sm text-on-surface-variant">
                            No assignments found.
                        </div>
                    `;
                    return;
                }

                viewTeacherAssignments.innerHTML = `
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-outline-variant">
                                    <th class="px-3 py-3 text-left font-semibold text-on-surface">
                                        Class
                                    </th>
                                    <th class="px-3 py-3 text-left font-semibold text-on-surface">
                                        Section
                                    </th>
                                    <th class="px-3 py-3 text-left font-semibold text-on-surface">
                                        Subject
                                    </th>
                                    <th class="px-3 py-3 text-left font-semibold text-on-surface">
                                        Session
                                    </th>
                                    <th class="px-3 py-3 text-left font-semibold text-on-surface">
                                        Status
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                ${assignments.map(assignment => {
                                    const className =
                                        assignment.class?.short_name || '—';

                                    const sectionName =
                                        assignment.section?.short_name || '—';

                                    const subjectName =
                                        assignment.subject?.name || '—';

                                    const sessionName =
                                        assignment.academic_session?.name || '—';

                                    const status = assignment.status
                                        ? `
                                            <span class="inline-flex items-center gap-1.5
                                                        rounded-full px-2.5 py-1
                                                        text-xs font-semibold
                                                        text-secondary">
                                                <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span>
                                                Active
                                            </span>
                                        `
                                        : `
                                            <span class="inline-flex items-center gap-1.5
                                                        rounded-full px-2.5 py-1
                                                        text-xs font-semibold
                                                        text-on-surface-variant">
                                                <span class="w-1.5 h-1.5 rounded-full bg-on-surface-variant"></span>
                                                Inactive
                                            </span>
                                        `;

                                    return `
                                        <tr class="border-b border-outline-variant last:border-0">
                                            <td class="px-3 py-3 font-medium text-on-surface text-center">
                                                ${escapeHtml(className)}
                                            </td>

                                            <td class="px-3 py-3 text-on-surface-variant text-center">
                                                ${escapeHtml(sectionName)}
                                            </td>

                                            <td class="px-3 py-3 text-on-surface-variant">
                                                ${escapeHtml(subjectName)}
                                            </td>

                                            <td class="px-3 py-3 text-on-surface-variant">
                                                ${escapeHtml(sessionName)}
                                            </td>

                                            <td class="px-3 py-3">
                                                ${status}
                                            </td>
                                        </tr>
                                    `;
                                }).join('')}
                            </tbody>
                        </table>
                    </div>
                `;
            }

        } catch (error) {
            closeTeacherViewModal();
            showToast(error.message, 'error');
        }
    };

    function closeTeacherViewModal() {
        viewTeacherModal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
        }

        closeViewTeacherModalButton.addEventListener(
            'click',
            closeTeacherViewModal
        );

        closeViewTeacherButton.addEventListener(
            'click',
            closeTeacherViewModal
        );

        viewTeacherModal.addEventListener('click', event => {
            if (event.target === viewTeacherModal) {
                closeTeacherViewModal();
            }
    });

    window.toggleTeacherStatus = async function(id) {
        try {
            const result = await apiRequest(`${API_URL}/${id}/status`, {
                method: 'PATCH'
            });

            showToast(
                result.message || 'Teacher status updated successfully.'
            );

            await loadTeachers();
        } catch (error) {
            showToast(error.message, 'error');
        }
    };
    window.deleteTeacher = function (id) {
    const teacher = allTeachers.find(
        teacher => Number(teacher.id) === Number(id)
    );

    if (!teacher) {
        showToast('Teacher not found.', 'error');
        return;
    }

    selectedTeacherId = id;

    const assignmentCount = Number(
        teacher.current_assignment_count ?? 0
    );

    confirmDeleteTeacherButton.classList.add('hidden');
    confirmDeactivateTeacherButton.classList.add('hidden');

    if (assignmentCount > 0) {
        deleteTeacherMessage.className =
            'rounded-lg bg-amber-50 p-4 text-sm text-amber-800';

        deleteTeacherMessage.innerHTML = `
            <div class="flex items-start gap-3">
                <span class="material-symbols-outlined text-[22px]">
                    warning
                </span>

                <div>
                    <p class="font-semibold">
                        Teacher cannot be deleted
                    </p>

                    <p class="mt-1">
                        This teacher has ${assignmentCount}
                        active assignment${assignmentCount === 1 ? '' : 's'}
                        in the current academic session.
                        Please deactivate the teacher instead.
                    </p>
                </div>
            </div>
        `;

        confirmDeactivateTeacherButton.classList.remove('hidden');

    } else {
        deleteTeacherMessage.className =
            'rounded-lg bg-red-50 p-4 text-sm text-red-700';

        deleteTeacherMessage.innerHTML = `
            <div class="flex items-start gap-3">
                <span class="material-symbols-outlined text-[22px]">
                    delete
                </span>

                <div>
                    <p class="font-semibold">
                        Delete ${escapeHtml(teacher.name || 'this teacher')}?
                    </p>

                    <p class="mt-1">
                        This teacher has no assignments.
                        This action will permanently delete the teacher account.
                    </p>
                </div>
            </div>
        `;

        confirmDeleteTeacherButton.classList.remove('hidden');
    }

    deleteTeacherModal.classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
};

function closeDeleteTeacherModal() {
    deleteTeacherModal.classList.add('hidden');
    document.body.classList.remove('overflow-hidden');

    selectedTeacherId = null;

    confirmDeleteTeacherButton.classList.add('hidden');
    confirmDeactivateTeacherButton.classList.add('hidden');
}

closeDeleteTeacherModalButton.addEventListener(
    'click',
    closeDeleteTeacherModal
);

cancelDeleteTeacherButton.addEventListener(
    'click',
    closeDeleteTeacherModal
);

deleteTeacherModal.addEventListener('click', event => {
    if (event.target === deleteTeacherModal) {
        closeDeleteTeacherModal();
    }
});

confirmDeleteTeacherButton.addEventListener(
    'click',
    async function () {
        if (!selectedTeacherId) {
            return;
        }

        const id = selectedTeacherId;

        confirmDeleteTeacherButton.disabled = true;
        confirmDeleteTeacherButton.textContent = 'Deleting...';

        try {
            const result = await apiRequest(
                `${API_URL}/${id}`,
                {
                    method: 'DELETE'
                }
            );

            closeDeleteTeacherModal();

            showToast(
                result.message || 'Teacher deleted successfully.',
                'delete'
            );

            await loadTeachers(currentPage);

        } catch (error) {
            showToast(
                error.message || 'Unable to delete teacher.',
                'error'
            );
        } finally {
            confirmDeleteTeacherButton.disabled = false;
            confirmDeleteTeacherButton.textContent = 'Delete Teacher';
        }
    }
);

confirmDeactivateTeacherButton.addEventListener(
    'click',
    async function () {
        if (!selectedTeacherId) {
            return;
        }

        const id = selectedTeacherId;

        confirmDeactivateTeacherButton.disabled = true;
        confirmDeactivateTeacherButton.textContent = 'Deactivating...';

        try {
            const result = await apiRequest(
                `${API_URL}/${id}/status`,
                {
                    method: 'PATCH'
                }
            );

            closeDeleteTeacherModal();

            showToast(
                result.message || 'Teacher deactivated successfully.',
                'check_circle'
            );

            await loadTeachers(currentPage);

        } catch (error) {
            showToast(
                error.message || 'Unable to deactivate teacher.',
                'error'
            );
        } finally {
            confirmDeactivateTeacherButton.disabled = false;
            confirmDeactivateTeacherButton.textContent =
                'Deactivate Teacher';
        }
    }
);

    function showToast(message, icon = 'check_circle') {
        const toast = document.getElementById('toastNotification');

        document.getElementById('toastMessage').textContent = message;
        document.getElementById('toastIcon').textContent = icon;

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
        return String(name)
            .trim()
            .split(/\s+/)
            .map(word => word.charAt(0))
            .join('')
            .substring(0, 2)
            .toUpperCase();
    }

    function getProfilePictureUrl(path) {
        if (!path) {
            return '';
        }

        if (
            path.startsWith('http://') ||
            path.startsWith('https://') ||
            path.startsWith('/')
        ) {
            return path;
        }

        return `/storage/${path}`;
    }

    function escapeHtml(value) {
        return String(value ?? '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    loadTeachers();
    setInterval(() => {
        if (
            modal.classList.contains('hidden') &&
            viewTeacherModal.classList.contains('hidden') &&
            deleteTeacherModal.classList.contains('hidden')
        ) {
            loadTeachers(currentPage);
        }
    }, 10000);
})();
</script>



@endsection