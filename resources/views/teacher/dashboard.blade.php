@extends('layouts.teacher')

@section('title', 'Dashboard - Student Diary')

@section('content')

<div class="flex flex-col w-full gap-space-lg">

<!-- Header -->
<div class="flex flex-col md:flex-row md:items-center justify-between gap-space-md">
    <div class="flex flex-col">
        <div class="flex items-center gap-2 mt-4">
            <h1 id="teacherGreeting" class="font-headline-lg text-headline-lg text-on-surface tracking-tight">
                Good morning, Teacher
            </h1>
            <span class="font-label-sm text-label-sm bg-secondary-container text-on-secondary-container font-semibold px-2 py-0.5 rounded-full">
                Active
            </span>
        </div>
        <p class="font-body-md text-body-md text-on-surface-variant mt-0.5">
            Manage your assignments and student diaries from one place.
        </p>
    </div>

    <div class="flex items-center gap-space-sm">
        <a href="/teacher/diaries/create" id="openCreateDiaryModal"
           class="flex items-center gap-1.5 px-4 py-2 rounded-lg bg-primary text-white transition-all shadow-sm font-label-md text-label-md">
            <span class="material-symbols-outlined text-[18px]">edit_note</span>
            <span>Create Diary</span>
        </a>
    </div>
</div>

<!-- KPI Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-space-md">

    <!-- Classes -->
    <div class="bg-surface-container-lowest rounded-xl p-space-md shadow-sm hover:shadow-md transition-shadow border-l-4 border-l-primary border border-outline-variant/40  ">
        <div class="flex items-start justify-between">
            <span class="font-label-sm text-label-sm uppercase tracking-wider text-outline">
                My Classes
            </span>
            <div id="classCount"
                 class="font-display-lg text-display-lg text-on-surface font-tabular-numeric">
                0
            </div>
        </div>
    </div>

   <!-- Assignments -->

    <div class="bg-surface-container-lowest rounded-xl p-space-md shadow-sm hover:shadow-md transition-shadow border-l-4 border-l-secondary border border-outline-variant/40">
        <div class="flex items-start justify-between">
            <span class="font-label-sm text-label-sm uppercase tracking-wider text-outline">
                My Assignments
            </span>
            <div id="assignmentCount"
                class="font-display-lg text-display-lg text-on-surface font-tabular-numeric">
                0
            </div>
        </div>
    </div>


    <!-- Today's Diaries -->
    <div class="bg-surface-container-lowest rounded-xl p-space-md shadow-sm hover:shadow-md transition-shadow border-l-4 border-l-tertiary border border-outline-variant/40">
        <div class="flex items-start justify-between">
            <span class="font-label-sm text-label-sm uppercase tracking-wider text-outline">
                Remaining Diaries
            </span>
            <div id="todayRemaining"
                class="font-display-lg text-display-lg text-on-surface font-tabular-numeric">
                0
            </div>
        </div>
    </div>

    <!-- Scheduled -->
    <div class="bg-surface-container-lowest rounded-xl p-space-md shadow-sm hover:shadow-md transition-shadow border-l-4 border-l-outline border border-outline-variant/40">
        <div class="flex items-start justify-between">
            <span class="font-label-sm text-label-sm uppercase tracking-wider text-outline">
                Scheduled Queue
            </span>
            <div id="scheduledCount"
                 class="font-display-lg text-display-lg text-on-surface font-tabular-numeric">
                0
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="bg-surface-container-lowest rounded-xl p-space-md shadow-sm">
    <div class="flex items-center justify-between mb-3">
        <span class="font-label-sm text-label-sm uppercase tracking-wider text-outline">
            Teacher Shortcuts
        </span>
        <span class="font-label-sm text-label-sm text-on-surface-variant">
            Quick access
        </span>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-2">

        <a href="/teacher/diaries/create" id="openCreateDiaryModalShortcut"
           class="flex items-center gap-2 p-3 rounded-lg bg-surface-container-low hover:bg-surface-container hover:border-primary border border-outline-variant/30 hover:shadow-sm transition-all duration-300 ease-in-out hover:-translate-y-0.5 group">
            <span class="material-symbols-outlined text-primary">edit_note</span>
            <span class="font-label-md text-label-md text-on-surface">Create Diary</span>
        </a>

        <a href="/teacher/assignments" data-spa-link
           class="flex items-center gap-2 p-3 rounded-lg bg-surface-container-low hover:bg-surface-container hover:border-primary border border-outline-variant/30 hover:shadow-sm transition-all duration-300 ease-in-out hover:-translate-y-0.5 group">
            <span class="material-symbols-outlined text-primary">assignment</span>
            <span class="font-label-md text-label-md text-on-surface">My Assignments</span>
        </a>

        <a href="/teacher/diaries" data-spa-link
           class="flex items-center gap-2 p-3 rounded-lg bg-surface-container-low hover:bg-surface-container hover:border-primary border border-outline-variant/30 hover:shadow-sm transition-all duration-300 ease-in-out hover:-translate-y-0.5 group">
            <span class="material-symbols-outlined text-primary">menu_book</span>
            <span class="font-label-md text-label-md text-on-surface">My Diaries</span>
        </a>

        <a href="/teacher/scheduledDiaries" data-spa-link
           class="flex items-center gap-2 p-3 rounded-lg bg-surface-container-low hover:bg-surface-container hover:border-primary border border-outline-variant/30 hover:shadow-sm transition-all duration-300 ease-in-out hover:-translate-y-0.5 group">
            <span class="material-symbols-outlined text-primary">schedule</span>
            <span class="font-label-md text-label-md text-on-surface">Scheduled Diaries</span>
        </a>
    </div>
