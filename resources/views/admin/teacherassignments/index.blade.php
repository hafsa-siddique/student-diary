@extends('layouts.admin')

@section('title', 'Teacher Assignments')

@section('content')

<div class="flex flex-col gap-space-lg w-full">
    <div class="flex flex-col gap-1">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-space-md mt-2">
            <div>
                <h1 class="font-headline-lg text-headline-lg text-on-surface tracking-tight">Teacher Assignments</h1>
                <p class="font-body-md text-body-md text-on-surface-variant mt-0.5">
                    Manage faculty assignments to classes, sections and subjects.
                </p>
            </div>
            <button type="button" id="openModalBtn"
                class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-primary-container text-on-primary hover:bg-primary transition-all rounded-lg shadow-sm font-label-lg text-label-lg active:scale-[0.98]">
                <span class="material-symbols-outlined text-[20px]">add</span>
                Add Assignment
            </button>
        </div>
    </div>

<div class="space-y-space-md">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <div class="bg-surface-container-lowest p-space-md rounded-xl shadow-sm flex items-center justify-between">
            <div class="flex flex-col">
                <span class="font-label-sm text-label-sm text-outline uppercase tracking-wider">Total Assignments</span>
                <span id="totalAssignments" class="font-display-lg text-display-lg text-on-surface mt-1 font-tabular-numeric">—</span>
                <span class="font-body-sm text-body-sm text-primary flex items-center gap-1 mt-0.5">
                    <span class="material-symbols-outlined text-[16px]">assignment_ind</span>
                    All faculty assignments
                </span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-surface-container flex items-center justify-center text-primary">
                <span class="material-symbols-outlined text-[26px]">assignment_ind</span>
            </div>
        </div>

        <div class="bg-surface-container-lowest p-space-md rounded-xl shadow-sm flex items-center justify-between">
            <div class="flex flex-col">
                <span class="font-label-sm text-label-sm text-outline uppercase tracking-wider">Active Assignments</span>
                <span id="activeAssignments" class="font-display-lg text-display-lg text-secondary mt-1 font-tabular-numeric">—</span>
                <span id="activePercentage" class="font-body-sm text-body-sm text-on-surface-variant flex items-center gap-1 mt-0.5">Loading...</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-surface-container flex items-center justify-center text-secondary">
                <span class="material-symbols-outlined text-[26px]">check_circle</span>
            </div>
        </div>

        <div class="bg-surface-container-lowest p-space-md rounded-xl shadow-sm flex items-center justify-between">
            <div class="flex flex-col">
                <span class="font-label-sm text-label-sm text-outline uppercase tracking-wider">Inactive Assignments</span>
                <span id="inactiveAssignments" class="font-display-lg text-display-lg text-tertiary mt-1 font-tabular-numeric">—</span>
                <span class="font-body-sm text-body-sm text-on-surface-variant flex items-center gap-1 mt-0.5">
                    Inactive faculty assignments
                </span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-tertiary-fixed flex items-center justify-center text-tertiary">
                <span class="material-symbols-outlined text-[26px]">cancel</span>
            </div>
        </div>
    </div>

    <div class="bg-surface-container-lowest p-space-md rounded-xl shadow-sm">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
            <div class="relative">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[20px]">search</span>
                <input type="text" id="teacherSearch"
                    class="w-full h-10 pl-10 pr-4 rounded-lg bg-surface text-on-surface font-body-sm text-body-sm placeholder:text-outline focus:outline-none focus:bg-surface-container-lowest focus:shadow-sm transition-all"
                    placeholder="Search faculty name">
            </div>

            <div class="relative">
                <select id="classFilter"
                    class="w-full h-10 pl-3 pr-8 rounded-lg bg-surface font-label-md text-label-md text-on-surface appearance-none cursor-pointer focus:outline-none">
                    <option value="all">All Classes</option>
                </select>
                <span class="material-symbols-outlined absolute right-2.5 top-1/2 -translate-y-1/2 text-outline text-[18px] pointer-events-none">expand_more</span>
            </div>

            <div class="relative">
                <select id="subjectFilter"
                    class="w-full h-10 pl-3 pr-8 rounded-lg bg-surface font-label-md text-label-md text-on-surface appearance-none cursor-pointer focus:outline-none">
                    <option value="all">All Subjects</option>
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
                        <th class="py-3 px-6">Faculty Name</th>
                        <th class="py-3 px-6">Class</th>
                        <th class="py-3 px-6">Section</th>
                        <th class="py-3 px-6">Subject</th>
                        <th class="py-3 px-4 text-center">Status</th>
                        <th class="py-3 px-4 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody id="assignmentTableBody"
                    class="divide-y divide-surface-container font-body-md text-body-md text-on-surface">
                    <tr>
                        <td colspan="7" class="py-10 text-center text-on-surface-variant">
                            <div class="flex items-center justify-center gap-2">
                                <span class="material-symbols-outlined animate-spin text-[22px]">
                                    progress_activity
                                </span>
                                Loading teacher assignments...
                            </div>    
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="p-space-md bg-surface-container-lowest flex flex-col sm:flex-row items-center justify-between gap-space-md border-t border-surface-container">
            <div id="assignmentPaginationInfo" class="font-body-sm text-body-sm text-on-surface-variant">Loading...</div>
            <div id="assignmentPagination" class="flex items-center gap-1 font-label-md text-label-md"></div>
        </div>
    </div>
