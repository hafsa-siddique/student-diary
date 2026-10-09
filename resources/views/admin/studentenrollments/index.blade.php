@extends('layouts.admin')

@section('title', 'Student Enrollments')

@section('content')

<div class="flex flex-col gap-space-lg w-full">
    <div class="flex flex-col gap-1">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-space-md mt-2">
            <div>
                <h1 class="font-headline-lg text-headline-lg text-on-surface tracking-tight">Student Enrollments</h1>
                <p class="font-body-md text-body-md text-on-surface-variant mt-0.5">Manage student class enrollments and monitor their academic status.</p>
            </div>

            <button type="button" id="openModalBtn" class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-primary-container text-on-primary hover:bg-primary transition-all rounded-lg shadow-sm font-label-lg text-label-lg active:scale-[0.98]">
                <span class="material-symbols-outlined text-[20px]">add</span>
                <span>Add Enrollment</span>
            </button>
        </div>
    </div>

    <div class="space-y-space-md">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-surface-container-lowest p-space-md rounded-xl shadow-sm flex items-center justify-between">
                <div class="flex flex-col">
                    <span class="font-label-sm text-label-sm text-outline uppercase tracking-wider">Total Enrollments</span>
                    <span id="totalEnrollments" class="font-display-lg text-display-lg text-on-surface mt-1 font-tabular-numeric">—</span>
                    <span class="font-body-sm text-body-sm text-primary flex items-center gap-1 mt-0.5">
                        <span class="material-symbols-outlined text-[16px]">groups</span>
                        All student enrollments
                    </span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-surface-container flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined text-[26px]">groups</span>
                </div>
            </div>

            <div class="bg-surface-container-lowest p-space-md rounded-xl shadow-sm flex items-center justify-between">
                <div class="flex flex-col">
                    <span class="font-label-sm text-label-sm text-outline uppercase tracking-wider">Active Students</span>
                    <span id="activeEnrollments" class="font-display-lg text-display-lg text-secondary mt-1 font-tabular-numeric">—</span>
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
                    <span class="font-label-sm text-label-sm text-outline uppercase tracking-wider">Inactive Students</span>
                    <span id="inactiveEnrollments" class="font-display-lg text-display-lg text-tertiary mt-1 font-tabular-numeric">—</span>
                    <span class="font-body-sm text-body-sm text-on-surface-variant flex items-center gap-1 mt-0.5">
                        <span class="material-symbols-outlined text-[16px]">person_off</span>
                        Inactive enrollments
                    </span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-tertiary-fixed flex items-center justify-center text-tertiary">
                    <span class="material-symbols-outlined text-[26px]">person_off</span>
                </div>
            </div>

            <div class="bg-surface-container-lowest p-space-md rounded-xl shadow-sm flex items-center justify-between">
                <div class="flex flex-col">
                    <span class="font-label-sm text-label-sm text-outline uppercase tracking-wider">Current Session</span>
                    <span id="currentSessionName" class="text-xl font-bold text-on-surface mt-1 font-tabular-numeric">—</span>
                    <span id="currentSessionCount" class="font-body-sm text-body-sm text-on-surface-variant mt-0.5">Loading enrollments...</span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-surface-container flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined text-[26px]">school</span>
                </div>
            </div>
        </div>

        <div class="bg-surface-container-lowest p-space-md rounded-xl shadow-sm">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[20px]">search</span>
                    <input type="text" id="searchInput" class="w-full h-10 pl-10 pr-4 rounded-lg bg-surface text-on-surface font-body-sm text-body-sm placeholder:text-outline focus:outline-none focus:bg-surface-container-lowest focus:shadow-sm transition-all" placeholder="Search student name or code...">
                </div>

                <div class="relative">
                    <select id="classFilter" class="w-full h-10 pl-3 pr-8 rounded-lg bg-surface font-label-md text-label-md text-on-surface appearance-none cursor-pointer focus:outline-none">
                        <option value="all">All Classes</option>
                    </select>
                    <span class="material-symbols-outlined absolute right-2.5 top-1/2 -translate-y-1/2 text-outline text-[18px] pointer-events-none">expand_more</span>
                </div>

                <div class="relative">
                    <select id="sectionFilter" class="w-full h-10 pl-3 pr-8 rounded-lg bg-surface font-label-md text-label-md text-on-surface appearance-none cursor-pointer focus:outline-none">
                        <option value="all">All Sections</option>
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
                            <th class="py-3 px-10">Student</th>
                            <th class="py-3 px-4">Student Code</th>
                            <th class="py-3 px-4">Class</th>
                            <th class="py-3 px-4">Section</th>
                            <th class="py-3 px-4 text-center">Status</th>
                            <th class="py-3 px-4 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="enrollmentTableBody" class="divide-y divide-surface-container font-body-md text-body-md text-on-surface">
                        <tr>
                            <td colspan="7" class="px-6 py-10 text-center text-on-surface-variant">
                                <div class="flex items-center justify-center gap-2">
                                    <span class="material-symbols-outlined animate-spin text-[22px]">progress_activity</span>
                                    Loading enrollments...
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="p-space-md bg-surface-container-lowest flex flex-col sm:flex-row items-center justify-between gap-space-md border-t border-surface-container">
                <div id="enrollmentPaginationInfo" class="font-body-sm text-body-sm text-on-surface-variant">Loading...</div>
                <div id="enrollmentPagination" class="flex items-center gap-1 font-label-md text-label-md"></div>
            </div>
        </div>
    </div>