</div>

<!-- Main Content -->
<div class="grid grid-cols-1 lg:grid-cols-12 gap-space-lg">

    <!-- Recent Diaries -->
    <div class="lg:col-span-8 bg-surface-container-lowest rounded-xl shadow-sm overflow-hidden">

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 p-space-md border-b border-outline-variant">
            <div>
                <h2 class="font-headline-md text-headline-md text-on-surface">
                    Recent Diaries
                </h2>
                <p class="font-body-sm text-body-sm text-on-surface-variant mt-0.5">
                    Your latest classroom diary entries.
                </p>
            </div>

            <a href="/teacher/diaries" data-spa-link
               class="font-label-md text-label-md text-primary font-semibold">
                View All
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-surface-container-low">
                        <th class="text-left px-4 py-3 font-label-sm text-label-sm text-outline">
                            Subject & Topic
                        </th>
                        <th class="text-left px-4 py-3 font-label-sm text-label-sm text-outline">
                            Class
                        </th>
                        <th class="text-left px-4 py-3 font-label-sm text-label-sm text-outline">
                            Diary Date
                        </th>
                        <th class="text-left px-4 py-3 font-label-sm text-label-sm text-outline">
                            Status
                        </th>
                    </tr>
                </thead>
                <tbody id="recentDiaries">
                    <tr>
                        <td colspan="4" class="px-4 py-8 text-center text-on-surface-variant">
                            Loading diaries...
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div id="diaryFooter"
             class="hidden px-4 py-3 border-t border-outline-variant flex items-center justify-between">
            <span class="font-body-sm text-body-sm text-on-surface-variant">
                Showing your latest diary entries
            </span>
        </div>
    </div>

    <!-- Assignment Overview -->
    <div class="lg:col-span-4 bg-surface-container-lowest rounded-xl shadow-sm">

        <div class="p-space-md border-b border-outline-variant">
            <h2 class="font-headline-md text-headline-md text-on-surface">
                My Assignment Overview
            </h2>
            <p class="font-body-sm text-body-sm text-on-surface-variant mt-0.5">
                Your current teaching allocations.
            </p>
        </div>

        <div class="p-space-md">
            <div class="flex items-center justify-between mb-4">
                <span class="font-label-sm text-label-sm text-outline uppercase tracking-wider">
                    Academic Session
                </span>
                <span id="sessionName"
                      class="font-label-md text-label-md text-primary font-semibold">
                    —
                </span>
            </div>

            <div id="assignmentList" class="flex flex-col gap-2">
                <div class="p-3 rounded-lg bg-surface-container-low text-center text-on-surface-variant">
                    Loading assignments...
                </div>
            </div>

            <a href="/teacher/assignments" data-spa-link
               class="flex items-center justify-center gap-1.5 w-full mt-4 px-3 py-2 rounded-lg bg-primary text-white font-label-md text-label-md">
                View My Assignments
                <span class="material-symbols-outlined text-[17px]">arrow_forward</span>
            </a>
        </div>
    </div>