</div>

</div>

<div id="assignTeacherModal"
    class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4"
    role="dialog" aria-modal="true" aria-labelledby="assignTeacherModalTitle">
    <div class="w-full max-w-3xl max-h-[90vh] overflow-hidden rounded-2xl bg-surface-container-lowest shadow-xl flex flex-col">
        <div class="flex items-center justify-between border-b border-outline-variant p-5 shrink-0">
            <div>
                <h2 id="assignTeacherModalTitle" class="font-headline-md text-headline-md text-on-surface">Assign Teacher</h2>
                <p id="assignmentModalSubtitle" class="mt-1 text-sm text-on-surface-variant">
                    Assign a teacher to a class, section, subject, and academic session.
                </p>
            </div>
            <button type="button" id="closeAssignTeacherModalBtn"
                class="rounded-lg p-2 text-on-surface-variant hover:bg-surface-container" aria-label="Close modal">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

    <form id="assignTeacherForm" class="flex flex-col min-h-0">
        <div class="grid grid-cols-1 gap-4 p-5 sm:grid-cols-2 overflow-y-auto">
            <div class="sm:col-span-2">
                <label for="assignmentTeacherId" class="mb-1 block text-sm font-medium text-on-surface">Teacher *</label>
                <select id="assignmentTeacherId" name="teacher_id" required
                    class="w-full rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface">
                    <option value="">Loading teachers...</option>
                </select>
            </div>

            <div>
                <label for="assignmentClassId" class="mb-1 block text-sm font-medium text-on-surface">Class *</label>
                <select id="assignmentClassId" name="class_id" required
                    class="w-full rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface">
                    <option value="">Loading classes...</option>
                </select>
            </div>

            <div>
                <label for="assignmentSectionId" class="mb-1 block text-sm font-medium text-on-surface">Section *</label>
                <select id="assignmentSectionId" name="section_id" required disabled
                    class="w-full rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface">
                    <option value="">Select a class first</option>
                </select>
            </div>

            <div>
                <label for="assignmentSubjectId" class="mb-1 block text-sm font-medium text-on-surface">Subject *</label>
                <select id="assignmentSubjectId" name="subject_id" required
                    class="w-full rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface">
                    <option value="">Loading subjects...</option>
                </select>
            </div>

            <div>
                <label for="assignmentAcademicSessionId" class="mb-1 block text-sm font-medium text-on-surface">Academic Session *</label>
                <select id="assignmentAcademicSessionId" name="academic_session_id" required
                    class="w-full rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface">
                    <option value="">Loading sessions...</option>
                </select>
            </div>
            <div class="sm:col-span-2 flex items-center gap-2 mt-2">
                <input type="checkbox" id="assignmentInchargeToggle" name="is_incharge" value="1">
                <label for="assignmentInchargeToggle" class="text-sm text-on-surface">Assign as Class In-charge</label>
            </div>
            <div class="sm:col-span-2 flex items-center gap-2">
                <input type="checkbox" id="assignmentStatusToggle" name="status" value="1" checked>
                <label for="assignmentStatusToggle" class="text-sm text-on-surface">Assignment active</label>
            </div>
        </div>

        <div id="assignTeacherFormError"
            class="hidden mx-5 mb-4 rounded-lg bg-red-50 p-3 text-sm text-red-700" role="alert"></div>

        <div class="flex justify-end gap-3 border-t border-outline-variant p-5 shrink-0 bg-surface-container-lowest">
            <button type="button" id="cancelAssignTeacherModalBtn"
                class="rounded-lg border border-outline-variant px-4 py-2 text-sm font-medium text-on-surface hover:bg-surface-container">
                Cancel
            </button>
            <button type="submit" id="saveAssignmentBtn"
                class="rounded-lg bg-primary px-5 py-2 text-sm font-semibold text-white hover:opacity-90">
                <span id="saveAssignmentText">Assign Teacher</span>
            </button>
        </div>
    </form>