</div>

<div id="enrollmentModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4" role="dialog" aria-modal="true">
    <div class="w-full max-w-3xl max-h-[90vh] overflow-hidden rounded-2xl bg-surface-container-lowest shadow-xl flex flex-col">
        <div class="flex items-center justify-between border-b border-outline-variant p-5 shrink-0">
            <div>
                <h2 id="modalTitle" class="font-headline-md text-headline-md text-on-surface">Add Student Enrollment</h2>
                <p id="modalSubtitle" class="mt-1 text-sm text-on-surface-variant">Enroll a student in a class and section.</p>
            </div>
            <button type="button" id="closeModalBtn" class="rounded-lg p-2 text-on-surface-variant hover:bg-surface-container" aria-label="Close modal">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <form id="enrollmentForm" class="flex flex-col min-h-0">
            <input type="hidden" id="formEnrollmentId">

            <div class="grid grid-cols-1 gap-4 p-5 sm:grid-cols-2 overflow-y-auto">
                <div class="sm:col-span-2">
                    <label for="formStudentId" class="mb-1 block text-sm font-medium text-on-surface">Student <span class="text-error">*</span></label>
                    <select id="formStudentId" class="w-full rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface focus:outline-none" required>
                        <option value="">Select student</option>
                    </select>
                </div>

                <div>
                    <label for="formClassId" class="mb-1 block text-sm font-medium text-on-surface">Class <span class="text-error">*</span></label>
                    <select id="formClassId" class="w-full rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface focus:outline-none" required>
                        <option value="">Select class</option>
                    </select>
                </div>

                <div>
                    <label for="formSectionId" class="mb-1 block text-sm font-medium text-on-surface">Section <span class="text-error">*</span></label>
                    <select id="formSectionId" class="w-full rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface focus:outline-none" required>
                        <option value="">Select section</option>
                    </select>
                </div>

                <div>
                    <label for="formSessionId" class="mb-1 block text-sm font-medium text-on-surface">Academic Session <span class="text-error">*</span></label>
                    <select id="formSessionId" class="w-full rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface focus:outline-none" required>
                        <option value="">Select session</option>
                    </select>
                </div>

                <div>
                    <label for="formEnrollmentDate" class="mb-1 block text-sm font-medium text-on-surface">Enrollment Date <span class="text-error">*</span></label>
                    <input type="date" id="formEnrollmentDate" class="w-full rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface focus:outline-none" required>
                </div>

                <div class="sm:col-span-2 flex items-center justify-between rounded-lg bg-surface-container-low p-3">
                    <div>
                        <span class="text-sm font-semibold text-on-surface">Enrollment Status</span>
                        <span class="mt-0.5 block text-sm text-on-surface-variant">Allow the student enrollment to remain active.</span>
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
                <button type="submit" id="saveEnrollmentBtn" class="rounded-lg bg-primary px-5 py-2 text-sm font-semibold text-white hover:opacity-90">
                    <span id="saveEnrollmentText">Save Enrollment</span>
                </button>
            </div>
        </form>
    </div>
</div>