</div>

<!-- Diary Status Summary -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-space-md">

    <div class="bg-surface-container-lowest rounded-xl p-space-md shadow-sm">
        <div class="flex items-center gap-3">
            <div class="p-2 rounded-lg bg-surface-container text-secondary">
                <span class="material-symbols-outlined">check_circle</span>
            </div>
            <div>
                <p class="font-label-sm text-label-sm text-outline uppercase tracking-wider">
                    Published Today
                </p>
                <p id="publishedSummary"
                   class="font-headline-md text-headline-md text-on-surface mt-0.5">
                    0
                </p>
            </div>
        </div>
    </div>

    <div class="bg-surface-container-lowest rounded-xl p-space-md shadow-sm">
        <div class="flex items-center gap-3">
            <div class="p-2 rounded-lg bg-surface-container-low text-primary">
                <span class="material-symbols-outlined">draft</span>
            </div>
            <div>
                <p class="font-label-sm text-label-sm text-outline uppercase tracking-wider">
                    Remaining Today
                </p>
                <p id="remainingSummary"
                class="font-headline-md text-headline-md text-on-surface mt-0.5">
                    0
                </p>
            </div>
        </div>
    </div>

    <div class="bg-surface-container-lowest rounded-xl p-space-md shadow-sm">
        <div class="flex items-center gap-3">
            <div class="p-2 rounded-lg bg-surface-container-low text-primary">
                <span class="material-symbols-outlined">schedule</span>
            </div>
            <div>
                <p class="font-label-sm text-label-sm text-outline uppercase tracking-wider">
                    Scheduled
                </p>
                <p id="scheduledSummary"
                   class="font-headline-md text-headline-md text-on-surface mt-0.5">
                    0
                </p>
            </div>
        </div>
    </div>
</div>


</div>