</div>

</div>

<div id="deleteAssignmentModal"
    class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
    <div class="w-full max-w-md rounded-2xl bg-surface-container-lowest shadow-xl">
        <div class="border-b border-outline-variant p-5">
            <h2 class="font-headline-md text-headline-md text-on-surface">Delete Assignment</h2>
        </div>
        <div class="p-5">
            <div id="deleteAssignmentMessage" class="rounded-lg p-4 text-sm"></div>
        </div>
        <div class="flex justify-end gap-3 border-t border-outline-variant p-5">
            <button type="button" id="cancelDeleteAssignmentButton"
                class="rounded-lg border border-outline-variant px-4 py-2 text-sm font-medium text-on-surface">
                Cancel
            </button>
            <button type="button" id="confirmDeleteAssignmentButton"
                class="hidden rounded-lg bg-red-600 px-5 py-2 text-sm font-semibold text-white">
                Delete Assignment
            </button>
        </div>
    </div>
</div>

<div id="viewAssignmentModal"
    class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
    <div class="w-full max-w-lg rounded-2xl bg-surface-container-lowest shadow-xl">
        <div class="flex items-center justify-between border-b border-outline-variant p-5">
            <div>
                <h2 class="font-headline-md text-headline-md text-on-surface">Assignment Details</h2>
                <p class="mt-1 text-sm text-on-surface-variant">View faculty assignment information</p>
            </div>
            <button type="button" id="closeViewAssignmentModal"
                class="rounded-lg p-2 text-on-surface-variant hover:bg-surface-container">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

    <div class="p-5">
        <div class="flex items-center gap-4 pb-5">
            <div id="viewAssignmentAvatar"></div>
            <div class="flex-1 min-w-0">
                <div class="flex items-center justify-between gap-4 flex-wrap">
                    <h3 id="viewAssignmentTeacher" class="text-lg font-semibold text-on-surface">—</h3>
                    <div id="viewAssignmentStatus">—</div>
                </div>
                <p id="viewAssignmentClass" class="mt-2 text-sm text-on-surface-variant">—</p>
                <p id="viewAssignmentSection" class="mt-1 text-sm text-on-surface-variant">—</p>
                <p id="viewAssignmentSubject" class="mt-1 text-sm text-on-surface-variant">—</p>
            </div>
        </div>
    </div>

    <div class="flex justify-end border-t border-outline-variant p-5">
        <button type="button" id="closeViewAssignmentButton"
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
    const API_URL = '/api/v1/admin/teacher-assignments';
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
    const tableBody = $('assignmentTableBody');
    const teacherSearch = $('teacherSearch');
    const classFilter = $('classFilter');
    const subjectFilter = $('subjectFilter');
    const pagination = $('assignmentPagination');
    const paginationInfo = $('assignmentPaginationInfo');
    const modal = $('assignTeacherModal');
    const form = $('assignTeacherForm');
    const assignmentTeacher = $('assignmentTeacherId');
    const assignmentClass = $('assignmentClassId');
    const assignmentSection = $('assignmentSectionId');
    const assignmentSubject = $('assignmentSubjectId');
    const assignmentAcademicSession = $('assignmentAcademicSessionId');
    const assignmentStatus = $('assignmentStatusToggle');
    const assignmentIncharge = $('assignmentInchargeToggle');
    const formError = $('assignTeacherFormError');
    const saveButton = $('saveAssignmentBtn');
    const saveText = $('saveAssignmentText');
    const deleteModal = $('deleteAssignmentModal');
    const deleteMessage = $('deleteAssignmentMessage');
    const deleteButton = $('confirmDeleteAssignmentButton');
    const viewModal = $('viewAssignmentModal');
    const viewAvatar = $('viewAssignmentAvatar');
    const viewTeacher = $('viewAssignmentTeacher');
    const viewClass = $('viewAssignmentClass');
    const viewSection = $('viewAssignmentSection');
    const viewSubject = $('viewAssignmentSubject');
    const viewStatus = $('viewAssignmentStatus');

    let sections = [];
    let allAssignments = [];
    let currentPage = 1;
    let lastPage = 1;
    let perPage = 5;
    let selectedAssignmentId = null;
    let editingAssignmentId = null;
    let searchTimer;
    let optionsLoaded = false;
    let optionsPromise = null;

    function logout() {
        localStorage.removeItem('student_diary_token');
        localStorage.removeItem('student_diary_user');
        localStorage.removeItem('student_diary_institute_code');
        window.location.replace('/');
    }

    function getData(result) {
        return result.data?.data ?? result.data ?? [];
    }

    function getAssignment(result) {
        return result.data?.data ?? result.data ?? {};
    }

    async function loadAssignments(page = 1) {
        try {
            tableBody.innerHTML = `
                <tr>
                    <td colspan="7" class="py-10 text-center text-on-surface-variant">
                        Loading teacher assignments...
                    </td>
                </tr>`;

            const params = new URLSearchParams({ page });
            const name = teacherSearch.value.trim();
            const classId = classFilter.value;
            const subjectId = subjectFilter.value;

            if (name) params.set('search', name);
            if (classId !== 'all') params.set('class_id', classId);
            if (subjectId !== 'all') params.set('subject_id', subjectId);

            const response = await fetch(`${API_URL}?${params}`, { headers });

            if (response.status === 401) return logout();

            const result = await response.json();

            if (!response.ok || !result.status) {
                throw new Error(result.message || 'Failed to load teacher assignments.');
            }

            const assignmentData = getData(result);
            allAssignments = Array.isArray(assignmentData) ? assignmentData : [];

            const meta = result.data?.meta ?? result.meta ?? {};
            perPage = Number(meta.per_page || 5);
            currentPage = Number(meta.current_page || page);
            lastPage = Number(meta.last_page || 1);

            updateStatistics(result);
            renderAssignments();
            renderPagination(meta);
        } catch (error) {
            console.error(error);
            tableBody.innerHTML = `
                <tr>
                    <td colspan="7" class="py-10 text-center text-error">
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
        const percentage = total ? ((active / total) * 100).toFixed(1) : '0.0';

        $('totalAssignments').textContent = total;
        $('activeAssignments').textContent = active;
        $('inactiveAssignments').textContent = inactive;
        $('activePercentage').innerHTML = `
            <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span>
            ${percentage}% active`;
    }

    function getTeacherName(assignment) {
        const teacher = assignment.teacher || {};
        return teacher.user?.name || teacher.name ||
            assignment.teacher_name || '—';
    }

    function renderAssignments() {
        if (!allAssignments.length) {
            tableBody.innerHTML = `
                <tr>
                    <td colspan="7" class="py-10 text-center text-on-surface-variant">
                        No teacher assignments found.
                    </td>
                </tr>`;
            return;
        }

        tableBody.innerHTML = allAssignments.map((assignment, index) => {
            const teacher = assignment.teacher || {};
            const classItem = assignment.class || {};
            const section = assignment.section || {};
            const subject = assignment.subject || {};
            const teacherName = getTeacherName(assignment);
            const className = classItem.name || assignment.class_name || '—';
            const sectionName = section.name || assignment.section_name || '—';
            const subjectName = subject.name || assignment.subject_name || '—';
            const active = Number(assignment.status) === 1;

            return `
                <tr>
                    <td class="py-3 px-4 text-center">
                        ${((currentPage - 1) * perPage) + index + 1}
                    </td>
                    <td class="py-3 px-6">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-lg bg-primary text-on-primary flex items-center justify-center font-semibold">
                                ${escapeHtml(getInitials(teacherName))}
                            </div>
                            <div class="font-medium text-on-surface">
                                ${escapeHtml(teacherName)}
                            </div>
                        </div>
                    </td>
                    <td class="py-3 px-6">${escapeHtml(className)}</td>
                    <td class="py-3 px-6">${escapeHtml(sectionName)}</td>
                    <td class="py-3 px-6">
                        <span class="font-medium">${escapeHtml(subjectName)}</span>
                    </td>
                    <td class="py-3 px-4 text-center">
                        <span class="inline-flex items-center gap-1.5 text-xs font-semibold
                            ${active ? 'text-secondary' : 'text-outline'}">
                            <span class="w-1.5 h-1.5 rounded-full
                                ${active ? 'bg-secondary' : 'bg-outline'}"></span>
                            ${active ? 'Active' : 'Inactive'}
                        </span>
                    </td>
                    <td class="py-3 px-4">
                        <div class="flex items-center justify-center gap-1">
                            <button type="button" onclick="viewAssignment(${assignment.id})"
                                class="p-2 rounded-lg text-on-surface-variant hover:bg-surface-container"
                                title="View">
                                <span class="material-symbols-outlined text-[20px]">visibility</span>
                            </button>
                            <button type="button" onclick="editAssignment(${assignment.id})"
                                class="p-2 rounded-lg text-on-surface-variant hover:bg-surface-container"
                                title="Edit">
                                <span class="material-symbols-outlined text-[20px]">edit</span>
                            </button>
                            <button type="button" onclick="toggleAssignmentStatus(${assignment.id})"
                                class="p-2 rounded-lg text-on-surface-variant hover:bg-surface-container"
                                title="${active ? 'Deactivate' : 'Activate'}">
                                <span class="material-symbols-outlined text-[20px]">
                                    ${active ? 'person_off' : 'how_to_reg'}
                                </span>
                            </button>
                            <button type="button" onclick="deleteAssignment(${assignment.id})"
                                class="p-2 rounded-lg text-error hover:bg-red-50" title="Delete">
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
            ? `Showing ${from}–${to} of ${total} assignments`
            : 'Showing 0 assignments';

        if (lastPage <= 1) return;

        const button = (text, disabled, action, active = false) => {
            const el = document.createElement('button');
            el.type = 'button';
            el.innerHTML = text;
            el.disabled = disabled;
            el.className = `
                min-w-8 px-2 py-1.5 rounded-lg text-sm
                ${active ? 'bg-primary text-on-primary' :
                'text-on-surface hover:bg-surface-container'}
                disabled:opacity-40`;
            el.onclick = action;
            pagination.appendChild(el);
        };

        button(
            '<span class="material-symbols-outlined text-[18px]">chevron_left</span>',
            currentPage === 1,
            () => loadAssignments(currentPage - 1)
        );

        for (let page = 1; page <= lastPage; page++) {
            button(page, false, () => loadAssignments(page), page === currentPage);
        }

        button(
            '<span class="material-symbols-outlined text-[18px]">chevron_right</span>',
            currentPage === lastPage,
            () => loadAssignments(currentPage + 1)
        );
    }

    teacherSearch.addEventListener('input', () => {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(() => loadAssignments(1), 300);
    });

    classFilter.addEventListener('change', () => loadAssignments(1));
    subjectFilter.addEventListener('change', () => loadAssignments(1));

    async function loadFilterOptions() {
        if (optionsLoaded) return;
        if (optionsPromise) return optionsPromise;

        optionsPromise = (async () => {
            try {
                const responses = await Promise.all([
                    fetch('/api/v1/admin/teachers?per_page=1000', { headers }),
                    fetch('/api/v1/admin/classes?per_page=1000', { headers }),
                    fetch('/api/v1/admin/sections?per_page=1000', { headers }),
                    fetch('/api/v1/admin/subjects?per_page=1000', { headers }),
                    fetch('/api/v1/admin/academic-sessions?per_page=1000', { headers })
                ]);

                if (responses.some(response => response.status === 401)) {
                    logout();
                    return;
                }

                if (responses.some(response => !response.ok)) {
                    throw new Error('Unable to load assignment options.');
                }

                const [
                    teacherResult,
                    classResult,
                    sectionResult,
                    subjectResult,
                    sessionResult
                ] = await Promise.all(responses.map(response => response.json()));

                const teachers = getData(teacherResult);
                const classes = getData(classResult);
                sections = getData(sectionResult);
                const subjects = getData(subjectResult);
                const sessions = getData(sessionResult);

                assignmentTeacher.innerHTML =
                    '<option value="">Select teacher</option>';

                assignmentClass.innerHTML =
                    '<option value="">Select class</option>';

                assignmentSubject.innerHTML =
                    '<option value="">Select subject</option>';

                assignmentAcademicSession.innerHTML =
                    '<option value="">Select academic session</option>';

                teachers.forEach(teacher => {
                    const name = teacher.user?.name || teacher.name ||
                        teacher.user?.email || `Teacher #${teacher.id}`;
                    assignmentTeacher.appendChild(new Option(name, teacher.id));
                });

                classes.forEach(item => {
                    classFilter.appendChild(new Option(item.name, item.id));
                    assignmentClass.appendChild(new Option(item.name, item.id));
                });

                subjects.forEach(item => {
                    const name = item.name || item.code || `Subject #${item.id}`;
                    subjectFilter.appendChild(new Option(name, item.id));
                    assignmentSubject.appendChild(new Option(name, item.id));
                });

                sessions.forEach(item => {
                    assignmentAcademicSession.appendChild(
                        new Option(item.name || `Session #${item.id}`, item.id)
                    );
                });

                const currentSession =
                    sessionResult.current_session ||
                    sessionResult.data?.current_session;

                if (currentSession?.id) {
                    assignmentAcademicSession.value =
                        String(currentSession.id);
                }

                optionsLoaded = true;
            } catch (error) {
                optionsPromise = null;
                console.error(error);
                throw error;
            }
        })();

        return optionsPromise;
    }

    function loadSections(classId, selectedId = '') {
        assignmentSection.innerHTML = '';
        assignmentSection.disabled = true;

        if (!classId) {
            assignmentSection.innerHTML =
                '<option value="">Select class first</option>';
            return;
        }

        const matchingSections = sections.filter(section =>
            Number(section.class_id) === Number(classId)
        );

        if (!matchingSections.length) {
            assignmentSection.innerHTML =
                '<option value="">No sections available</option>';
            return;
        }

        assignmentSection.innerHTML =
            '<option value="">Select section</option>';

        matchingSections.forEach(section => {
            assignmentSection.appendChild(
                new Option(section.name, section.id)
            );
        });

        assignmentSection.disabled = false;

        if (selectedId) {
            assignmentSection.value = String(selectedId);
        }
    }

    assignmentClass.addEventListener('change', () => {
        loadSections(assignmentClass.value);
    });

    $('openModalBtn').addEventListener('click', async () => {
        form.reset();
        editingAssignmentId = null;
        assignmentStatus.checked = true;
        assignmentIncharge.checked = false;
        $('assignTeacherModalTitle').textContent = 'Add Teacher Assignment';
        $('assignmentModalSubtitle').textContent =
            'Assign a faculty member to a class, section, subject and academic session.';
        saveText.textContent = 'Save Assignment';
        clearAssignmentError();
        loadSections('');
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');

        try {
            await loadFilterOptions();
        } catch (error) {
            showAssignmentError(error.message);
        }
    });

    function closeModal() {
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
        clearAssignmentError();
    }

    $('closeAssignTeacherModalBtn').addEventListener('click', closeModal);
    $('cancelAssignTeacherModalBtn').addEventListener('click', closeModal);

    modal.addEventListener('click', event => {
        if (event.target === modal) closeModal();
    });

    window.editAssignment = async id => {
        try {
            form.reset();
            clearAssignmentError();
            editingAssignmentId = id;
            modal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');

            $('assignTeacherModalTitle').textContent =
                'Edit Teacher Assignment';
            $('assignmentModalSubtitle').textContent =
                'Update faculty assignment information.';
            saveText.textContent = 'Update Assignment';

            await loadFilterOptions();

            const response = await fetch(`${API_URL}/${id}`, { headers });

            if (response.status === 401) return logout();

            const result = await response.json();

            if (!response.ok || !result.status) {
                throw new Error(result.message || 'Unable to load assignment.');
            }

            const assignment = getAssignment(result);
            const teacherId = assignment.teacher?.id ??
                assignment.teacher_id ?? '';
            const classId = assignment.class?.id ??
                assignment.class_id ?? '';
            const sectionId = assignment.section?.id ??
                assignment.section_id ?? '';
            const subjectId = assignment.subject?.id ??
                assignment.subject_id ?? '';
            const sessionId = assignment.academic_session?.id ??
                assignment.academic_session_id ?? '';

            assignmentTeacher.value = String(teacherId);
            assignmentClass.value = String(classId);
            assignmentSubject.value = String(subjectId);
            assignmentAcademicSession.value = String(sessionId);
            assignmentStatus.checked = Number(assignment.status) === 1;
            assignmentIncharge.checked = Number(assignment.is_incharge) === 1;

            loadSections(classId, sectionId);
        } catch (error) {
            console.error(error);
            showAssignmentError(error.message);
        }
    };

    form.addEventListener('submit', async event => {
        event.preventDefault();
        clearAssignmentError();

        const editing = Boolean(editingAssignmentId);

        const payload = {
            teacher_id: assignmentTeacher.value,
            class_id: assignmentClass.value,
            section_id: assignmentSection.value,
            subject_id: assignmentSubject.value,
            academic_session_id: assignmentAcademicSession.value,
            status: assignmentStatus.checked ? 1 : 0,
            is_incharge: assignmentIncharge.checked ? 1 : 0
        };

        if (Object.values(payload).slice(0, 5).some(value => !value)) {
            showAssignmentError('Please fill in all required fields.');
            return;
        }

        saveButton.disabled = true;
        saveText.textContent = editing ? 'Updating...' : 'Creating...';

        try {
            const response = await fetch(
                editing ? `${API_URL}/${editingAssignmentId}` : API_URL,
                {
                    method: editing ? 'PUT' : 'POST',
                    headers: {
                        ...headers,
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(payload)
                }
            );

            if (response.status === 401) return logout();

            const result = await response.json();

            if (!response.ok || !result.status) {
                const messages = result.errors
                    ? Object.values(result.errors).flat().join(' ')
                    : '';
                throw new Error(
                    messages || result.message ||
                    'Unable to save assignment.'
                );
            }

            closeModal();
            await loadAssignments(currentPage);
            showToast(
                result.message ||
                (editing
                    ? 'Teacher assignment updated successfully.'
                    : 'Teacher assignment created successfully.')
            );
        } catch (error) {
            console.error(error);
            showAssignmentError(error.message);
        } finally {
            saveButton.disabled = false;
            saveText.textContent =
                editing ? 'Update Assignment' : 'Save Assignment';
        }
    });

    window.viewAssignment = async id => {
        viewModal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
        viewTeacher.textContent = 'Loading...';
        viewClass.textContent = 'Loading...';
        viewSection.textContent = 'Loading...';
        viewSubject.textContent = 'Loading...';
        viewStatus.textContent = 'Loading...';

        try {
            const response = await fetch(`${API_URL}/${id}`, { headers });

            if (response.status === 401) return logout();

            const result = await response.json();

            if (!response.ok || !result.status) {
                throw new Error(result.message || 'Unable to load assignment.');
            }

            const assignment = getAssignment(result);
            const teacherName = getTeacherName(assignment);
            const className = assignment.class?.name ||
                assignment.class_name || '—';
            const sectionName = assignment.section?.name ||
                assignment.section_name || '—';
            const subjectName = assignment.subject?.name ||
                assignment.subject_name || '—';
            const active = Number(assignment.status) === 1;

            viewTeacher.textContent = teacherName;
            viewClass.textContent = `Class: ${className}`;
            viewSection.textContent = `Section: ${sectionName}`;
            viewSubject.textContent = `Subject: ${subjectName}`;

            viewStatus.innerHTML = `
                <span class="inline-flex items-center gap-1.5 text-xs font-semibold
                    ${active ? 'text-secondary' : 'text-outline'}">
                    <span class="w-1.5 h-1.5 rounded-full
                        ${active ? 'bg-secondary' : 'bg-outline'}"></span>
                    ${active ? 'Active' : 'Inactive'}
                </span>`;

            viewAvatar.innerHTML = `
                <div class="w-16 h-16 rounded-lg bg-primary text-on-primary
                    flex items-center justify-center font-semibold text-xl">
                    ${escapeHtml(getInitials(teacherName))}
                </div>`;
        } catch (error) {
            console.error(error);
            viewTeacher.textContent = error.message;
        }
    };

    function closeViewModal() {
        viewModal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    $('closeViewAssignmentModal').addEventListener('click', closeViewModal);
    $('closeViewAssignmentButton').addEventListener('click', closeViewModal);

    viewModal.addEventListener('click', event => {
        if (event.target === viewModal) closeViewModal();
    });

    window.toggleAssignmentStatus = async id => {
        try {
            const response = await fetch(`${API_URL}/${id}/status`, {
                method: 'PATCH',
                headers
            });

            if (response.status === 401) return logout();

            const result = await response.json();

            if (!response.ok || !result.status) {
                throw new Error(
                    result.message ||
                    'Unable to update assignment status.'
                );
            }

            showToast(
                result.message ||
                'Assignment status updated successfully.'
            );

            await loadAssignments(currentPage);
        } catch (error) {
            console.error(error);
            showToast(error.message, 'error');
        }
    };

    window.deleteAssignment = async id => {
        selectedAssignmentId = id;
        deleteMessage.className =
            'rounded-lg bg-amber-50 p-4 text-sm text-amber-700';
        deleteMessage.textContent = 'Checking assignment...';
        deleteButton.classList.add('hidden');
        deleteModal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');

        try {
            const response = await fetch(`${API_URL}/${id}`, { headers });

            if (response.status === 401) return logout();

            const result = await response.json();

            if (!response.ok || !result.status) {
                throw new Error(
                    result.message || 'Unable to load assignment.'
                );
            }

            const assignment = getAssignment(result);
            const teacherName = getTeacherName(assignment);
            const className = assignment.class?.name ||
                assignment.class_name || '—';
            const sectionName = assignment.section?.name ||
                assignment.section_name || '—';
            const subjectName = assignment.subject?.name ||
                assignment.subject_name || '—';

            deleteMessage.className =
                'rounded-lg bg-red-50 p-4 text-sm text-red-700';

            deleteMessage.innerHTML = `
                Are you sure you want to delete this assignment?
                <div class="mt-3 space-y-1">
                    <div><strong>Faculty:</strong> ${escapeHtml(teacherName)}</div>
                    <div><strong>Class:</strong> ${escapeHtml(className)}</div>
                    <div><strong>Section:</strong> ${escapeHtml(sectionName)}</div>
                    <div><strong>Subject:</strong> ${escapeHtml(subjectName)}</div>
                </div>
                <div class="mt-3">This action cannot be undone.</div>`;

            deleteButton.classList.remove('hidden');
        } catch (error) {
            console.error(error);
            deleteMessage.className =
                'rounded-lg bg-red-50 p-4 text-sm text-red-700';
            deleteMessage.textContent = error.message;
        }
    };

    deleteButton.addEventListener('click', deleteAssignmentAction);

    async function deleteAssignmentAction() {
        if (!selectedAssignmentId) return;

        const id = selectedAssignmentId;
        deleteButton.disabled = true;
        deleteButton.textContent = 'Deleting...';

        try {
            const response = await fetch(`${API_URL}/${id}`, {
                method: 'DELETE',
                headers
            });

            if (response.status === 401) return logout();

            const result = await response.json();

            if (!response.ok || !result.status) {
                throw new Error(
                    result.message ||
                    'Teacher assignment cannot be deleted.'
                );
            }

            closeDeleteModal();
            showToast(
                result.message ||
                'Teacher assignment deleted successfully.'
            );
            await loadAssignments(currentPage);
        } catch (error) {
            console.error(error);
            deleteMessage.className =
                'rounded-lg bg-red-50 p-4 text-sm text-red-700';
            deleteMessage.textContent = error.message;
        } finally {
            deleteButton.disabled = false;
            deleteButton.textContent = 'Delete Assignment';
        }
    }

    function closeDeleteModal() {
        deleteModal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
        selectedAssignmentId = null;
        deleteButton.disabled = false;
        deleteButton.textContent = 'Delete Assignment';
    }

    $('cancelDeleteAssignmentButton').addEventListener(
        'click',
        closeDeleteModal
    );

    deleteModal.addEventListener('click', event => {
        if (event.target === deleteModal) closeDeleteModal();
    });

    function clearAssignmentError() {
        formError.textContent = '';
        formError.classList.add('hidden');
    }

    function showAssignmentError(message) {
        formError.textContent = message;
        formError.classList.remove('hidden');
    }

    function showToast(message, icon = 'check_circle') {
        const toast = $('toastNotification');
        $('toastMessage').textContent = message;
        $('toastIcon').textContent = icon;

        toast.classList.remove(
            'translate-y-16',
            'opacity-0',
            'pointer-events-none'
        );

        toast.classList.add('translate-y-0', 'opacity-100');

        setTimeout(() => {
            toast.classList.add(
                'translate-y-16',
                'opacity-0',
                'pointer-events-none'
            );
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

    loadFilterOptions().catch(error => {
        console.error(error);
        showAssignmentError(error.message);
    });

    loadAssignments();
})();
</script>

@endsection