<div id="viewEnrollmentModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
    <div class="w-full max-w-lg rounded-2xl bg-surface-container-lowest shadow-xl">
        <div class="flex items-center justify-between border-b border-outline-variant p-5">
            <div>
                <h2 class="font-headline-md text-headline-md text-on-surface">Student Enrollment Details</h2>
                <p class="mt-1 text-sm text-on-surface-variant">View student enrollment information</p>
            </div>
            <button type="button" id="closeViewEnrollmentModal" class="rounded-lg p-2 text-on-surface-variant hover:bg-surface-container">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <div class="p-5">
            <div class="flex items-center gap-4 pb-5">
                <div id="viewStudentAvatar"></div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center justify-between gap-4 flex-wrap">
                        <h3 id="viewStudentName" class="text-lg font-semibold text-on-surface">—</h3>
                        <div id="viewStudentStatus">—</div>
                    </div>
                    <p id="viewStudentCode" class="mt-1 text-sm text-on-surface-variant">—</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="rounded-lg bg-surface-container-low p-4">
                    <p class="text-xs text-on-surface-variant">Class</p>
                    <p id="viewStudentClass" class="mt-1 font-medium text-on-surface">—</p>
                </div>
                <div class="rounded-lg bg-surface-container-low p-4">
                    <p class="text-xs text-on-surface-variant">Section</p>
                    <p id="viewStudentSection" class="mt-1 font-medium text-on-surface">—</p>
                </div>
                <div class="rounded-lg bg-surface-container-low p-4">
                    <p class="text-xs text-on-surface-variant">Academic Session</p>
                    <p id="viewStudentSession" class="mt-1 font-medium text-on-surface">—</p>
                </div>
                <div class="rounded-lg bg-surface-container-low p-4">
                    <p class="text-xs text-on-surface-variant">Enrollment Status</p>
                    <div id="viewStudentStatusDetail" class="mt-1">—</div>
                </div>
                <div class="rounded-lg bg-surface-container-low p-4 sm:col-span-2">
                    <p class="text-xs text-on-surface-variant">Subjects</p>
                    <div id="viewStudentSubjects" class="space-y-2 mt-2">—</div>
                </div>
            </div>
        </div>

        <div class="flex justify-end border-t border-outline-variant p-5">
            <button type="button" id="closeViewEnrollmentButton" class="rounded-lg border border-outline-variant px-4 py-2 text-sm font-medium text-on-surface">Close</button>
        </div>
    </div>
</div>

<div id="deleteEnrollmentModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4" role="dialog" aria-modal="true">
    <div class="w-full max-w-md rounded-2xl bg-surface-container-lowest shadow-xl">
        <div class="flex items-center justify-between border-b border-outline-variant p-5">
            <div>
                <h2 class="font-headline-md text-headline-md text-on-surface">Delete Enrollment</h2>
                <p class="mt-1 text-sm text-on-surface-variant">Confirm this action.</p>
            </div>
            <button type="button" id="closeDeleteEnrollmentModal" class="rounded-lg p-2 text-on-surface-variant hover:bg-surface-container" aria-label="Close modal">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <div class="p-5">
            <div id="deleteEnrollmentMessage" class="rounded-lg bg-red-50 p-4 text-sm text-red-700">Confirm deletion.</div>
        </div>

        <div class="flex justify-end gap-3 border-t border-outline-variant p-5">
            <button type="button" id="cancelDeleteEnrollment" class="rounded-lg border border-outline-variant px-4 py-2 text-sm font-medium text-on-surface hover:bg-surface-container">Cancel</button>
            <button type="button" id="confirmDeleteEnrollment" class="rounded-lg bg-red-600 px-5 py-2 text-sm font-semibold text-white hover:bg-red-700">Delete Enrollment</button>
        </div>
    </div>
</div>

<div id="toastNotification" class="fixed bottom-6 right-6 z-50 bg-inverse-surface text-inverse-on-surface px-4 py-3 rounded-lg shadow-lg flex items-center gap-3 translate-y-16 opacity-0 pointer-events-none transition-all duration-300">
    <span id="toastIcon" class="material-symbols-outlined text-secondary-fixed text-[20px]">check_circle</span>
    <span id="toastMessage" class="font-body-sm text-body-sm">Operation completed successfully.</span>
</div>