<!-- Create Diary Modal -->
<div id="createDiaryModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4" role="dialog" aria-modal="true" aria-labelledby="createDiaryModalTitle">
    <div class="w-full max-w-3xl max-h-[90vh] overflow-hidden rounded-2xl bg-surface-container-lowest shadow-xl flex flex-col">

        <!-- Modal Header -->
        <div class="flex items-center justify-between border-b border-outline-variant p-5 shrink-0">
            <div>
                <h2 id="createDiaryModalTitle" class="font-headline-md text-headline-md text-on-surface">
                    Create Diary
                </h2>
                <p class="mt-1 text-sm text-on-surface-variant">
                    Add a diary entry for one of your assigned classes and subjects.
                </p>
            </div>

            <button
                type="button"
                id="closeCreateDiaryModal"
                class="rounded-lg p-2 text-on-surface-variant hover:bg-surface-container"
                aria-label="Close modal"
            >
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <form id="createDiaryForm" class="flex flex-col min-h-0">

            <!-- Modal Body -->
            <div class="grid grid-cols-1 gap-4 p-5 sm:grid-cols-2 overflow-y-auto">

                <div class="sm:col-span-2">
                    <label
                        for="diaryAssignment"
                        class="mb-1 block text-sm font-medium text-on-surface"
                    >
                        Subject / Class / Section *
                    </label>

                    <select
                        id="diaryAssignment"
                        name="teacher_assignment_id"
                        required
                        class="w-full rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface"
                    >
                        <option value="">Select subject, class & section</option>
                    </select>

                    <p class="mt-1 text-xs text-on-surface-variant">
                        Only your assigned subjects, classes and sections are available.
                    </p>
                </div>

                <div>
                    <label
                        for="diaryDate"
                        class="mb-1 block text-sm font-medium text-on-surface"
                    >
                        Diary Date *
                    </label>

                    <input
                        type="date"
                        id="diaryDate"
                        name="diary_date"
                        required
                        class="w-full rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface"
                    >
                </div>

                <div>
                    <label
                        for="diaryDueDate"
                        class="mb-1 block text-sm font-medium text-on-surface"
                    >
                        Due Date
                    </label>

                    <input
                        type="date"
                        id="diaryDueDate"
                        name="due_date"
                        class="w-full rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface"
                    >
                </div>

                <div class="sm:col-span-2 mt-2 border-t border-outline-variant pt-4">
                    <h3 class="font-semibold text-on-surface">Diary Details</h3>
                    <p class="mt-1 text-sm text-on-surface-variant">
                        Enter the classwork, homework and any instructions for students.
                    </p>
                </div>

                <div class="sm:col-span-2">
                    <label
                        for="diaryClasswork"
                        class="mb-1 block text-sm font-medium text-on-surface"
                    >
                        Classwork
                    </label>

                    <textarea
                        id="diaryClasswork"
                        name="classwork"
                        rows="3"
                        placeholder="Enter today's classwork"
                        class="w-full resize-none rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface"
                    ></textarea>
                </div>

                <div class="sm:col-span-2">
                    <label
                        for="diaryHomework"
                        class="mb-1 block text-sm font-medium text-on-surface"
                    >
                        Homework
                    </label>

                    <textarea
                        id="diaryHomework"
                        name="homework"
                        rows="3"
                        placeholder="Enter homework"
                        class="w-full resize-none rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface"
                    ></textarea>
                </div>

                <div class="sm:col-span-2">
                    <label
                        for="diaryInstructions"
                        class="mb-1 block text-sm font-medium text-on-surface"
                    >
                        Instructions
                    </label>

                    <textarea
                        id="diaryInstructions"
                        name="instructions"
                        rows="2"
                        placeholder="Enter any additional instructions"
                        class="w-full resize-none rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface"
                    ></textarea>
                </div>

                <div>
                    <label
                        for="diaryStatus"
                        class="mb-1 block text-sm font-medium text-on-surface"
                    >
                        Status *
                    </label>

                    <select
                        id="diaryStatus"
                        name="status"
                        required
                        class="w-full rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface"
                    >
                        <option value="draft">Draft</option>
                        <option value="published">Published</option>
                        <option value="scheduled">Scheduled</option>
                    </select>
                </div>

                <div id="scheduledAtGroup" class="hidden">
                    <label
                        for="diaryScheduledAt"
                        class="mb-1 block text-sm font-medium text-on-surface"
                    >
                        Scheduled At *
                    </label>

                    <input
                        type="datetime-local"
                        id="diaryScheduledAt"
                        name="scheduled_at"
                        class="w-full rounded-lg border border-outline-variant bg-surface px-3 py-2 text-on-surface"
                    >
                </div>

            </div>

            <!-- Error -->
            <div
                id="createDiaryError"
                class="hidden mx-5 mb-4 rounded-lg bg-red-50 p-3 text-sm text-red-700"
                role="alert"
            ></div>

            <!-- Modal Footer -->
            <div class="flex justify-end gap-3 border-t border-outline-variant p-5 shrink-0 bg-surface-container-lowest">

                <button
                    type="button"
                    id="cancelCreateDiary"
                    class="rounded-lg border border-outline-variant px-4 py-2 text-sm font-medium text-on-surface hover:bg-surface-container"
                >
                    Cancel
                </button>

                <button
                    type="submit"
                    id="saveCreateDiary"
                    class="rounded-lg bg-primary px-5 py-2 text-sm font-semibold text-white hover:opacity-90 disabled:cursor-not-allowed disabled:opacity-60"
                >
                    Create Diary
                </button>

            </div>

        </form>
    </div>
</div>
<!-- Center Popup Modal (Initial View) -->
<div id="announcementPopup" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4">
    <div class="w-full max-w-lg rounded-2xl bg-white p-6 shadow-2xl border border-slate-200 text-slate-800 relative animate-scale-up">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3 mb-4">
            <div class="flex items-center gap-2 text-amber-600">
                <span class="material-symbols-outlined">campaign</span>
                <h3 class="font-bold text-slate-800 text-sm">Today's Important Announcement</h3>
            </div>
            <button type="button" onclick="minimizeAnnouncement()" class="text-slate-400 hover:text-slate-600">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <div class="py-2">
            <p id="popupMessageContent" class="text-sm text-slate-700 leading-relaxed whitespace-pre-line"></p>
        </div>
        <div class="flex justify-end pt-3 border-t border-slate-100">
            <button type="button" onclick="minimizeAnnouncement()" class="px-4 py-2 rounded-xl bg-primary text-xs font-semibold text-white hover:brightness-110">Got it</button>
        </div>
    </div>
</div>

<!-- Floating Side Icon (Minimized View) -->
<button id="floatingAnnouncementIcon" onclick="openAnnouncementPopup()" class="fixed bottom-6 right-6 z-40 hidden flex items-center gap-2 rounded-full bg-secondary px-4 py-3 text-white shadow-lg hover:brightness-110 transition animate-bounce">
    <span class="material-symbols-outlined text-xl">campaign</span>
</button>
<script>
(async() => {
    const token = localStorage.getItem('student_diary_token');

    if (!token) {
        const code = localStorage.getItem('student_diary_institute_code');
        window.location.href = code ? `/login/${code}` : '/';
        return;
    }

    const headers = {
        'Authorization': `Bearer ${token}`,
        'Accept': 'application/json'
    };

    const fetchApi = async (endpoint) => {
        const response = await fetch(endpoint, { headers });

        if (response.status === 401) {
            localStorage.removeItem('student_diary_token');
            localStorage.removeItem('student_diary_user');
            localStorage.removeItem('student_diary_institute_code');
            window.location.href = '/';
            return null;
        }

        if (!response.ok) {
            throw new Error(`Request failed: ${response.status}`);
        }

        return response.json();
    };

    const escapeHtml = (value) => {
        const div = document.createElement('div');
        div.textContent = value ?? '';
        return div.innerHTML;
    };

    const getUser = () => {
        try {
            return JSON.parse(localStorage.getItem('student_diary_user') || '{}');
        } catch {
            return {};
        }
    };

    const setGreeting = () => {
        const user = getUser();
        const name = user.name || 'Teacher';
        const hour = new Date().getHours();
        const greeting = hour < 12 ? 'Good morning' : hour < 18 ? 'Good afternoon' : 'Good evening';

        document.getElementById('teacherGreeting').textContent =
            `${greeting}, ${name}`;
    };

    const statusBadge = (status) => {
        const value = String(status || '').toLowerCase();

        if (value === 'published') {
            return `
                <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded-full
                             bg-surface-container text-secondary
                             font-label-sm text-label-sm font-semibold">
                    <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span>
                    Published
                </span>
            `;
        }

        if (value === 'scheduled') {
            return `
                <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded-full
                             bg-surface-container-low text-primary
                             font-label-sm text-label-sm font-semibold">
                    <span class="w-1.5 h-1.5 rounded-full bg-primary"></span>
                    Scheduled
                </span>
            `;
        }

        return `
            <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded-full
                         bg-surface-container-low text-on-surface-variant
                         font-label-sm text-label-sm font-semibold">
                <span class="w-1.5 h-1.5 rounded-full bg-outline"></span>
                Draft
            </span>
        `;
    };

    const renderDiaries = (diaries) => {
        const container = document.getElementById('recentDiaries');

        if (!diaries.length) {
            container.innerHTML = `
                <tr>
                    <td colspan="4" class="px-4 py-10 text-center">
                        <div class="flex flex-col items-center gap-2 text-on-surface-variant">
                            <span class="material-symbols-outlined text-[32px]">menu_book</span>
                            <span class="font-body-sm text-body-sm">
                                No diary entries found.
                            </span>
                        </div>
                    </td>
                </tr>
            `;
            return;
        }

        container.innerHTML = diaries.map(diary => `
            <tr class="border-t border-outline-variant hover:bg-surface-container-low transition-colors">
                <td class="px-4 py-3">
                    <div class="font-label-md text-label-md text-on-surface font-semibold">
                        ${escapeHtml(diary.subject?.name || '—')}
                    </div>
                    <div class="font-body-sm text-body-sm text-on-surface-variant mt-0.5">
                        ${escapeHtml(diary.classwork || 'No classwork added')}
                    </div>
                </td>

                <td class="px-4 py-3">
                    <div class="font-label-md text-label-md text-on-surface">
                        ${escapeHtml(diary.class?.name || '—')}
                    </div>
                    <div class="font-body-sm text-body-sm text-on-surface-variant">
                        ${escapeHtml(diary.section?.name || '—')}
                    </div>
                </td>

                <td class="px-4 py-3">
                    <span class="font-body-sm text-body-sm text-on-surface">
                        ${escapeHtml(diary.diary_date || '—')}
                    </span>
                </td>

                <td class="px-4 py-3">
                    ${statusBadge(diary.status)}
                </td>
            </tr>
        `).join('');

        document.getElementById('diaryFooter').classList.remove('hidden');
    };

    const renderAssignments = (assignments) => {
        const container = document.getElementById('assignmentList');

        if (!assignments.length) {
            container.innerHTML = `
                <div class="p-4 rounded-lg bg-surface-container-low text-center">
                    <span class="material-symbols-outlined text-primary">assignment</span>
                    <p class="font-body-sm text-body-sm text-on-surface-variant mt-1">
                        No assignments found.
                    </p>
                </div>
            `;
            return;
        }

        container.innerHTML = assignments.slice(0, 5).map(assignment => `
            <div class="p-3 rounded-lg bg-surface-container-low">
                <div class="flex items-center justify-between gap-2">
                    <span class="font-label-md text-label-md text-on-surface font-semibold">
                        ${escapeHtml(assignment.subject?.name || '—')}
                    </span>
                    <span class="font-label-sm text-label-sm text-primary">
                        ${assignment.status ? 'Active' : 'Inactive'}
                    </span>
                </div>

                <div class="font-body-sm text-body-sm text-on-surface-variant mt-1">
                    ${escapeHtml(assignment.class?.name || '—')}
                    · Section ${escapeHtml(assignment.section?.name || '—')}
                </div>
            </div>
        `).join('');
    };
        let teacherAssignments = [];

    const getLocalDate = () => {
        const date = new Date();
        return `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}-${String(date.getDate()).padStart(2, '0')}`;
    };

    const loadAvailableDiaryAssignments = async () => {
    const select = document.getElementById('diaryAssignment');
    const diaryDate = document.getElementById('diaryDate').value;

    select.innerHTML = '<option value="">Loading assignments...</option>';
    select.disabled = true;

    if (!diaryDate) {
        select.innerHTML = '<option value="">Select diary date first</option>';
        return;
    }

    try {
        const result = await fetchApi(
            `/api/v1/teacher/diaries/available-assignments?diary_date=${encodeURIComponent(diaryDate)}`
        );

        if (!result) return;

        select.innerHTML = '<option value="">Select subject, class & section</option>';

        if (!result.data?.length) {
            select.innerHTML = '<option value="">No assignments available for this date</option>';
            return;
        }

        result.data.forEach(assignment => {
            const option = document.createElement('option');
            option.value = assignment.id;
            option.textContent =
                `${assignment.subject?.name || 'Unknown Subject'} — ` +
                `${assignment.school_class?.name || assignment.class?.name || 'Unknown Class'} — ` +
                `${assignment.section?.name || 'Unknown Section'}`;

            select.appendChild(option);
        });

        select.disabled = false;
    } catch (error) {
        select.innerHTML = '<option value="">Unable to load assignments</option>';
        console.error('Available assignments error:', error);
    }
};

    const showCreateDiaryError = (message) => {
        const errorBox = document.getElementById('createDiaryError');
        errorBox.textContent = message;
        errorBox.classList.remove('hidden');
    };

    const clearCreateDiaryError = () => {
        const errorBox = document.getElementById('createDiaryError');
        errorBox.textContent = '';
        errorBox.classList.add('hidden');
    };

    const openCreateDiaryModal = () => {
        const modal = document.getElementById('createDiaryModal');
        const form = document.getElementById('createDiaryForm');

        form.reset();
        clearCreateDiaryError();

        document.getElementById('diaryDate').value = getLocalDate();
        document.getElementById('scheduledAtGroup').classList.add('hidden');
        document.getElementById('diaryScheduledAt').value = '';

        loadAvailableDiaryAssignments();

        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    };

    const closeCreateDiaryModal = () => {
        document.getElementById('createDiaryModal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    };

    document.getElementById('openCreateDiaryModal').addEventListener('click', event => {
        event.preventDefault();
        openCreateDiaryModal();
    });

    document.getElementById('openCreateDiaryModalShortcut').addEventListener('click', event => {
        event.preventDefault();
        openCreateDiaryModal();
    });

    document.getElementById('closeCreateDiaryModal').addEventListener('click', closeCreateDiaryModal);
    document.getElementById('cancelCreateDiary').addEventListener('click', closeCreateDiaryModal);
    document.getElementById('createDiaryModal').addEventListener('click', event => {
        if (event.target === event.currentTarget) {
            closeCreateDiaryModal();
        }
    });
    document.getElementById('diaryDate').addEventListener('change', loadAvailableDiaryAssignments);
    document.getElementById('diaryStatus').addEventListener('change', event => {
        const scheduledGroup = document.getElementById('scheduledAtGroup');
        const scheduledInput = document.getElementById('diaryScheduledAt');

        if (event.target.value === 'scheduled') {
            scheduledGroup.classList.remove('hidden');
            scheduledInput.required = true;
        } else {
            scheduledGroup.classList.add('hidden');
            scheduledInput.required = false;
            scheduledInput.value = '';
        }
    });

    document.getElementById('createDiaryForm').addEventListener('submit', async event => {
        event.preventDefault();

        const form = event.currentTarget;
        const saveButton = document.getElementById('saveCreateDiary');
        const status = document.getElementById('diaryStatus').value;
        const scheduledAt = document.getElementById('diaryScheduledAt').value;

        clearCreateDiaryError();

        if (!form.teacher_assignment_id.value) {
            showCreateDiaryError('Please select a subject, class and section.');
            return;
        }

        if (status === 'scheduled') {
            if (!scheduledAt) {
                showCreateDiaryError('Please select the scheduled date and time.');
                return;
            }

            if (new Date(scheduledAt) <= new Date()) {
                showCreateDiaryError('Scheduled date and time must be in the future.');
                return;
            }
        }

        const payload = {
            teacher_assignment_id: Number(form.teacher_assignment_id.value),
            diary_date: form.diary_date.value,
            classwork: form.classwork.value.trim() || null,
            homework: form.homework.value.trim() || null,
            instructions: form.instructions.value.trim() || null,
            due_date: form.due_date.value || null,
            status,
            scheduled_at: status === 'scheduled' ? scheduledAt : null
        };

        const originalButton = saveButton.innerHTML;

        saveButton.disabled = true;
        saveButton.innerHTML = `
            <span class="material-symbols-outlined animate-spin text-[18px]">progress_activity</span>
            Saving...
        `;

        try {
            const response = await fetch('/api/v1/teacher/diaries', {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(payload)
            });

            const result = await response.json();

            if (response.status === 401) {
                localStorage.removeItem('student_diary_token');
                localStorage.removeItem('student_diary_user');
                localStorage.removeItem('student_diary_institute_code');
                window.location.href = '/';
                return;
            }

            if (!response.ok) {
                const validationErrors = result.errors
                    ? Object.values(result.errors).flat().join(' ')
                    : result.message || 'Failed to create diary.';

                throw new Error(validationErrors);
            }

            closeCreateDiaryModal();
            window.location.reload();

        } catch (error) {
            showCreateDiaryError(error.message);
        } finally {
            saveButton.disabled = false;
            saveButton.innerHTML = originalButton;
        }
    });

    document.addEventListener('keydown', event => {
        if (
            event.key === 'Escape' &&
            !document.getElementById('createDiaryModal').classList.contains('hidden')
        ) {
            closeCreateDiaryModal();
        }
    });
    async function checkTodayAnnouncement() {
        try {
            const response = await fetch('/api/v1/user/active-announcement', {
                headers: { 'Accept': 'application/json', 'Authorization': `Bearer ${token}` }
            });
            const result = await response.json();
            if (response.ok && result.data && result.data.message) {
                const msgBox = document.getElementById('popupMessageContent');
                if (msgBox) msgBox.textContent = result.data.message;
                const user = JSON.parse(localStorage.getItem('student_diary_user') || '{}');
                const userId = user.id || 'guest';
                const todayDate = new Date().toISOString().split('T')[0];
                const dismissedDate = localStorage.getItem(`announcement_dismissed_date_${userId}`);
                
                if (dismissedDate !== todayDate) {
                    document.getElementById('announcementPopup')?.classList.remove('hidden');
                } else {
                    document.getElementById('floatingAnnouncementIcon')?.classList.remove('hidden');
                }
            }
        } catch (err) {
            console.error('Failed to load announcement', err);
        }
    }
    try {
        setGreeting();

        const [assignmentsResult, diariesResult] = await Promise.all([
            fetchApi('/api/v1/teacher/assignments'),
            fetchApi('/api/v1/teacher/diaries')
        ]);
        console.log('ASSIGNMENTS API:', assignmentsResult);
        console.log('DIARIES API:', diariesResult);

        if (!assignmentsResult || !diariesResult) return;
        teacherAssignments = assignmentsResult.data || [];
        loadAvailableDiaryAssignments();

        const assignmentStats = assignmentsResult.statistics || {};
        const diaryStats = diariesResult.statistics || {};

        document.getElementById('classCount').textContent =
            assignmentStats.classes ?? 0;

        document.getElementById('assignmentCount').textContent =
            assignmentStats.total ?? 0;

        document.getElementById('todayRemaining').textContent =
            diaryStats.remaining ?? 0;

        document.getElementById('scheduledCount').textContent =
            diaryStats.scheduled ?? 0;

        document.getElementById('publishedSummary').textContent =
            diaryStats.published ?? 0;

        document.getElementById('remainingSummary').textContent =
            diaryStats.remaining ?? 0;

        document.getElementById('scheduledSummary').textContent =
            diaryStats.scheduled ?? 0;

        const session = assignmentsResult.current_session;

        document.getElementById('sessionName').textContent =
            session?.name || 'No active session';

        renderDiaries(diariesResult.data?.data || diariesResult.data || []);
        renderAssignments(assignmentsResult.data || []);
        await checkTodayAnnouncement();
        setInterval(async () => {
        try {
            const diariesResult = await fetchApi('/api/v1/teacher/diaries');

            if (!diariesResult) return;

            const diaryStats = diariesResult.statistics || {};

            document.getElementById('todayPublished').textContent =
                diaryStats.published ?? 0;

            document.getElementById('todayRemaining').textContent =
                diaryStats.remaining ?? 0;

            document.getElementById('scheduledCount').textContent =
                diaryStats.scheduled ?? 0;

            document.getElementById('publishedSummary').textContent =
                diaryStats.published ?? 0;

            document.getElementById('remainingSummary').textContent =
                diaryStats.remaining ?? 0;

            document.getElementById('scheduledSummary').textContent =
                diaryStats.scheduled ?? 0;

            renderDiaries(diariesResult.data?.data || diariesResult.data || []);
        } catch (error) {
            console.error('Dashboard refresh error:', error);
        }
    }, 10000);

    } catch (error) {
        console.error('Teacher dashboard error:', error);

        document.getElementById('recentDiaries').innerHTML = `
            <tr>
                <td colspan="4" class="px-4 py-8 text-center text-on-surface-variant">
                    Unable to load dashboard data.
                </td>
            </tr>
        `;

        document.getElementById('assignmentList').innerHTML = `
            <div class="p-3 rounded-lg bg-surface-container-low text-center
                        font-body-sm text-body-sm text-on-surface-variant">
                Unable to load assignments.
            </div>
        `;
    }
})();
function minimizeAnnouncement() {
    document.getElementById('announcementPopup')?.classList.add('hidden');
    document.getElementById('floatingAnnouncementIcon')?.classList.remove('hidden');
    const user = JSON.parse(localStorage.getItem('student_diary_user') || '{}');
    const userId = user.id || 'guest';
    const todayDate = new Date().toISOString().split('T')[0];
    localStorage.setItem(`announcement_dismissed_date_${userId}`, todayDate);
}

function openAnnouncementPopup() {
    document.getElementById('floatingAnnouncementIcon')?.classList.add('hidden');
    document.getElementById('announcementPopup')?.classList.remove('hidden');
}
</script>

@endsection