<script>
(() => {
    const API_URL = '/api/v1/admin/student-enrollments';
    const token = localStorage.getItem('student_diary_token');

    if (!token) {
        window.location.replace('/');
        return;
    }

    const headers = {
        Accept: 'application/json',
        Authorization: `Bearer ${token}`
    };

    const tableBody = document.getElementById('enrollmentTableBody');
    const searchInput = document.getElementById('searchInput');
    const classFilter = document.getElementById('classFilter');
    const sectionFilter = document.getElementById('sectionFilter');
    const totalEnrollments = document.getElementById('totalEnrollments');
    const activeEnrollments = document.getElementById('activeEnrollments');
    const inactiveEnrollments = document.getElementById('inactiveEnrollments');
    const activePercentage = document.getElementById('activePercentage');
    const currentSessionName = document.getElementById('currentSessionName');
    const currentSessionCount = document.getElementById('currentSessionCount');
    const pagination = document.getElementById('enrollmentPagination');
    const paginationInfo = document.getElementById('enrollmentPaginationInfo');

    const modal = document.getElementById('enrollmentModal');
    const form = document.getElementById('enrollmentForm');
    const formId = document.getElementById('formEnrollmentId');
    const formStudent = document.getElementById('formStudentId');
    const formClass = document.getElementById('formClassId');
    const formSection = document.getElementById('formSectionId');
    const formSession = document.getElementById('formSessionId');
    const formDate = document.getElementById('formEnrollmentDate');
    const formStatus = document.getElementById('formStatusToggle');
    const formError = document.getElementById('formError');

    const viewModal = document.getElementById('viewEnrollmentModal');
    const viewAvatar = document.getElementById('viewStudentAvatar');
    const viewName = document.getElementById('viewStudentName');
    const viewCode = document.getElementById('viewStudentCode');
    const viewClass = document.getElementById('viewStudentClass');
    const viewSection = document.getElementById('viewStudentSection');
    const viewSession = document.getElementById('viewStudentSession');
    const viewStatus = document.getElementById('viewStudentStatus');
    const viewStatusDetail = document.getElementById('viewStudentStatusDetail');
    const viewSubjects = document.getElementById('viewStudentSubjects');

    const deleteModal = document.getElementById('deleteEnrollmentModal');
    const deleteMessage = document.getElementById('deleteEnrollmentMessage');
    const confirmDelete = document.getElementById('confirmDeleteEnrollment');

    let allEnrollments = [];
    let students = [];
    let classes = [];
    let sections = [];
    let sessions = [];
    let currentPage = 1;
    let lastPage = 1;
    let selectedEnrollmentId = null;
    let searchTimer;

    function logout() {
        localStorage.removeItem('student_diary_token');
        localStorage.removeItem('student_diary_user');
        localStorage.removeItem('student_diary_institute_code');
        window.location.replace('/');
    }

    async function apiRequest(url, options = {}) {
        const response = await fetch(url, {
            ...options,
            headers: { ...headers, ...(options.headers || {}) }
        });

        if (response.status === 401) {
            logout();
            throw new Error('Session expired.');
        }

        const result = await response.json();

        if (!response.ok || result.status === false) {
            if (result.errors) {
                throw new Error(Object.values(result.errors).flat().join(' '));
            }
            throw new Error(result.message || 'Something went wrong.');
        }

        return result;
    }

    async function loadOptions() {
        try {
            const [studentResult, classResult, sessionResult] = await Promise.all([
                apiRequest('/api/v1/admin/students?per_page=1000'),
                apiRequest('/api/v1/admin/classes?per_page=1000'),
                apiRequest('/api/v1/admin/academic-sessions?per_page=1000')
            ]);

            students = studentResult.data?.data ?? studentResult.data ?? [];
            classes = classResult.data?.data ?? classResult.data ?? [];
            sessions = sessionResult.data?.data ?? sessionResult.data ?? [];

            renderStudentOptions();
            renderClassOptions();
            renderSessionOptions();

            const currentSession = sessionResult.current_session || sessionResult.data?.current_session;

            if (currentSession?.id) {
                formSession.value = String(currentSession.id);
            }

            await loadAllSections();
        } catch (error) {
            showToast(error.message, 'error');
        }
    }

    function renderStudentOptions() {
        formStudent.innerHTML = '<option value="">Select student</option>';

        students.forEach(student => {
            const option = document.createElement('option');
            option.value = student.id;
            option.textContent = `${student.name || 'Unknown'} (${student.student_code || '—'})`;
            formStudent.appendChild(option);
        });
    }

    function renderClassOptions() {
        const selects = [classFilter, formClass];

        selects.forEach(select => {
            const firstOption = select === classFilter ? 'All Classes' : 'Select class';

            select.innerHTML = `
                <option value="${select === classFilter ? 'all' : ''}">${firstOption}</option>
            `;

            classes.forEach(item => {
                const option = document.createElement('option');
                option.value = item.id;
                option.textContent = item.name;
                select.appendChild(option);
            });
        });
    }

    function renderSessionOptions() {
        formSession.innerHTML = '<option value="">Select session</option>';

        sessions.forEach(session => {
            const option = document.createElement('option');
            option.value = session.id;
            option.textContent = session.name;
            formSession.appendChild(option);
        });
    }

    async function loadAllSections() {
        sections = [];

        await Promise.all(classes.map(async schoolClass => {
            try {
                const result = await apiRequest(`/api/v1/admin/classes/${schoolClass.id}/sections`);
                const records = result.data?.data ?? result.data ?? [];

                records.forEach(section => {
                    sections.push({
                        ...section,
                        class_id: section.class_id ?? schoolClass.id
                    });
                });
            } catch (error) {
                console.error(error);
            }
        }));

        renderSectionFilter();
    }

    function renderSectionFilter(classId = 'all') {
        sectionFilter.innerHTML = '<option value="all">All Sections</option>';

        const filtered = classId === 'all'
            ? sections
            : sections.filter(section => Number(section.class_id) === Number(classId));

        filtered.forEach(section => {
            const option = document.createElement('option');
            option.value = section.id;
            option.textContent = section.name;
            sectionFilter.appendChild(option);
        });
    }

    function renderFormSections(classId, selectedId = '') {
        formSection.innerHTML = '<option value="">Select section</option>';

        const filtered = sections.filter(section => Number(section.class_id) === Number(classId));

        filtered.forEach(section => {
            const option = document.createElement('option');
            option.value = section.id;
            option.textContent = section.name;
            formSection.appendChild(option);
        });

        if (selectedId) {
            formSection.value = String(selectedId);
        }
    }

    async function loadEnrollments(page = 1) {
        tableBody.innerHTML = `
            <tr>
                <td colspan="7" class="px-6 py-10 text-center text-on-surface-variant">Loading enrollments...</td>
            </tr>
        `;

        try {
            const params = new URLSearchParams();
            params.set('page', page);

            const search = searchInput.value.trim();
            const classId = classFilter.value;
            const sectionId = sectionFilter.value;

            if (search) params.set('search', search);
            if (classId !== 'all') params.set('class_id', classId);
            if (sectionId !== 'all') params.set('section_id', sectionId);

            const result = await apiRequest(`${API_URL}?${params.toString()}`);

            allEnrollments = result.data?.data ?? result.data ?? [];

            const meta = result.pagination ?? {};
            currentPage = Number(meta.current_page || page);
            lastPage = Number(meta.last_page || 1);

            updateStatistics(result);
            renderEnrollments();
            renderPagination(meta);
        } catch (error) {
            tableBody.innerHTML = `
                <tr>
                    <td colspan="7" class="px-6 py-10 text-center text-red-500">${escapeHtml(error.message || 'Failed to load enrollments.')}</td>
                </tr>
            `;
        }
    }

    function updateStatistics(result) {
        const statistics = result.statistics ?? {};

        const total = Number(
            statistics.total_enrollments ??
            statistics.total ??
            result.assignment_count ??
            0
        );

        const active = Number(
            statistics.active_enrollments ??
            statistics.active ??
            0
        );

        const inactive = Number(
            statistics.inactive_enrollments ??
            statistics.inactive ??
            0
        );

        totalEnrollments.textContent = total;
        activeEnrollments.textContent = active;
        inactiveEnrollments.textContent = inactive;

        const percentage = total ? ((active / total) * 100).toFixed(1) : '0.0';

        activePercentage.innerHTML = `
            <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span>
            ${percentage}% active
        `;

        const session = result.current_session || result.data?.current_session;

        currentSessionName.textContent = session?.name || 'No active session';
        currentSessionCount.textContent = `${total} enrollment${total === 1 ? '' : 's'} recorded`;
    }

    function renderEnrollments() {
        if (!allEnrollments.length) {
            tableBody.innerHTML = `
                <tr>
                    <td colspan="7" class="py-12 text-center text-on-surface-variant">
                        <div class="flex flex-col items-center gap-2">
                            <span class="material-symbols-outlined text-[34px]">person_search</span>
                            <span>No student enrollments found.</span>
                        </div>
                    </td>
                </tr>
            `;
            return;
        }

        tableBody.innerHTML = allEnrollments.map((enrollment, index) => {
            const rowNumber = ((currentPage - 1) * 5) + index + 1;
            const active = Number(enrollment.status) === 1 || enrollment.status === true;
            const student = enrollment.student || {};
            const schoolClass = enrollment.class || {};
            const section = enrollment.section || {};
            const name = student.name || 'Unknown Student';
            const code = student.student_code || '—';
            const className = schoolClass.name || '—';
            const sectionName = section.name || '—';
            const initials = getInitials(name);

            const avatar = student.profile_picture
                ? `
                    <img src="${getProfilePictureUrl(student.profile_picture)}" alt="${escapeHtml(name)}" class="w-9 h-9 rounded-full object-cover">
                `
                : `
                    <div class="w-9 h-9 rounded-full bg-primary text-on-primary flex items-center justify-center font-semibold">
                        ${escapeHtml(initials)}
                    </div>
                `;

            return `
                <tr class="hover:bg-surface-container-low transition-colors">
                    <td class="py-3.5 px-4 text-center">${rowNumber}</td>
                    <td class="py-3.5 px-4">
                        <div class="flex items-center gap-3">
                            ${avatar}
                            <div class="min-w-0">
                                <div class="font-semibold text-on-surface truncate">${escapeHtml(name)}</div>
                                <div class="text-xs text-on-surface-variant">Student</div>
                            </div>
                        </div>
                    </td>
                    <td class="py-3.5 px-4">
                        <span class="bg-surface-container px-2 py-1 rounded font-semibold">${escapeHtml(code)}</span>
                    </td>
                    <td class="py-3.5 px-4">${escapeHtml(className)}</td>
                    <td class="py-3.5 px-4">${escapeHtml(sectionName)}</td>
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
                        <button type="button" onclick="viewEnrollment(${enrollment.id})" class="p-2 rounded-lg text-on-surface-variant hover:bg-surface-container" title="View">
                            <span class="material-symbols-outlined text-[20px]">visibility</span>
                        </button>
                        <button type="button" onclick="editEnrollment(${enrollment.id})" class="p-1.5 rounded hover:bg-surface-container text-outline hover:text-primary" title="Edit">
                            <span class="material-symbols-outlined text-[18px]">edit</span>
                        </button>
                        <button type="button" onclick="toggleEnrollmentStatus(${enrollment.id})" class="p-2 rounded-lg text-on-surface-variant hover:bg-surface-container" title="${active ? 'Deactivate' : 'Activate'}">
                            <span class="material-symbols-outlined text-[20px]">${active ? 'person_off' : 'how_to_reg'}</span>
                        </button>
                        <button type="button" onclick="deleteEnrollment(${enrollment.id})" class="p-2 rounded-lg text-error hover:bg-red-50" title="Delete">
                            <span class="material-symbols-outlined text-[18px]">delete</span>
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
            ? `Showing ${from} - ${to} of ${total} enrollments`
            : 'No enrollments found';

        pagination.innerHTML = '';

        if (lastPage <= 1) return;

        const previousButton = document.createElement('button');

        previousButton.type = 'button';
        previousButton.textContent = '‹';
        previousButton.disabled = currentPage === 1;
        previousButton.className = `h-9 min-w-9 rounded-lg px-3 text-sm font-semibold ${
            currentPage === 1
                ? 'text-outline cursor-not-allowed'
                : 'text-on-surface-variant hover:bg-surface-container'
        }`;

        previousButton.addEventListener('click', () => {
            if (currentPage > 1) loadEnrollments(currentPage - 1);
        });

        pagination.appendChild(previousButton);

        for (let page = 1; page <= lastPage; page++) {
            const button = document.createElement('button');

            button.type = 'button';
            button.textContent = page;
            button.className = page === currentPage
                ? 'h-9 min-w-9 rounded-lg bg-primary px-3 text-sm font-semibold text-white'
                : 'h-9 min-w-9 rounded-lg px-3 text-sm text-on-surface-variant hover:bg-surface-container';

            button.addEventListener('click', () => loadEnrollments(page));
            pagination.appendChild(button);
        }

        const nextButton = document.createElement('button');

        nextButton.type = 'button';
        nextButton.textContent = '›';
        nextButton.disabled = currentPage === lastPage;
        nextButton.className = `h-9 min-w-9 rounded-lg px-3 text-sm font-semibold ${
            currentPage === lastPage
                ? 'text-outline cursor-not-allowed'
                : 'text-on-surface-variant hover:bg-surface-container'
        }`;

        nextButton.addEventListener('click', () => {
            if (currentPage < lastPage) loadEnrollments(currentPage + 1);
        });

        pagination.appendChild(nextButton);
    }

    searchInput.addEventListener('input', function () {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(() => loadEnrollments(1), 300);
    });

    classFilter.addEventListener('change', function () {
        renderSectionFilter(this.value);
        loadEnrollments(1);
    });

    sectionFilter.addEventListener('change', function () {
        loadEnrollments(1);
    });

    document.getElementById('openModalBtn').addEventListener('click', function () {
        form.reset();
        formId.value = '';
        formStatus.checked = true;
        formError.classList.add('hidden');
        formError.textContent = '';

        document.getElementById('modalTitle').textContent = 'Add Student Enrollment';
        document.getElementById('modalSubtitle').textContent = 'Enroll a student in a class and section.';
        document.getElementById('saveEnrollmentText').textContent = 'Save Enrollment';

        formSection.innerHTML = '<option value="">Select section</option>';
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    });

    document.getElementById('closeModalBtn').addEventListener('click', closeModal);
    document.getElementById('cancelModalBtn').addEventListener('click', closeModal);

    function closeModal() {
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    formClass.addEventListener('change', function () {
        renderFormSections(this.value);
    });

    window.editEnrollment = async function (id) {
        try {
            const result = await apiRequest(`${API_URL}/${id}`);
            const enrollment = result.data;

            formId.value = enrollment.id;
            formStudent.value = enrollment.student?.id ?? '';
            formClass.value = enrollment.class?.id ?? '';

            renderFormSections(formClass.value, enrollment.section?.id ?? '');

            formSession.value = enrollment.academic_session?.id ?? '';
            formDate.value = enrollment.enrollment_date ?? '';
            formStatus.checked = Number(enrollment.status) === 1 || enrollment.status === true;

            formError.classList.add('hidden');
            formError.textContent = '';

            document.getElementById('modalTitle').textContent = 'Edit Student Enrollment';
            document.getElementById('modalSubtitle').textContent = 'Update student enrollment information.';
            document.getElementById('saveEnrollmentText').textContent = 'Update Enrollment';

            modal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
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

        const payload = {
            student_id: formStudent.value,
            class_id: formClass.value,
            section_id: formSection.value,
            academic_session_id: formSession.value,
            enrollment_date: formDate.value
        };

        if (!editing) {
            payload.status = formStatus.checked ? 1 : 0;
        }

        const button = document.getElementById('saveEnrollmentBtn');
        const saveText = document.getElementById('saveEnrollmentText');

        button.disabled = true;
        saveText.textContent = editing ? 'Updating...' : 'Saving...';

        try {
            const result = await apiRequest(
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

            closeModal();

            showToast(
                result.message ||
                (editing ? 'Enrollment updated successfully.' : 'Student enrolled successfully.'),
                'check_circle'
            );

            await loadEnrollments(currentPage);
        } catch (error) {
            formError.textContent = error.message;
            formError.classList.remove('hidden');
        } finally {
            button.disabled = false;
            saveText.textContent = editing ? 'Update Enrollment' : 'Save Enrollment';
        }
    });

    window.viewEnrollment = async function (id) {
        viewModal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');

        viewName.textContent = 'Loading...';
        viewCode.textContent = '';
        viewClass.textContent = '—';
        viewSection.textContent = '—';
        viewSession.textContent = '—';
        viewStatus.innerHTML = '';
        viewStatusDetail.innerHTML = '—';
        viewSubjects.innerHTML = '—';

        viewAvatar.innerHTML = `
            <div class="w-14 h-14 rounded-full bg-surface-container flex items-center justify-center">
                <span class="material-symbols-outlined animate-spin text-primary">progress_activity</span>
            </div>
        `;

        try {
            const result = await apiRequest(`${API_URL}/${id}`);
            const enrollment = result.data;
            const student = enrollment.student || {};
            const name = student.name || '—';
            const picture = getProfilePictureUrl(student.profile_picture);

            viewAvatar.innerHTML = picture
                ? `
                    <img src="${picture}" alt="${escapeHtml(name)}" class="w-14 h-14 rounded-full object-cover">
                `
                : `
                    <div class="w-14 h-14 rounded-full bg-primary text-on-primary flex items-center justify-center text-lg font-semibold">
                        ${escapeHtml(getInitials(name))}
                    </div>
                `;

            viewName.textContent = name;
            viewCode.textContent = student.student_code || '—';
            viewClass.textContent = enrollment.class?.name || '—';
            viewSection.textContent = enrollment.section?.name || '—';
            viewSession.textContent = enrollment.academic_session?.name || '—';

            const active = Number(enrollment.status) === 1 || enrollment.status === true;

            const statusHtml = active
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

            viewStatus.innerHTML = statusHtml;
            viewStatusDetail.innerHTML = statusHtml;

            renderSubjects(enrollment.subjects);
        } catch (error) {
            closeViewEnrollmentModal();
            showToast(error.message, 'error');
        }
    };

    function renderSubjects(subjects) {
        if (!Array.isArray(subjects) || subjects.length === 0) {
            viewSubjects.innerHTML = `
                <div class="py-2 text-sm text-on-surface-variant">No subjects found.</div>
            `;
            return;
        }

        viewSubjects.innerHTML = subjects.map(subject => `
            <div class="flex items-center justify-between rounded-lg bg-surface-container px-3 py-2">
                <span class="font-medium text-on-surface">${escapeHtml(subject.name || subject.subject?.name || '—')}</span>
                ${
                    subject.code
                        ? `
                            <span class="text-xs text-on-surface-variant">${escapeHtml(subject.code)}</span>
                        `
                        : ''
                }
            </div>
        `).join('');
    }

    function closeViewEnrollmentModal() {
        viewModal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    document.getElementById('closeViewEnrollmentModal').addEventListener('click', closeViewEnrollmentModal);
    document.getElementById('closeViewEnrollmentButton').addEventListener('click', closeViewEnrollmentModal);

    viewModal.addEventListener('click', function (event) {
        if (event.target === viewModal) closeViewEnrollmentModal();
    });

    window.toggleEnrollmentStatus = async function (id) {
        try {
            const result = await apiRequest(`${API_URL}/${id}/status`, { method: 'PATCH' });

            showToast(result.message || 'Enrollment status updated successfully.', 'check_circle');
            await loadEnrollments(currentPage);
        } catch (error) {
            showToast(error.message, 'error');
        }
    };

    window.deleteEnrollment = function (id) {
        const enrollment = allEnrollments.find(item => Number(item.id) === Number(id));

        if (!enrollment) {
            showToast('Enrollment not found.', 'error');
            return;
        }

        selectedEnrollmentId = id;

        const studentName = enrollment.student?.name || 'this student';
        const className = enrollment.class?.name || '—';
        const sectionName = enrollment.section?.name || '—';

        deleteMessage.innerHTML = `
            <div class="flex items-start gap-3">
                <span class="material-symbols-outlined text-[22px]">delete</span>
                <div>
                    <p class="font-semibold">Delete ${escapeHtml(studentName)}'s enrollment?</p>
                    <p class="mt-1">This will remove the enrollment from ${escapeHtml(className)} - ${escapeHtml(sectionName)}.</p>
                </div>
            </div>
        `;

        deleteModal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    };

    function closeDeleteEnrollmentModal() {
        deleteModal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
        selectedEnrollmentId = null;
    }

    document.getElementById('closeDeleteEnrollmentModal').addEventListener('click', closeDeleteEnrollmentModal);
    document.getElementById('cancelDeleteEnrollment').addEventListener('click', closeDeleteEnrollmentModal);

    deleteModal.addEventListener('click', function (event) {
        if (event.target === deleteModal) closeDeleteEnrollmentModal();
    });

    confirmDelete.addEventListener('click', async function () {
        if (!selectedEnrollmentId) return;

        const id = selectedEnrollmentId;

        confirmDelete.disabled = true;
        confirmDelete.textContent = 'Deleting...';

        try {
            const result = await apiRequest(`${API_URL}/${id}`, { method: 'DELETE' });

            closeDeleteEnrollmentModal();

            showToast(result.message || 'Enrollment deleted successfully.', 'delete');
            await loadEnrollments(currentPage);
        } catch (error) {
            showToast(error.message || 'Unable to delete enrollment.', 'error');
        } finally {
            confirmDelete.disabled = false;
            confirmDelete.textContent = 'Delete Enrollment';
        }
    });

    function showToast(message, icon = 'check_circle') {
        const toast = document.getElementById('toastNotification');

        document.getElementById('toastMessage').textContent = message;
        document.getElementById('toastIcon').textContent = icon;

        toast.classList.remove('translate-y-16', 'opacity-0', 'pointer-events-none');
        toast.classList.add('translate-y-0', 'opacity-100');

        setTimeout(() => {
            toast.classList.add('translate-y-16', 'opacity-0', 'pointer-events-none');
            toast.classList.remove('translate-y-0', 'opacity-100');
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
        if (!path) return '';

        if (path.startsWith('http://') || path.startsWith('https://') || path.startsWith('/')) {
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

    loadOptions().then(() => {
        loadEnrollments();
    });
})();
</script>

@endsection